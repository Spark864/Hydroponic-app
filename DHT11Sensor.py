import adafruit_dht
import time
import board
from datetime import datetime

import mysql.connector

dhtDevice = adafruit_dht.DHT11(board.D4)
mydb = mysql.connector.connect(
    host="localhost",
    user="root",
    password="ernest123",
    database="greenhouse"
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
            sql ="INSERT INTO DataCollect (temperature, humidity, date) VALUES (%s, %s, %s)"
            val=(temperature, humidity, now)
            mycursor.execute(sql,val)
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
    

