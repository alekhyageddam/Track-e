'''
***
*** File: TrafficMonitor.py
*** Project: CSCE 315 Project 1, Spring 2018
*** Python-Version: 3.6.0
*** Authors: XXXXX
*** Date Finalized: 3/30/2018
*** Section: 501
*** E-mail: XXXXX
***
*** This program handles data processing and uploading for the Track-e
*** project. Running this program with a tethered Arduino Uno is a 2-step
*** process. First, compile and upload the FirmataPlus interface onto your
*** Arduino Uno. This allows our higher-level python libraries to interface with
*** the device. Then, simply run this script! Automatic port detection is
*** integrated with the pymata_aio library. Feel free to set enviromental
*** variables below to match your setup up. For general use, the default values
*** should suffice.
***
'''


from pymata_aio.pymata3 import PyMata3 #For asynchronous sensor interfacing
from pymata_aio.constants import Constants
import MySQLdb                         #For database connection
from time import strftime, localtime   #For timestamp generation and formating


#Database connection variables
DB_ADDRESS = "database.cs.tamu.edu"   #Server Address of database
DB_NAME = "mattkeith"      #Name of database
TABLE_NAME = "SampleData"
USERNAME = "mattkeith"     #Username for database
PASSWORD = "Tracke123"     #Password for database


#Hardware setup variables
SAMPLE_RATE = 50     #Sample rate of ultrasonic sensor (between 33 and 127 ms)
SENSOR_IO_PIN = 12   #Pin number of ultrasonsic sensor
LED_PIN = 2          #Pin number of LED (optional)
LED_ENABLED = True   #Sets whether the optional LED is being used

#Debuging Variables
#These values have been tested and have been determined to work optimally. Do not change
#these values unless you are recalibrating this software and know what you are doing!
THRESHOLD_VALUE = 70    #Value which distinguishes a detection event
THRESHOLD_COUNT = 5     #Number of consecutive detections required for detection event

#Sensor-data handler function

LEDQueued = False

def dataHandler(data):
    if(data[1] <= THRESHOLD_VALUE):
        dataHandler.counter += 1
    else:
        dataHandler.counter = 0

    #A THRESHOLD_COUNT number of consecutive values less than THRESHOLD value is 
    #determined to be a detection event.
    if(dataHandler.counter > THRESHOLD_COUNT):
        print("Traffic Detected")
        generateQuery(data[1])
        if(LED_ENABLED == True and LEDQueued == False):
            blink()
        dataHandler.counter = 0
        
dataHandler.counter = 0

#Generates Query for inserting entry into Database
def generateQuery(data, inputTime = None ):
    
    if(inputTime == None):
        timeValue = localtime()
    else:
        timeValue = inputTime
    try:
        timeS = strftime("%Y-%m-%d %H:%M:%S", timeValue)
        timeD = strftime("%a", timeValue)
    except:
        print("Error: Unable to format inputTime into proper timestamp. Change input or consider using localtime() (default.)")
    query = ("INSERT INTO `"+DB_NAME+"`.`"+TABLE_NAME+"` (`COUNT`, `TIME`, `DAY`, `VALUE`)"
    "VALUES (NULL, '%s', '%s', '%s')" % (timeS, timeD, data))
    cursor.execute(query)
    connection.commit()
    

#Blink the optional LED
def blink():
    """
    LEDQueued = True
    interface.digital_write(LED_PIN, 1)
    interface.sleep(0.5)
    interface.digital_write(LED_PIN, 0)
    LEDQueued = False
    """


#Setup database connection
connection = MySQLdb.connect(DB_ADDRESS, DB_NAME, PASSWORD, USERNAME)
cursor = connection.cursor()

#Initializes a PyMata instance
interface = PyMata3()

#Sets up LED (if enabled)
if(LED_ENABLED == True):
    interface.set_pin_mode(LED_PIN, Constants.OUTPUT)
    interface.disable_digital_reporting(LED_PIN)

#Starts asynchronous data request to ultrasonsic sensor
interface.sonar_config(SENSOR_IO_PIN, SENSOR_IO_PIN, dataHandler, SAMPLE_RATE)

while True:
    interface.sleep(0.5)

interface.shutdown()

