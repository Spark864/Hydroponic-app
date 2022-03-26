import urllib.parse
import psycopg2


url = urllib.parse.urlparse("postgres://nhchgncqtdohmw:44f34a07049a26867f87219d2591a73ba66b665048b3c11b6e9b8e10269c476a@ec2-54-147-93-73.compute-1.amazonaws.com:5432/d29h2tvqmjhdqj")
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
mycursor.execute("SELECT action FROM controlpanel where id = 1")
for x in mycursor.fetchall():
    wp1 = x[0]
    print(wp1)

mycursor.execute("SELECT action FROM controlpanel where id = 2")
for x in mycursor.fetchall():
    wp2 = x[0]
    print(wp2)


# WP1 On/Off


# WP2 On/Off

# Timer of WP1 or WP2

# WP3 On/Off

# Timer of WP3

# LED On/Off

# Timer of LED

