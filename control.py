import time
import urllib.parse
import psycopg2
import threading
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

# mycursor.execute("SELECT time FROM controlpanel where id = 25 order by id")
# myresult = mycursor.fetchall()
# for x in myresult:
#     print(x)

#while True:
# mycursor.execute("SELECT action FROM controlpanel where id = 1")
# for x in mycursor.fetchall():
#     wp1 = x[0]
#     print(wp1)
#
#
# mycursor.execute("SELECT action FROM controlpanel where id = 2")
# for x in mycursor.fetchall():
#     wp2 = x[0]
#     print(wp2)

class Control:
# WP1 On/Off
    def __init__(self):
        self.stop_wp1 = False
        self.stop_wp2 = False
        self.stop_wp3 = False
        self.stop_led = False
        self.ledstatus = False

    # Run Wp1 Thread
    def runwp1(self):
        global duration
        mycursor.execute("SELECT action FROM controlpanel where id = 3")
        for x in mycursor.fetchall():
            duration = x[0]
        dur1 = int(duration) * 60

        print("dur: ", dur1)
        count = 0
        status = True
        ##turn on the Water pump 1
        while status:
            print('Wp1 is high')
            if count == dur1:
                print('Wp1 Done')
                status = False
            if self.stop_wp1:
                print('Wp1 thread killed')
                status = False
            count += 1
            time.sleep(1)

        ##turn off the Water pump 1

        sql = "Update controlpanel SET action = 'Off' Where id = 1"
        mycursor.execute(sql)
        mydb.commit()
        self.stop_wp1 = False
        self.ledstatus = False

    # Run Wp2 Thread
    def runwp2(self):
        global duration
        mycursor.execute("SELECT action FROM controlpanel where id = 3")
        for x in mycursor.fetchall():
            duration = x[0]
        dur2 = int(duration) * 60

        print("dur: ", dur2)
        count = 0
        status = True
        ##turn on the Water pump 2
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

        sql = "Update controlpanel SET action = 'Off' Where id = 2"
        mycursor.execute(sql)
        mydb.commit()
        self.stop_wp2 = False

    # Run Wp3 Thread
    def runwp3(self):
        global duration
        mycursor.execute("SELECT action FROM controlpanel where id = 13")
        for x in mycursor.fetchall():
            duration = x[0]
        dur3 = int(duration) * 60

        print("dur: ", dur3)
        count = 0
        status = True
        ##turn on the Water pump 3
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

        sql = "Update controlpanel SET action = 'Off' Where id = 12"
        mycursor.execute(sql)
        mydb.commit()
        self.stop_wp3 = False

    #Run LED Thread
    def runled(self):
        global duration_led, temperature
        mycursor.execute("SELECT action FROM controlpanel where id = 17")
        for y in mycursor.fetchall():
            duration_led = y[0]
        dur = int(duration_led) * 60

        print("dur: ", dur)
        count = 0
        status = True
        ##turn on the LED first
        #Check led mode
        mycursor.execute("SELECT action FROM controlpanel where id = 19")
        for y in mycursor.fetchall():
            mode = y[0]
        ledmode = int(mode)
        if (ledmode == 2):
            ## 1 click for switching to mode 1
            # Update the db
            sql = "Update controlpanel SET action = 1 Where id = 19"
            mycursor.execute(sql)
            mydb.commit()
            print("change to mode 1")

        if (ledmode == 1 and self.ledstatus == True):
            ## 2 clicks for switching to mode 2
            # Update the db
            sql = "Update controlpanel SET action = 2 Where id = 19"
            mycursor.execute(sql)
            mydb.commit()
            print("change to mode 2")
        mycursor.execute("SELECT action FROM controlpanel where id = 16")
        for y in mycursor.fetchall():
            temperature = y[0]
        preset_temp = temperature
        while status:
            print('LED is high')
            mycursor.execute("SELECT temperature FROM datacollect ORDER BY ID DESC LIMIT 1")
            for y in mycursor.fetchall():
                temperature = y[0]

            if float(preset_temp) > float(temperature) and self.ledstatus == True:
                print('LED is low')
                status = False

            if count == dur and self.ledstatus == False:
                print('LED is low')
                status = False

            if self.stop_led:
                print('LED is low')
                status = False
            count += 1
            time.sleep(1)
        print('LED thread killed')
        ##turn off the LED

        sql = "Update controlpanel SET action = 'Off' Where id = 15"
        mycursor.execute(sql)
        mydb.commit()
        self.stop_led = False
        self.ledstatus = False

    def check(self):
        global wp1, twp1, wp2, twp2, wp3, led, settemp, currtemp, freq, freq_1, freq_2, freq_4

        mycursor.execute("SELECT action FROM controlpanel where id = 1")
        for x in mycursor.fetchall():
            wp1 = x[0]
            print("Water Pump 1 status: ", wp1)

        mycursor.execute("SELECT action FROM controlpanel where id = 2")
        for x in mycursor.fetchall():
            wp2 = x[0]
            print("Water Pump 2 status: ", wp2)

        mycursor.execute("SELECT action FROM controlpanel where id = 12")
        for x in mycursor.fetchall():
            wp3 = x[0]
            print("Water Pump 3 status: ", wp3)

        mycursor.execute("SELECT action FROM controlpanel where id = 15")
        for x in mycursor.fetchall():
            led = x[0]
            print("LED status: ", led)

        mycursor.execute("SELECT action FROM controlpanel where id = 5")
        for x in mycursor.fetchall():
            twp1 = x[0]
            print("Timer Water Pump 1 status: ", twp1)

        mycursor.execute("SELECT action FROM controlpanel where id = 6")
        for x in mycursor.fetchall():
            twp2 = x[0]
            print("Timer Water Pump 1 status: ", twp2)

        mycursor.execute("SELECT action FROM controlpanel where id = 26")
        for x in mycursor.fetchall():
            twp3 = x[0]
            print("Timer Water Pump 1 status: ", twp3)

        mycursor.execute("SELECT action FROM controlpanel where id = 20")
        for x in mycursor.fetchall():
            tled = x[0]
            print("Timer LED status: ", tled)

        mycursor.execute("SELECT temperature FROM datacollect Order by id desc limit 1")
        for x in mycursor.fetchall():
            currtemp = x[0]
            print("Last Temperature: ", currtemp)

        mycursor.execute("SELECT action FROM controlpanel where id = 16")
        for x in mycursor.fetchall():
            settemp = x[0]
            print("Preset Temperature: ", settemp)

        # Compare temperature
        if (float(settemp) < float(currtemp) and self.ledstatus == False):
            sql = "Update controlpanel SET action = 'On' Where id = 15"
            mycursor.execute(sql)
            mydb.commit()
            self.stop_led = False
            time.sleep(1)
            self.ledstatus = True
        #Wp1 On/Off
        if wp1 == "On":
            self.stop_wp1 = False
            thwp1 = threading.Thread(target=self.runwp1)
            thwp1.start()
            print("Open Wp1 thread")
        if wp1 == "Off":
            print("No Wp1 thread running")
            self.stop_wp1 = True

        # Wp2 On/Off
        if wp2 == "On":
            self.stop_wp2 = False
            thwp2 = threading.Thread(target=self.runwp2)
            thwp2.start()
            print("Open Wp2 thread")
        if wp2 == "Off":
            print("No Wp2 thread running")
            self.stop_wp2 = True

        # Wp3 On/Off
        if wp3 == "On":
            self.stop_wp3 = False
            thwp3 = threading.Thread(target=self.runwp3)
            thwp3.start()
            print("Open Wp3 thread")
        if wp3 == "Off":
            print("No Wp3 thread running")
            self.stop_wp3 = True

        # LED On/Off
        if (led == "On"):
            self.stop_led = False
            self.ledstatus = False
            thled = threading.Thread(target=self.runled)
            thled.start()
            print("Open LED thread")
        if led == "Off":
            print("No LED thread running")
            self.stop_led = True

        # Timer of WP1
        if (twp1 == "On"):
            mycursor.execute("SELECT action FROM controlpanel where id = 4")
            for x in mycursor.fetchall():
                freq_1 = x[0]

            frequency = int(freq_1) + 6
            l = []
            print(frequency)
            mycursor.execute("SELECT time FROM controlpanel where id >= 7 and id <= %s", (frequency,))
            for x in mycursor.fetchall():
                twp1 = x[0]
                l.append(twp1)
                print("Timer Water Pump 1 status: ", twp1)

            print(l)
            now = datetime.now()
            end = now + timedelta(minutes=1)
            current_time = end.strftime("%H:%M:%S")
            print(end)
            print("Now Time: ", current_time)

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
                if result == True:
                    mycursor.execute("SELECT action FROM controlpanel where id =1")
                    for x in mycursor.fetchall():
                        status = x[0]
                    if status == "Off":
                        sql = "Update controlpanel SET action = 'On' Where id =1"
                        mycursor.execute(sql)
                        mydb.commit()

            print(result)

        # Timer of WP2
        if (twp2 == "On"):
            mycursor.execute("SELECT action FROM controlpanel where id = 4")
            for x in mycursor.fetchall():
                freq_2 = x[0]

            frequency = int(freq_2) + 6
            l = []
            print(frequency)
            mycursor.execute("SELECT time FROM controlpanel where id >= 7 and id <= %s", (frequency,))
            for x in mycursor.fetchall():
                twp2 = x[0]
                l.append(twp2)
                print("Timer Water Pump 2 status: ", twp2)

            print(l)
            now = datetime.now()
            end = now + timedelta(minutes=1)
            current_time = end.strftime("%H:%M:%S")
            print(end)
            print("Now Time: ", current_time)

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
                if result == True:
                    mycursor.execute("SELECT action FROM controlpanel where id =2")
                    for x in mycursor.fetchall():
                        status = x[0]
                    if status == "Off":
                        sql = "Update controlpanel SET action = 'On' Where id = 2"
                        mycursor.execute(sql)
                        mydb.commit()
            print(result)

        # Timer of WP3
        if (twp3 == "On"):

            mycursor.execute("SELECT time FROM controlpanel where id = 14")
            for x in mycursor.fetchall():
                twp3 = x[0]
                l.append(twp3)
                print("Timer Water Pump 3 status: ", twp3)

            print(l)
            now = datetime.now()
            end = now + timedelta(minutes=1)
            current_time = end.strftime("%H:%M:%S")
            print(end)
            print("Now Time: ", current_time)

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
                if result == True:
                    mycursor.execute("SELECT action FROM controlpanel where id = 12")
                    for x in mycursor.fetchall():
                        status = x[0]
                    if status == "Off":
                        sql = "Update controlpanel SET action = 'On' Where id = 12"
                        mycursor.execute(sql)
                        mydb.commit()

            print(result)

        # Timer of LED
        if (tled == "On"):
            mycursor.execute("SELECT action FROM controlpanel where id = 18")
            for x in mycursor.fetchall():
                freq_4 = x[0]
            frequency = int(freq_4) + 20
            l = []
            print(frequency)
            mycursor.execute("SELECT time FROM controlpanel where id >= 21 and id <= %s", (frequency,))
            for x in mycursor.fetchall():
                tled = x[0]
                l.append(tled)
                print("Timer LED status: ", tled)

            print(l)
            now = datetime.now()
            end = now + timedelta(minutes=1)
            current_time = end.strftime("%H:%M:%S")
            print(end)
            print("Now Time: ", current_time)

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
                if result == True:
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





































