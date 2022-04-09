import adafruit_dht
import time
import board
from datetime import datetime
import urllib.parse
import psycopg2
import time
import board
import busio
import adafruit_ads1x15.ads1015 as ADS
from adafruit_ads1x15.analog_in import AnalogIn

# Create the I2C bus
from DFRobot_PH import DFRobot_PH

i2c = busio.I2C(board.SCL, board.SDA)

# Create the ADC object using the I2C bus
ads = ADS.ADS1015(i2c)

# Create single-ended input on channel 0,1,2 on ADC1115
# read analog sign ppm sensor in channel 0
chanppm = AnalogIn(ads, ADS.P0)
# read analog sign sunlight intensity sensor in channel 1
chansun = AnalogIn(ads, ADS.P1)
# read analog sign ph sensor in channel 2
chanph = AnalogIn(ads, ADS.P2)

# Create differential input between channel 0 and 1
# chan = AnalogIn(ads, ADS.P0, ADS.P1)

# print("{:>5}\t{:>5}".format('raw', 'v'))

VREF = 5.0
analogBuffer = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
analogBufferTemp = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
analogBufferIndex = 0
copyIndex = 0
averageVoltage = 0
tdsValue = 0
temperature = 25

#get median from analogBufferTemp
def getMedianNum(iFilterLen):
    global analogBufferTemp
    bTemp = 0.0
    for j in range(iFilterLen - 1):
        for i in range(iFilterLen - j - 1):
            if analogBufferTemp[i] > analogBufferTemp[i + 1]:
                bTemp = analogBufferTemp[i]
                analogBufferTemp[i] = analogBufferTemp[i + 1]
                analogBufferTemp[i + 1] = bTemp
    if iFilterLen & 1 > 0:
        bTemp = analogBufferTemp[(iFilterLen - 1) / 2]
    else:
        bTemp = (analogBufferTemp[iFilterLen / 2] + analogBufferTemp[iFilterLen / 2 - 1]) / 2
    return float(bTemp)


analogSampleTimepoint = time.time()
printTimepoint = time.time()

ph = DFRobot_PH()
#use pin 33 on raspberrypi for DHT11 sensor
dhtDevice = adafruit_dht.DHT11(board.D13)
#connect to posGres db on heroku
url = urllib.parse.urlparse(
    "postgres://nhchgncqtdohmw:44f34a07049a26867f87219d2591a73ba66b665048b3c11b6e9b8e10269c476a@ec2-54-147-93-73.compute-1.amazonaws.com:5432/d29h2tvqmjhdqj")
mydb = psycopg2.connect(
    host=url.hostname,
    user=url.username,
    password=url.password,
    database=url.path[1:]
)
#set time format
time.strftime("%d/%m/%Y %H:%M:%S")
#loop every 5 seconds
while True:
    try:
        # get temperature and humidity from DHT11
        humidity, temperature = dhtDevice.temperature, dhtDevice.humidity
        if humidity is not None and temperature is not None:
            print("Temp={0:0.1f}C Humidity={1:0.1f}%".format(temperature, humidity))
            # print sunlight intensity
            # sunlight intensity is voltage from digital signal in channel 1 for ADC1115
            print("{:>5}\t{:>5.3f}".format(chanppm.value, chansun.voltage))
            #calculate ppm
            if time.time() - analogSampleTimepoint > 0.04:
                # print(" test.......... ")
                analogSampleTimepoint = time.time()
                analogBuffer[analogBufferIndex] = chanppm.voltage
                analogBufferIndex = analogBufferIndex + 1
                if analogBufferIndex == 30:
                    analogBufferIndex = 0
            tdsValue
            if time.time() - printTimepoint > 0.8:
                # print(" test ")
                printTimepoint = time.time()
                for copyIndex in range(30):
                    analogBufferTemp[copyIndex] = chanppm.voltage
                print(" A1:%dmV " % getMedianNum(30))
                averageVoltage = getMedianNum(30) * (VREF / 1024.0)
                compensationCoefficient = 1.0 + 0.02 * (temperature - 25.0)
                compensationVolatge = averageVoltage / compensationCoefficient
                tdsValue = (
                                   133.42 * compensationVolatge * compensationVolatge * compensationVolatge - 255.86 * compensationVolatge * compensationVolatge + 857.39 * compensationVolatge) * 0.5
                print(" A1:%dppm " % tdsValue)

            # Read your temperature sensor to execute temperature compensation
            # temperature = 25
            # Get the Digital Value of Analog of selected channel
            adc0 = chanph.voltage
            # Convert voltage to PH with temperature compensation
            # use the provided code from Dfrobot Github to use Dfrobot Gravity PH SensorV2
            # get ph from voltage and temperature
            PH = ph.read_PH(chanph.voltage, temperature)
            print("Temperature:%.1f ^C PH:%.2f" % (temperature, PH))
            #get todays time
            now = datetime.now()
            dt_string = now.strftime("%d/%m/%Y %H:%M:%S")
            print("date and time =", dt_string)
            #insert humidity, temperature, ph, ppm, sunlight intensity into posGres db in Heroku
            mycursor = mydb.cursor()
            sql = "INSERT INTO DataCollect (temperature, humidity, date, ph, ppm, lum) VALUES (%s, %s, %s, %s, %s, %s)"
            val = (temperature, humidity, now, PH, tdsValue, chansun.voltage)
            mycursor.execute(sql, val)
            mydb.commit()
            print(mycursor.rowcount, "record inserted")
            mycursor.execute("SELECT * FROM DataCollect")

            myresult = mycursor.fetchall()
            #print all tuples in datacollect table
            for x in myresult:
                print(x)
        else:
            # Reading doesn't always work! Just print error and try again
            print("Sensor failure. Check wiring.")
    except RuntimeError as e:
        print('Reading from DHT failure: ', e.args)
    time.sleep(5)
