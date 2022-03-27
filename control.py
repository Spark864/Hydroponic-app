import time
import urllib.parse
import psycopg2
import threading

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

    def runled(self):
        global duration
        mycursor.execute("SELECT action FROM controlpanel where id = 17")
        for x in mycursor.fetchall():
            duration = x[0]
        dur = int(duration) * 60
        print("dur: ", dur)
        count = 0
        status = True
        ##turn on the LED
        #Check led mode
        mycursor.execute("SELECT action FROM controlpanel where id = 19")
        for y in mycursor.fetchall():
            mode = y[0]
        ledmode = int(mode)
        if ledmode == 2:
            ## 1 click for switching to mode 1
            # Update the db
            sql = "Update controlpanel SET action = 1 Where id = 19"
            mycursor.execute(sql)
            mydb.commit()
            print("change to mode 1")
        while status:
            print('LED is high')

            if count == dur:
                print('LED is low')
                status = False
            if self.stop_led:
                print('LED thread killed')
                status = False
            count += 1
            time.sleep(1)

        ##turn off the LED

        sql = "Update controlpanel SET action = 'Off' Where id = 15"
        mycursor.execute(sql)
        mydb.commit()
        self.stop_led = False


    def check(self):
        global wp1, twp1, wp2, twp2, wp3, led

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

        # mycursor.execute("SELECT action FROM controlpanel where id = 5")
        # for x in mycursor.fetchall():
        #     twp1 = x[0]
        #     print("Timer Water Pump 1 status: ", twp1)
        #
        # mycursor.execute("SELECT action FROM controlpanel where id = 6")
        # for x in mycursor.fetchall():
        #     twp2 = x[0]
        #     print("Timer Water Pump 1 status: ", twp2)
        #
        # mycursor.execute("SELECT action FROM controlpanel where id = 26")
        # for x in mycursor.fetchall():
        #     twp3 = x[0]
        #     print("Timer Water Pump 1 status: ", twp3)
        #
        # mycursor.execute("SELECT action FROM controlpanel where id = 20")
        # for x in mycursor.fetchall():
        #     tled = x[0]
        #     print("Timer LED status: ", tled)

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
        if led == "On":
            self.stop_led = False
            thled = threading.Thread(target=self.runled)
            thled.start()
            print("Open LED thread")
        if led == "Off":
            print("No LED thread running")
            self.stop_led = True

        time.sleep(10)

        # Temperature compare 

        # Timer of WP1 or WP2
        
        # Timer of WP3

        # Timer of LED

    def main(self):
        while True:
            self.check()

program = Control()
program.main()


