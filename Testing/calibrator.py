from pymata_aio.pymata3 import PyMata3
import csv
from itertools import zip_longest
from datetime import datetime
from datetime import date

times = []
values = []

# ping callback function
def cb_ping(data):
    dt  = datetime.now()
    time = dt.strftime('%H:%M:%S:%f')
    times.append(time)
    values.append(data[1])
        

# create a PyMata instance
board = PyMata3(2)

# configure 4 pins for 4 SONAR modules
board.sonar_config(12, 12, cb_ping)



i = 0;
while (i<100):
    board.sleep(.1)
    print(i)
    i += 1

d = [times, values]
res = zip_longest(*d,  fillvalue='')
with open('output.csv', 'w', encoding="ISO-8859-1", newline='') as f:
    writer = csv.writer(f)
    writer.writerows(res)
    f.close()


board.shutdown()
