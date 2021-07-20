import time
import requests
from requests.api import request
import json
from urllib.parse import urlparse

from bs4 import BeautifulSoup
from bs4.builder import HTML

from mysql.connector.errors import Error
import mysql.connector

from collections import Counter
from string import punctuation


class seo_crawler:
    def __init__(self):
        # Database connection
        self.mydb = mysql.connector.connect(host="localhost",user="root",password="",database="upzon")   

        # Robots.txt
        self.robotsurl = 'https://www.url.com/robots.txt'
        self.robotsource = BeautifulSoup(requests.get(self.robotsurl).content, 'html.parser').get_text()

        # Sitemap.xml
        self.url = 'https://www.url.com/sitemap.xml'
        self.sitemapsoup = BeautifulSoup(requests.get(self.url).content, 'lxml')
        self.sitemapurls = self.sitemapsoup.find_all("loc")

        # XML urls
        self.xml_urls = [sitemapurl.text for sitemapurl in self.sitemapurls]
    
    def start(self):

        for websiteurls in self.xml_urls:
            source = BeautifulSoup(requests.get(websiteurls).text, 'html.parser')
            self.database_insert(
                websiteurls, 
                self.title(source), 
                self.canonical(source), 
                self.h1(source), 
                self.h2(source), 
                self.h3(source), 
                self.h4(source), 
                self.h5(source), 
                self.h6(source), 
                self.robotsource, 
                self.words(source), 
                self.image(source), 
                self.alt(source), 
                self.links(source)
            )
    
    
    def title(self, source):
        for titles in source.find_all('title'):
            return titles.get_text()        

    def links(self, source):
        return json.dumps(
            [ x.get('href') for x in source.findAll('a') ]
        )
    
    def canonical(self, source):
        return source.find('link', {'rel': 'canonical'})['href']   
    
    def words(self, source):
        wordsfinder = (''.join(s.findAll(text=True))for s in source.findAll('p'))
        return json.dumps(
            Counter(
                (x.rstrip(punctuation).lower() for y in wordsfinder for x in y.split())
            ).most_common()
        )
    
    def image(self, source):
        imagesfinder = source.find_all('img')
        imagelist = []
        for images in imagesfinder:
                try:
                    foundedimages = images['src']
                except:
                    foundedimages = images['src'], "Don't have image"
                images = foundedimages
                imagelist.append(images)
        return json.dumps(imagelist)        
    
    
    def alt(self, source):
        imagealtsfinder = source.find_all('img')
        altslist = []
        for alts in imagealtsfinder:
                try:
                    foundedalts = alts['alt']
                except:
                    foundedalts = "Alt missing"
                alts = foundedalts
                altslist.append(alts)
        return json.dumps(altslist)       
    
    def h1(self, source):
        return len(source.find_all('h1'))
    
    def h2(self, source):
        return len(source.find_all('h2'))    
    
    def h3(self, source):
        return len(source.find_all('h3'))      
    
    def h4(self, source):
        return len(source.find_all('h4'))     
    
    def h5(self, source):
        return len(source.find_all('h5'))  
 
    def h6(self, source):
        return len(source.find_all('h6'))  
    
    def database_insert(self, websiteurls, title, canonical, h1, h2, h3, h4, h5, h6, robotsource, words, image, alt, link):
        mycursor = self.mydb.cursor()
        sql = "INSERT INTO analiysis (analiysis_url,analiysis_title,analiysis_canonical,analiysis_h1,analiysis_h2,analiysis_h3,analiysis_h4,analiysis_h5,analiysis_h6,analiysis_robots,analiysis_mostwords,analiysis_images,analiysis_imagesalt,analiysis_urls) VALUES (%s,%s, %s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"
        val  =(websiteurls,title,canonical,h1,h2,h3,h4,h5,h6,robotsource,words,image,alt,link)
        mycursor.execute(sql, val)
        self.mydb.commit()
        print(mycursor.rowcount, "record inserted.")


the_seo_crawler = seo_crawler()        
the_seo_crawler.start()
