import adafruit_dht
import time
import board
from datetime import datetime
import urllib.parse
import psycopg2

dhtDevice = adafruit_dht.DHT11(board.D4)
url = urllib.parse.urlparse("postgres://nhchgncqtdohmw:44f34a07049a26867f87219d2591a73ba66b665048b3c11b6e9b8e10269c476a@ec2-54-147-93-73.compute-1.amazonaws.com:5432/d29h2tvqmjhdqj")
mydb = psycopg2.connect(
    host=url.hostname,
    user=url.username,
    password=url.password,
    database=url.path[1:]
)
time.strftime("%d/%m/%Y %H:%M:%S")

while True:
    try:
        humidity, temperature = dhtDevice.temperature, dhtDevice.humidity
        if humidity is not None and temperature is not None:
            print("Temp={0:0.1f}C Humidity={1:0.1f}%".format(temperature, humidity))
            now = datetime.now()
            dt_string = now.strftime("%d/%m/%Y %H:%M:%S")
            print("date and time =", dt_string)
            mycursor = mydb.cursor()
            sql = "INSERT INTO DataCollect (temperature, humidity, date) VALUES (%s, %s, %s)"
            val = (temperature, humidity, now)
            mycursor.execute(sql, val)
            mydb.commit()
            print(mycursor.rowcount, "record inserted")
            mycursor.execute("SELECT * FROM DataCollect")

            myresult = mycursor.fetchall()

            for x in myresult:
                print(x)
        else:
            # Reading doesn't always work! Just print error and try again
            print("Sensor failure. Check wiring.")
    except RuntimeError as e:
        print('Reading from DHT failure: ', e.args)
    time.sleep(5)
