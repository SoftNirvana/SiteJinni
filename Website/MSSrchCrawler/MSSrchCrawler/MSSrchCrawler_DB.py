#! /usr/bin/python

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.
import MySQLdb
#import sqlite3



strdata = "-"

def extractFromClient():
    global strdata
    conn = MySQLdb.Connect(host = "localhost", user = "root", passwd ="",db= "CMSDBMAIN")
    cur = conn.cursor()
    cur = conn.cursor(MySQLdb.cursors.DictCursor)
    cur.execute("SELECT * FROM Client")
    result_set = cur.fetchall()
    for row in result_set:
        strdata += ";\n" +  (row["clientid"],row["clientname"],row["clientcontactnumber1"],row["clientcontactnumber2"],row["clientadressline1"],row["clientaddressline2"],row["clientaddressline3"],row["clientcity"],row["zipcode"],row["clientid"],row["clientmailaddress"],row["clientmainURL"],row["clientnumofservices"],row["userid"] )
    

path = "C:\\wamp64\\www\\SiteJinni\\Website\\docroots\\userdocroots"
#path = "/Applications/MAMP/htdocs/SiteJinniRepo/SiteJinni/Website/docroots/userdocroots"
searchdata = "-";

descfile = open(path + "/" + client.clientname + "/docroot/SiteJinni.txt","w")
searchdata = extractFromClient()
descfile.write(searchdata)
descfile.close()
strdata = "-"

print ("done")



