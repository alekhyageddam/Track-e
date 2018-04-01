'''
***
*** File: HardwareTestingScript.py
*** Project: CSCE 315 Project 1, Spring 2018
*** Python-Version: 3.6.0
*** Authors: XXXXX
*** Date Finalized: 3/30/2018
*** Section: 501
*** E-mail: XXXXX
***
*** This program was used to handle data testing for the device. The detection function
*** is identical to the one used in TrafficMonitor.py minus the database interaction.
*** The script executes 5 test, each 10 seconds long. Each detection event increments the
*** detectionCount. At the end of the test, the detectionCount is compared to the expected
*** count for the test to determine if the test was passsed or not. Using results from this
*** test, the default values for the Debugging Variables were set in TrafficMonitor.py.
***
'''

from pymata_aio.pymata3 import PyMata3 #For asynchronous sensor interfacing
from time import strftime, localtime   #For timestamp generation and formating

detectionCount = 0

#Hardware setup variables
SAMPLE_RATE = 50     #Sample rate of ultrasonic sensor (between 33 and 127 ms)
SENSOR_IO_PIN = 12   #Pin number of ultrasonsic sensor

#Testing Variables
THRESHOLD_VALUE = 70    #Value which distinguishes a detection event
THRESHOLD_COUNT = 3     #Number of consecutive detections required for detection event

#Sensor data handler function
def dataHandler(data):
    if(data[1] <= THRESHOLD_VALUE):
        dataHandler.counter += 1
    else:
        dataHandled.counter = 0

    #A THRESHOLD_COUNT number of consecutive values less than THRESHOLD value is 
    #determined to be a detection event.
    if(dataHandler.counter > THRESHOLD_COUNT):
        print("Traffic Detected")
        detectionCount += 1
        dataHandler.counter = 0
        
# create a PyMata instance
interface = PyMata3(2)

# configure 4 pins for 4 SONAR modules
interface.sonar_config(SENSOR_IO_PIN, SENSOR_IO_PIN, dataHandler, SAMPLE_RATE);

#Test 1
i = 0;
expectedCount = 3
print("Starting Test 1...")

#Data is collected for 10 seconds
while (i<100):
    interface.sleep(.1)
    i += 1

#If detectionCount matches expected value, test passes. Otherwise, test failed.
if(detectionCount == expectedCount):
    print("Test 1 Passed")
else:
    print("Test 1 Failed")

#Test 2
i = 0;
detectionCount = 0
expectedCount = 2
print("Starting Test 2...")

#Data is collected for 10 seconds
while (i<100):
    interface.sleep(.1)
    i += 1

#If detectionCount matches expected value, test passes. Otherwise, test failed.
if(detectionCount == expectedCount):
    print("Test 2 Passed")
else:
    print("Test 2 Failed")

#Test 3
i = 0;
detectionCount = 0
expectedCount = 1
print("Starting Test 3...")

#Data is collected for 10 seconds
while (i<100):
    interface.sleep(.1)
    i += 1

#If detectionCount matches expected value, test passes. Otherwise, test failed.
if(detectionCount == expectedCount):
    print("Test 3 Passed")
else:
    print("Test 3 Failed")

#Test 4
i = 0;
detectionCount = 0
expectedCount = 2
print("Starting Test 4...")

#Data is collected for 10 seconds
while (i<100):
    interface.sleep(.1)
    i += 1

#If detectionCount matches expected value, test passes. Otherwise, test failed.
if(detectionCount == expectedCount):
    print("Test 4 Passed")
else:
    print("Test 4 Failed")

#Test 5
i = 0;
detectionCount = 0
expectedCount = 1
print("Starting Test 5...")

#Data is collected for 10 seconds
while (i<100):
    interface.sleep(.1)
    i += 1

#If detectionCount matches expected value, test passes. Otherwise, test failed.
if(detectionCount == expectedCount):
    print("Test 5 Passed")
else:
    print("Test 5 Failed")

print("Testing Complete. Shutting Down...")

#Safely initiate shutdown sequence
interface.shutdown()
