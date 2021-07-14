import time
from bs4 import BeautifulSoup
from bs4.builder import HTML
import requests
import json
from urllib.parse import urlparse
import mysql.connector
""" 
DB Connection.
"""
mydb = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="upzon"
)
""" 
Sitemap URL
"""
url = 'https://siteurl.com/sitemap.xml'
request = requests.get(url)
content = request.content
soup = BeautifulSoup(content, 'lxml')
""" 
ROBOTS.TXT URL
"""
robots = 'https://siteurl.com/robots.txt'
rbts = requests.get(robots)
rbts.text
rbparse = BeautifulSoup(rbts.content, 'html.parser').get_text()
locs = soup.find_all("loc")
xml_urls = []
ucount = 0
for loc in locs:
    xml_urls.append(loc.text)
for urls in xml_urls:
    raw = requests.get(urls)
    raw.text
    puretext = BeautifulSoup(raw.content, 'html.parser').get_text()
    soup = BeautifulSoup(raw.text, 'html.parser')
    for titlepy in soup.find_all('title'):
        title = titlepy.get_text()
    canonpy = soup.find('link', {'rel': 'canonical'})
    canonical = canonpy['href']
    text = (''.join(s.findAll(text=True))for s in soup.findAll('p'))
    c = Counter((x.rstrip(punctuation).lower() for y in text for x in y.split()))
    mwords = c.most_common() 
    mwordsjson = json.dumps(mwords)
    h1 = soup.find_all('h1')
    h1py = len(h1)
    h2 = soup.find_all('h2')
    h2py = len(h2)
    h3 = soup.find_all('h3')
    h3py = len(h3)
    h4 = soup.find_all('h4')
    h4py = len(h4)
    h5 = soup.find_all('h5')
    h5py = len(h5)
    h6 = soup.find_all('h6')
    h6py = len(h6)
    mycursor = mydb.cursor()
    sql = "INSERT INTO analiysis (analiysis_url,analiysis_title,analiysis_canonical,analiysis_h1,analiysis_h2,analiysis_h3,analiysis_h4,analiysis_h5,analiysis_h6,analiysis_robots) VALUES (%s,%s, %s,%s,%s,%s,%s,%s,%s,%s,%s)"
    val = (urls, title, canonical, h1py, h2py, h3py, h4py, h5py, h6py,rbparse,mwordsjson)
    mycursor.execute(sql, val)
    mydb.commit()
    ucount += 1
    print(ucount,mycursor.rowcount, "record inserted.")
