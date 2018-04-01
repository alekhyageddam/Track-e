'''
***
*** File: DBTestingScript.py
*** Project: CSCE 315 Project 1, Spring 2018
*** Python-Version: 3.6.0
*** Authors: XXXXX
*** Date Finalized: 3/30/2018
*** Section: 501
*** E-mail: XXXXX
***
*** This script was used to construct error handling within the generateQuery() function.
*** The unittest library was used for this purpose. Test were constructed for each edge case and
*** general error handling was built around results. Note that the current error handling is not
*** very restrictive, i.e. Data is allowed to be well outside an expected range. This 
*** was done in attempt to keep the function general and reusable.
***
'''

from pymata_aio.pymata3 import PyMata3 #For asynchronous sensor interfacing
import MySQLdb                         #For database connection
from time import strftime, localtime   #For timestamp generation and formating
import unittest                        #For unittesting class

#Database connection variables
DB_ADDRESS = "ADDRESS_HERE"    #Server Address of database
DB_NAME = "DB_NAME_HERE"       #Name of database
TABLE_NAME = "TABLE_NAME_HERE"
USERNAME = "USERNAME_HERE"     #Username for database
PASSWORD = "PASSWORD_HERE"     #Password for database


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
        return False
    else:
        query = "INSERT INTO `"+DB_NAME+"`.`"+TABLE_NAME+"` (`COUNT`, `TIME`, `DAY`, `VALUE`)"
        "VALUES (NULL, '%s', '%s', '%s')" % (timeS, timeD, data)
        try:
            cursor.execute(query)
            connection.commit()
        except:
            print("Error: Unable to execute INSERT INTO query. Make sure database variables at the begining of the script"
                  "are set properly.")
            return False
        else:
            return True


#-------------------------------Testing Functions-----------------------------#


class TestMethod(unittest.TestCase):
    #Setup database connection
    connection = MySQLdb.connect(DB_ADDRESS, DB_NAME, PASSWORD, USERNAME)
    cursor = connection.cursor()

    #Control Variables
    goodTimeObject = localtime()
    goodData = 200

    #List of test case functions
    def testList(self):

        control = self.testCase_control()
        test1 = self.testCase_invalid_time_object()
        test2 = self.testCase_negative_data_value()
        test3 = self.testCase_data_value_out_of_bounds()

        #Asserting that all test case functions will evaluate properly
        self.assertTrue(control and test1 and test2 and test3)

    #Function definitions of each edge case
    def testCase_control(self):
        data = goodData
        inputTime = goodTimeObject
        self.assertTrue(generateQuery(data, inputTime)

    def testCase_invalid_time_object(self):
        data = goodData
        inputTime = struct_time(2001, 10, 21, 2, 32, -1, 0, 2, 330, -1)
        self.assertFalse(generateQuery(data, inputTime))

    def testCase_negative_data_value(self):
        data = -2
        inputTime = goodTimeObject
        self.assertFalse(generateQuery(data, inputTime))

    def testCase_data_value_out_of_bounds(self):
        data = 999999999999999999999999999999999999999999999999999999999999999999
        inputTime = goodTimeObject
        self.assertFalse(generateQuery(data, inputTime))
        
