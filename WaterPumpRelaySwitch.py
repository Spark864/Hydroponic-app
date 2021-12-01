import time
from datetime import datetime, timedelta
from datetime import date
import RPi.GPIO as GPIO

GPIO.setwarnings(False)  # Ignore warning for now
GPIO.setmode(GPIO.BOARD)  # Use physical pin numbering
GPIO.setup(13, GPIO.OUT, initial=GPIO.LOW)  # Set pin 8 to be an output pin and set initial value to low (off)


def time_in_range(start, end, x):
    """Return true if x is in the range [start, end]"""
    if start <= end:
        return start <= x <= end
    else:
        return start <= x or x <= end


# today = date.today()
# print("Today date is: ", today)
# print(type(today))
# print("Today date is: ", today.year)
# print(type(today.month))

now = datetime.now()
# print("now = ", now)
# print(type(now))
# print("now = ", now.hour)
# print(type(now.hour))
# print("now = ", now.year)
# print(type(now.year))

date1 = datetime(now.year, now.month, now.day, 10, 0, 0)
date2 = datetime(now.year, now.month, now.day, 14, 0, 0)
date3 = datetime(now.year, now.month, now.day, 16, 0, 0)

while True:

    if time_in_range(date1, date1 + timedelta(minutes=1), now):

        # turn on led
        GPIO.output(13, GPIO.HIGH)  # Turn on
        time.sleep(60)  # Sleep for 60 second
        GPIO.output(13, GPIO.LOW)  # Turn off

    elif time_in_range(date2, date2 + timedelta(minutes=1), now):

        # turn on led
        GPIO.output(13, GPIO.HIGH)  # Turn on
        time.sleep(60)  # Sleep for 60 second
        GPIO.output(13, GPIO.LOW)  # Turn off

    elif time_in_range(date3, date3 + timedelta(minutes=1), now):

        # turn on led
        GPIO.output(13, GPIO.HIGH)  # Turn on
        time.sleep(60)  # Sleep for 60 second
        GPIO.output(13, GPIO.LOW)  # Turn off
    time.sleep(5)
