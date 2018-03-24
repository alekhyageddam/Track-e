from pymata_aio.pymata3 import PyMata3

# ping callback function
def cb_ping(data):
    if(data[1]<= 70):
        cb_ping.counter += 1
    else:
        cb_ping.counter = 0

    if(cb_ping.counter > 3):
        print("Traffic Detected")
        cb_ping.counter = 0
        




# create a PyMata instance
board = PyMata3(2)

# configure 4 pins for 4 SONAR modules
board.sonar_config(12, 12, cb_ping)




while True:
    board.sleep(.1)

board.shutdown()
