# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

import json
import os
from pprint import pprint

strdata = "-"


def extractdata(datadict):
    global strdata
    if isinstance(datadict,dict):
        for key, value in datadict.iteritems():
            if key != 'PartName':
                extractdata(value)
    elif isinstance(datadict, list):
        for value in datadict:
            extractdata(value)
    elif datadict is not None:        
        strdata += ";\n" + str(datadict);



path = "/Applications/MAMP/htdocs/SiteJinniRepo/SiteJinni/Website/docroots/userdocroots"
searchdata = "-";
for filename in os.listdir(path):
    searchdata = "-"
    if os.path.isdir(path + "/" + filename):
        with open(path + "/" + filename + "/docroot/"+ 'header_data.json') as data_file:    
            descfile = open(path + "/" + filename + "/docroot/SiteJinni.txt","w")
            data = json.load(data_file)
            extractdata(data)
            searchdata = filename + ";\n" + strdata;
            descfile.write(searchdata)
            descfile.close()
            strdata = "-"

print "done"
