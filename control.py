import time
import urllib.parse
import psycopg2
import threading
import RPi.GPIO as GPIO

from datetime import datetime, timedelta

url = urllib.parse.urlparse(
    "postgres://nhchgncqtdohmw:44f34a07049a26867f87219d2591a73ba66b665048b3c11b6e9b8e10269c476a@ec2-54-147-93-73.compute-1.amazonaws.com:5432/d29h2tvqmjhdqj")
mydb = psycopg2.connect(
    host=url.hostname,
    user=url.username,
    password=url.password,
    database=url.path[1:]
)
mycursor = mydb.cursor()
mycursor2 = mydb.cursor()

GPIO.setwarnings(False)
GPIO.setmode(GPIO.BOARD)
GPIO.setup(36, GPIO.OUT, initial=GPIO.LOW) #Wp1
GPIO.setup(40, GPIO.OUT, initial=GPIO.LOW) #Wp2
GPIO.setup(32, GPIO.OUT, initial=GPIO.LOW) #Wp3
GPIO.setup(29, GPIO.OUT, initial=GPIO.LOW) #LED


class Control:
    # WP1 On/Off
    def __init__(self):
        self.stop_wp1 = False
        self.stop_wp2 = False
        self.stop_wp3 = False
        self.stop_led = False
        self.ledstatus = False
        self.thled = threading.Thread(target=self.runled)
        self.thwp3 = threading.Thread(target=self.runwp3)
        self.thwp2 = threading.Thread(target=self.runwp2)
        self.thwp1 = threading.Thread(target=self.runwp1)
        self.durationwp = 0
        self.durationwp3 = 0
        self.durationled = 0
        self.currtemp = 0
        self.settemp = 0
        self.mode = 0
        # Run Wp1 Thread
    def runwp1(self):

        dur1 = int(self.durationwp) * 60

        print("duration of Wp1: ", dur1)
        count = 0
        status = True
        ##turn on the Water pump 1
        GPIO.output(36, GPIO.HIGH)

        while status:
            print('Wp1 is high')
            if count == dur1:
                print('Wp1 Count Done')
                status = False
            if self.stop_wp1:
                print('Wp1 thread killed by users')
                status = False
            count += 1
            time.sleep(1)
            # print(threading.active_count())
            # print(threading.get_ident())

        ##turn off the Water pump 1
        GPIO.output(36, GPIO.LOW)

        sql = "Update controlpanel SET action = 'Off' Where id = 1"
        mycursor2.execute(sql)
        mydb.commit()
        self.stop_wp1 = False
        self.ledstatus = False

    # Run Wp2 Thread
    def runwp2(self):

        dur2 = int(self.durationwp) * 60
        print("dur: ", dur2)
        count = 0
        status = True

        ##turn on the Water pump 2
        GPIO.output(40, GPIO.HIGH)
        while status:
            print('Wp2 is high')

            if count == dur2:
                print('WP2 Done')
                status = False
            if self.stop_wp2:
                print('Wp2 thread killed')
                status = False
            count += 1
            time.sleep(1)

        ##turn off the Water pump 2
        GPIO.output(40, GPIO.LOW)

        sql = "Update controlpanel SET action = 'Off' Where id = 2"
        mycursor2.execute(sql)
        mydb.commit()
        self.stop_wp2 = False

    # Run Wp3 Thread
    def runwp3(self):


        dur3 = int(self.durationwp3) * 60

        print("dur: ", dur3)
        count = 0
        status = True

        ##turn on the Water pump 3
        GPIO.output(32, GPIO.HIGH)

        while status:
            print('wp3 is high')

            if count == dur3:
                print('Wp3 Done')
                status = False
            if self.stop_wp3:
                print('Wp3 thread killed')
                status = False
            count += 1
            time.sleep(1)

        ##turn off the Water pump 3
        GPIO.output(32, GPIO.LOW)

        sql = "Update controlpanel SET action = 'Off' Where id = 12"
        mycursor2.execute(sql)
        mydb.commit()
        self.stop_wp3 = False

    # Run LED Thread
    def runled(self):

        dur = int(self.durationled) * 60
        print("dur: ", dur)
        count = 0
        status = True

        ##turn on the LED first
        
        GPIO.output(29, GPIO.HIGH)
        # Check led mode



        # ledmode = int(self.mode)
        # if ledmode == 2 and not self.ledstatus:
        #     ## 1 click for switching to mode 1
        #     # GPIO.output(31, GPIO.HIGH)
        #     # GPIO.output(31, GPIO.LOW)
        #
        #     # Update the db
        #     sql = "Update controlpanel SET action = 1 Where id = 19"
        #     mycursor2.execute(sql)
        #     mydb.commit()
        #     print("change to mode 1")
        #
        # if ledmode == 1 and self.ledstatus:
        #     ## 2 clicks for switching to mode 2
        #     # GPIO.output(31, GPIO.HIGH)
        #     # GPIO.output(31, GPIO.LOW)
        #     #time.sleep(1)
        #     # GPIO.output(31, GPIO.HIGH)
        #     # GPIO.output(31, GPIO.LOW)
        #
        #     # Update the db
        #     sql = "Update controlpanel SET action = 2 Where id = 19"
        #     mycursor2.execute(sql)
        #     mydb.commit()
        #     print("change to mode 2")


     
        while status:
            print("while loop status", status)
            print('LED is high')
            # print(self.ledstatus)
            # problem from ledstatus
            if count == dur and not self.ledstatus:
                print('LED is low')
                status = False
                break
            if self.stop_led:
                print('LED is low2')
                status = False
                break
            count += 1
            if self.ledstatus:
                print("current temperature: ", self.currtemp)
                if float(self.settemp) < float(self.currtemp):
                    print('Temperature is ok')
                    status = False
                    break
                count -=1
                time.sleep(10)
            time.sleep(1)
            # print(threading.active_count())
        # print(threading.active_count())

        ##turn off the LED

        
        GPIO.output(29, GPIO.LOW)

        print("status2", status)
        sql = "Update controlpanel SET action = 'Off' Where id = 15"
        mycursor2.execute(sql)
        mydb.commit()
        # self.thled.join()
        self.stop_led = False
        self.ledstatus = False
        print('LED thread killed')
        time.sleep(1)

    def check(self):


        mycursor.execute("SELECT action FROM controlpanel where id = 1")
        x = mycursor.fetchone()
        # print("wp1: " , x)
        wp1 = x[0]
        print("Water Pump 1 status: ", wp1)

        mycursor.execute("SELECT action FROM controlpanel where id = 2")
        x = mycursor.fetchone()
        #print("wp2: " , x)
        wp2 = x[0]
        print("Water Pump 2 status: ", wp2)

        mycursor.execute("SELECT action FROM controlpanel where id = 12")
        x = mycursor.fetchone()
        # print("wp3: " , x)
        wp3 = x[0]
        print("Water Pump 3 status: ", wp3)

        mycursor.execute("SELECT action FROM controlpanel where id = 15")
        x = mycursor.fetchone()
        # print("ledStatus: " , x)
        led = x[0]
        print("LED status: ", led)

        mycursor.execute("SELECT action FROM controlpanel where id = 5")
        x = mycursor.fetchone()
        # print("timer wp1: " , x)
        twp1 = x[0]
        print("Timer Water Pump 1 status: ", twp1)

        mycursor.execute("SELECT action FROM controlpanel where id = 6")
        x = mycursor.fetchone()
        # print("timer wp2: " , x)
        twp2 = x[0]
        print("Timer Water Pump 1 status: ", twp2)

        mycursor.execute("SELECT action FROM controlpanel where id = 26")
        x = mycursor.fetchone()
        # print("timer wp3: " , x)
        twp3 = x[0]
        print("Timer Water Pump 1 status: ", twp3)

        mycursor.execute("SELECT action FROM controlpanel where id = 20")
        x = mycursor.fetchone()
        # print("timer LED status: " , x)
        tled = x[0]
        print("Timer LED status: ", tled)

        mycursor.execute("SELECT temperature FROM datacollect Order by id desc limit 1")
        x = mycursor.fetchone()
        # print("Last temperture", x)
        self.currtemp = x[0]
        print("Last Temperature: ", self.currtemp)

        mycursor.execute("SELECT action FROM controlpanel where id = 16")
        x = mycursor.fetchone()
        # print("present tem", x)
        self.settemp = x[0]
        print("Preset Temperature: ", self.settemp)

        mycursor.execute("SELECT action FROM controlpanel where id = 19")
        x = mycursor.fetchone()
        # print("led mode", x)
        self.mode = x[0]

        mycursor.execute("SELECT action FROM controlpanel where id = 17")
        x = mycursor.fetchone()
        # print("duration led", x)
        self.durationled = x[0]

        mycursor.execute("SELECT action FROM controlpanel where id = 3")
        x = mycursor.fetchone()
        #  print("duration wp12", x)
        self.durationwp = x[0]

        mycursor.execute("SELECT action FROM controlpanel where id = 13")
        x = mycursor.fetchone()
        # print("duration wp3", x)
        self.durationwp3 = x[0]

        # print(threading.active_count())

        # Wp1 On/Off
        if wp1 == "On" and not self.thwp1.is_alive():
            # print(threading.active_count())
            print(self.thwp1.is_alive())
            self.stop_wp1 = False
            self.thwp1 = threading.Thread(target=self.runwp1)
            self.thwp1.start()
            print("Open Wp1 thread")
            #time.sleep(1)
        if wp1 == "Off":
            print("No Wp1 thread running")
            self.stop_wp1 = True



        # Wp2 On/Off
        if wp2 == "On" and not self.thwp2.is_alive():
            self.stop_wp2 = False
            self.thwp2 = threading.Thread(target=self.runwp2)
            self.thwp2.start()
            print("Open Wp2 thread")
            #time.sleep(1)
        if wp2 == "Off":
            print("No Wp2 thread running")
            self.stop_wp2 = True
            time.sleep(1)

        # Wp3 On/Off
        if wp3 == "On" and not self.thwp3.is_alive():
            self.stop_wp3 = False
            self.thwp3 = threading.Thread(target=self.runwp3)
            self.thwp3.start()
            print("Open Wp3 thread")
            time.sleep(1)
        if wp3 == "Off":
            print("No Wp3 thread running")
            self.stop_wp3 = True
            time.sleep(1)

        # Compare temperature
        if float(self.settemp) > float(self.currtemp) and not self.ledstatus:
            if led == "Off":
                sql = "Update controlpanel SET action = 'On' Where id = 15"
                mycursor.execute(sql)
                mydb.commit()
            self.stop_led = False
            time.sleep(1)
            self.thled = threading.Thread(target=self.runled)
            self.thled.start()
            self.ledstatus = True
            time.sleep(1)

        # LED On/Off
        if led == "On" and not self.thled.is_alive() and not self.ledstatus:
            self.stop_led = False
            # self.ledstatus = False
            self.thled = threading.Thread(target=self.runled)
            self.thled.start()
            print("Open LED thread")
            time.sleep(1)

        # if self.thled.is_alive():
        #     print("Running led thread")

        if led == "Off" and self.thled.is_alive():
            print("No LED thread running")
            self.stop_led = True

        # Timer of WP1
        if twp1 == "On":
            mycursor.execute("SELECT action FROM controlpanel where id = 4")
            x = mycursor.fetchone()
            freq_1 = x[0]

            frequency = int(freq_1) + 6
            l = []
            # print(frequency)
            mycursor.execute("SELECT time FROM controlpanel where id >= 7 and id <= %s", (frequency,))
            for x in mycursor.fetchall():
                twp1 = x[0]
                l.append(twp1)
                print("Timer Water Pump 1 status: ", twp1)

            # print(l)
            now = datetime.now()
            end = now + timedelta(minutes=1)
            current_time = end.strftime("%H:%M:%S")
            # print(end)
            # print("Now Time: ", current_time)

            def time_in_range(start, end, x):
                #   print(start, end, x)
                """Return true if x is in the range [start, end]"""
                if start <= end:
                    return start <= x <= end
                else:
                    return start <= x or x <= end

            for x in l:
                today = datetime.now().date()
                y = datetime.combine(today, x)
                result = time_in_range(now, end, y)
                if result:
                    mycursor.execute("SELECT action FROM controlpanel where id =1")
                    status = mycursor.fetchone()
                    status_check = status[0]
                    if status_check == "Off":
                        sql = "Update controlpanel SET action = 'On' Where id =1"
                        mycursor.execute(sql)
                        mydb.commit()

            print(result)

        # Timer of WP2
        if twp2 == "On":
            mycursor.execute("SELECT action FROM controlpanel where id = 4")
            x = mycursor.fetchone()
            freq_2 = x[0]

            frequency = int(freq_2) + 6
            l = []
            #print(frequency)
            mycursor.execute("SELECT time FROM controlpanel where id >= 7 and id <= %s", (frequency,))
            for x in mycursor.fetchall():
                twp2 = x[0]
                l.append(twp2)
                #  print("Timer Water Pump 2 status: ", twp2)

            #print(l)
            now = datetime.now()
            end = now + timedelta(seconds=10)
            current_time = end.strftime("%H:%M:%S")
            # print(end)
            # print("Now Time: ", current_time)

            def time_in_range(start, end, x):
                print(start, end, x)
                """Return true if x is in the range [start, end]"""
                if start <= end:
                    return start <= x <= end
                else:
                    return start <= x or x <= end

            for x in l:
                today = datetime.now().date()
                y = datetime.combine(today, x)
                result = time_in_range(now, end, y)
                if result:
                    mycursor.execute("SELECT action FROM controlpanel where id =2")
                    status = mycursor.fetchone()
                    status_check = status[0]
                    if status_check == "Off":
                        sql = "Update controlpanel SET action = 'On' Where id = 2"
                        mycursor.execute(sql)
                        mydb.commit()
            print(result)

        # Timer of WP3
        if twp3 == "On":

            mycursor.execute("SELECT time FROM controlpanel where id = 14")
            for x in mycursor.fetchall():
                twp3 = x[0]
                l.append(twp3)
                #       print("Timer Water Pump 3 status: ", twp3)

            #  print(l)
            now = datetime.now()
            end = now + timedelta(seconds=30)
            current_time = end.strftime("%H:%M:%S")
            #  print(end)
            #  print("Now Time: ", current_time)

            def time_in_range(start, end, x):
                #   print(start, end, x)
                """Return true if x is in the range [start, end]"""
                if start <= end:
                    return start <= x <= end
                else:
                    return start <= x or x <= end

            for x in l:
                today = datetime.now().date()
                y = datetime.combine(today, x)
                result = time_in_range(now, end, y)
                if result:
                    mycursor.execute("SELECT action FROM controlpanel where id = 12")
                    status = mycursor.fetchone()
                    status_check = status[0]
                    if status_check == "Off":
                        sql = "Update controlpanel SET action = 'On' Where id = 12"
                        mycursor.execute(sql)
                        mydb.commit()

            print(result)

        # Timer of LED
        if tled == "On":
            mycursor.execute("SELECT action FROM controlpanel where id = 18")
            x = mycursor.fetchone()
            freq_4 = x[0]
            frequency = int(freq_4) + 20
            l = []
            #  print(frequency)
            mycursor.execute("SELECT time FROM controlpanel where id >= 21 and id <= %s", (frequency,))
            for x in mycursor.fetchall():
                timerled = x[0]
                l.append(timerled)
                #     print("Timer LED status: ", timerled)

            # print(l)
            now = datetime.now()
            end = now + timedelta(seconds=30)
            current_time = end.strftime("%H:%M:%S")
            # print(end)
            # print("Now Time: ", current_time)

            def time_in_range(start, end, x):
                #    print(start, end, x)
                """Return true if x is in the range [start, end]"""
                if start <= end:
                    return start <= x <= end
                else:
                    return start <= x or x <= end

            for x in l:
                today = datetime.now().date()
                y = datetime.combine(today, x)
                result = time_in_range(now, end, y)
                if result:
                    mycursor.execute("SELECT action FROM controlpanel where id = 15")
                    status = mycursor.fetchone()
                    status_check = status[0]
                    if status_check == "Off":
                        sql = "Update controlpanel SET action = 'On' Where id = 15"
                        mycursor.execute(sql)
                        mydb.commit()
            self.ledstatus = False
            print(result)

        time.sleep(10)

    def main(self):
        while True:
            self.check()


program = Control()
program.main()
