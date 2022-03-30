import threading
import time
import ctypes
exit = threading.Event()

def main():
  try:
    while not exit.is_set():
      print("something")
      time.sleep(3)
  except:
    print("All done!")
    # perform any cleanup here

def raise_exception(self):
    thread_id = self.get_id()
    res = ctypes.pythonapi.PyThreadState_SetAsyncExc(thread_id,
          ctypes.py_object(SystemExit))
    if res > 1:
        ctypes.pythonapi.PyThreadState_SetAsyncExc(thread_id, 0)
        print('Exception raise failure')

def quit(signo, _frame):
    print("Interrupted by %d, shutting down" % signo)
    exit.set()
    raise_exception()

if __name__ == '__main__':

    import signal
    for sig in ('TERM', 'INT'):
        signal.signal(getattr(signal, 'SIG'+sig), quit)
    
    threading.Thread(target=main())