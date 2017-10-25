#! /usr/bin/python

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.
import MySQLdb

strdata = "-"
def getItemsFromDB():
    conn = MySQLdb.Connect(host = "localhost", user = "root", passwd ="",db= "CMSDBMAIN")
    cur = conn.cursor()
    cur.excute("Select * from client")
    items = cur.fetchall()
    return items

#path = "C:\\wamp64\\www\\SiteJinni\\Website\\docroots\\userdocroots"

path = "/Applications/MAMP/htdocs/SiteJinniRepo/SiteJinni/Website/docroots/userdocroots"
searchdata = "-";

for client in items :
    searchdata = "-"
    descfile = open(path + "/" + client.clientname + "/docroot/SiteJinni.txt","w")
    searchdata = client.clientname + ";\n" + strdata
    descfile.write(searchdata)
    descfile.close()
    strdata = "-"

print ("done")



