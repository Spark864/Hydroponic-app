import RPi.GPIO as GPIO
import time

GPIO.setwarnings(False)  # Ignore warning for now
GPIO.setmode(GPIO.BOARD)  # Use physical pin numbering
# 36 38 37 40 32 29 31
# 16 20 26 21 12 5 6

GPIO.setup(36, GPIO.OUT, initial=GPIO.LOW)  # Wp1 one
GPIO.setup(38, GPIO.OUT, initial=GPIO.LOW)  # Wp1 two

GPIO.setup(37, GPIO.OUT, initial=GPIO.LOW)  # Wp2 one
GPIO.setup(40, GPIO.OUT, initial=GPIO.LOW)  # Wp2 two

GPIO.setup(32, GPIO.OUT, initial=GPIO.LOW)  # Wp3

GPIO.setup(29, GPIO.OUT, initial=GPIO.LOW)  # LED
GPIO.setup(31, GPIO.OUT, initial=GPIO.LOW)  # Change Mode

#
# time.sleep(2)
#
GPIO.output(36, GPIO.HIGH)  # Turn on water pump 1
GPIO.output(38, GPIO.HIGH)  # Turn on water pump 1
GPIO.output(37, GPIO.HIGH)  # Turn on water pump 2
GPIO.output(40, GPIO.HIGH)  # Turn on water pump 2
time.sleep(1)  # Sleep for 60 second
GPIO.output(36, GPIO.LOW)  # Turn off water pump 1
GPIO.output(38, GPIO.LOW)  # Turn off water pump 1
GPIO.output(37, GPIO.LOW)  # Turn off water pump 2
GPIO.output(40, GPIO.LOW)  # Turn off water pump 2
#
# time.sleep(2)
#
# GPIO.output(37, GPIO.HIGH)  # Turn on water pump 2
# GPIO.output(40, GPIO.HIGH)  # Turn on water pump 2
# time.sleep(10)  # Sleep for 60 second
# GPIO.output(37, GPIO.LOW)  # Turn off water pump 2
# GPIO.output(40, GPIO.LOW)  # Turn off water pump 2
#
#
# time.sleep(2)

GPIO.output(32, GPIO.HIGH)  # Turn on water pump 3
time.sleep(1)  # Sleep for 60 second
GPIO.output(32, GPIO.LOW)  # Turn off water pump 3

time.sleep(1)
# sunlight
GPIO.output(29, GPIO.HIGH)  # Turn on LED
time.sleep(1)  # Sle  ep for 60 second
# heating
# 2 Click
GPIO.output(31, GPIO.HIGH)
GPIO.output(31, GPIO.LOW)
GPIO.output(31, GPIO.HIGH)
GPIO.output(31, GPIO.LOW)
time.sleep(1)
GPIO.output(29, GPIO.LOW)  # Turn off LED

import threading
import time
import ctypes

exit = threading.Event()


def main():

    while not exit.is_set():
        GPIO.output(36, GPIO.LOW)  # Turn off water pump 1
        GPIO.output(38, GPIO.LOW)  # Turn off water pump 1
        GPIO.output(37, GPIO.LOW)  # Turn off water pump 2
        GPIO.output(40, GPIO.LOW)  # Turn off water pump 2
        print("hi")
        time.sleep(3)

    print(threading.active_count())
    print("All done!")
    # perform any cleanup here


# def raise_exception(self):
#     print(threading.active_count())
#     thread_id = self.get_id()
#     res = ctypes.pythonapi.PyThreadState_SetAsyncExc(thread_id,
#                                                      ctypes.py_object(SystemExit))
#     if res > 1:
#         ctypes.pythonapi.PyThreadState_SetAsyncExc(thread_id, 0)
#         print('Exception raise failure')


def quit1(signo, _frame):
    print("Interrupted by %d, shutting down" % signo)
    # exit.set()
    GPIO.output(36, GPIO.HIGH)  # Turn on water pump 1
    GPIO.output(38, GPIO.HIGH)  # Turn on water pump 1
    GPIO.output(37, GPIO.HIGH)  # Turn on water pump 2
    GPIO.output(40, GPIO.HIGH)  # Turn on water pump 2
    print(threading.active_count())


# def quit2(signo, _frame):
#     print("Interrupted by %d, shuttindfgdfgfdg down" % signo)
#     exit.set()
#     GPIO.output(36, GPIO.LOW)  # Turn on water pump 1
#     GPIO.output(38, GPIO.LOW)  # Turn on water pump 1
#     GPIO.output(37, GPIO.LOW)  # Turn on water pump 2
#     GPIO.output(40, GPIO.LOW)  # Turn on water pump 2
#     print(threading.active_count())


if __name__ == '__main__':

    import signal

    signal.signal(signal.SIGINT, quit1)
    # signal.signal(signal.SIGTERM, quit2)
    main()

