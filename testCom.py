import RPi.GPIO as GPIO
import time

GPIO.setwarnings(False)  # Ignore warning for now
GPIO.setmode(GPIO.BOARD)  # Use physical pin numbering

GPIO.setup(36, GPIO.OUT, initial=GPIO.LOW)  #Wp1 one 
GPIO.setup(38, GPIO.OUT, initial=GPIO.LOW)  #Wp1 two

GPIO.setup(37, GPIO.OUT, initial=GPIO.LOW)  #Wp2 one
GPIO.setup(40, GPIO.OUT, initial=GPIO.LOW)  #Wp2 two

GPIO.setup(27, GPIO.OUT, initial=GPIO.LOW)  #Wp3

GPIO.setup(29, GPIO.OUT, initial=GPIO.LOW)  #LED
GPIO.setup(31, GPIO.OUT, initial=GPIO.LOW)  #Change Mode




time.sleep(2)

GPIO.output(36, GPIO.HIGH)  # Turn on water pump 1
GPIO.output(38, GPIO.HIGH)  # Turn on water pump 1
time.sleep(60)  # Sleep for 60 second
GPIO.output(36, GPIO.LOW)  # Turn off water pump 1
GPIO.output(38, GPIO.LOW)  # Turn off water pump 1

time.sleep(2)

GPIO.output(37, GPIO.HIGH)  # Turn on water pump 2
GPIO.output(40, GPIO.HIGH)  # Turn on water pump 2
time.sleep(60)  # Sleep for 60 second
GPIO.output(37, GPIO.LOW)  # Turn off water pump 2
GPIO.output(40, GPIO.LOW)  # Turn off water pump 2


time.sleep(2)

GPIO.output(27, GPIO.HIGH)  # Turn on water pump 3
time.sleep(60)  # Sleep for 60 second
GPIO.output(27, GPIO.LOW)  # Turn off water pump 3

time.sleep(2)

GPIO.output(29, GPIO.HIGH)  # Turn on LED
time.sleep(10)  # Sleep for 60 second

#2 Click
GPIO.output(31, GPIO.HIGH) 
GPIO.output(31, GPIO.LOW)
GPIO.output(31, GPIO.HIGH)
GPIO.output(31, GPIO.LOW)
time.sleep(10)
GPIO.output(29, GPIO.LOW)  # Turn off LED







