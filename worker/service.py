import time
from bs4 import BeautifulSoup
from bs4.builder import HTML
from mysql.connector.errors import Error
import requests
import json
from urllib.parse import urlparse
import mysql.connector
from collections import Counter
from string import punctuation

from requests.api import request
""" Your DB """
mydb = mysql.connector.connect(host="localhost",user="root",password="",database="upzon")   

url = 'https://www.url.com/sitemap.xml'
robotsurl = 'https://www.url.com/robots.txt'
""" """
robotrequest = requests.get(robotsurl)
robotrequest.text
robotsource = BeautifulSoup(robotrequest.content, 'html.parser').get_text()
""" """
sitemaprequest = requests.get(url)
sitemapcontent = sitemaprequest.content
sitemapsoup = BeautifulSoup(sitemapcontent, 'lxml')
sitemapurls = sitemapsoup.find_all("loc")
xml_urls = []
for sitemapurl in sitemapurls:
    xml_urls.append(sitemapurl.text)
    """ """
for websiteurls in xml_urls:
    titlerequest = requests.get(websiteurls)
    titlerequest.text
    titlesource = BeautifulSoup(titlerequest.text, 'html.parser')
    for titles in titlesource.find_all('title'):
        title = titles.get_text()
    """ """ 
    hrefrequest = requests.get(websiteurls)
    hrefrequest.text
    hrefsource = BeautifulSoup(hrefrequest.text, 'html.parser')
    links = [ x.get('href') for x in hrefsource.findAll('a') ]
    link = json.dumps(links)
    """ """ 
    canonicalrequest = requests.get(websiteurls)
    canonicalrequest.text
    canonicalsource = BeautifulSoup(canonicalrequest.text, 'html.parser')
    canonicalfinder = canonicalsource.find('link', {'rel': 'canonical'})
    canonical = canonicalfinder['href']
    """ """
    wordsrequest = requests.get(websiteurls)
    wordsrequest.text
    wordsource = BeautifulSoup(wordsrequest.text, 'html.parser')
    wordsfinder = (''.join(s.findAll(text=True))for s in wordsource.findAll('p'))
    wordscounter = Counter((x.rstrip(punctuation).lower() for y in wordsfinder for x in y.split()))
    wordsmost = wordscounter.most_common()
    words = json.dumps(wordsmost)
    """ """
    imagesrequest = requests.get(websiteurls)
    imagesrequest.text
    imagesource = BeautifulSoup(imagesrequest.text, 'html.parser')
    imagesfinder = imagesource.find_all('img')
    imagelist = []
    for images in imagesfinder:
        try:
            foundedimages = images['src']
        except:
            foundedimages = images['src'], "Don't have image"
        images = foundedimages
        imagelist.append(images)
    image = json.dumps(imagelist)
    """ """
    imagealtsrequest = requests.get(websiteurls)
    imagealtsrequest.text
    imagealtssource = BeautifulSoup(imagealtsrequest.text, 'html.parser')
    imagealtsfinder = imagealtssource.find_all('img')
    altslist = []
    for alts in imagealtsfinder:
        try:
            foundedalts = alts['alt']
        except:
            foundedalts = "Alt missing"
        alts = foundedalts
        altslist.append(alts)
    alt = json.dumps(altslist)
    
    """ """
    hrequest = requests.get(websiteurls)
    hrequest.text
    hsource = BeautifulSoup(hrequest.text, 'html.parser')
    h1finder = hsource.find_all('h1')
    h1 = len(h1finder)
    h2finder = hsource.find_all('h2')
    h2 = len(h2finder)
    h3finder = hsource.find_all('h3')
    h3 = len(h3finder)
    h4finder = hsource.find_all('h4')
    h4 = len(h4finder)
    h5finder = hsource.find_all('h5')
    h5 = len(h5finder)
    h6finder = hsource.find_all('h6')
    h6 = len(h6finder)
    """ """
    mycursor = mydb.cursor()
    sql = "INSERT INTO analiysis (analiysis_url,analiysis_title,analiysis_canonical,analiysis_h1,analiysis_h2,analiysis_h3,analiysis_h4,analiysis_h5,analiysis_h6,analiysis_robots,analiysis_mostwords,analiysis_images,analiysis_imagesalt,analiysis_urls) VALUES (%s,%s, %s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"
    val  =(websiteurls,title,canonical,h1,h2,h3,h4,h5,h6,robotsource,words,image,alt,link)
    mycursor.execute(sql, val)
    mydb.commit()
    print(mycursor.rowcount, "record inserted.")
