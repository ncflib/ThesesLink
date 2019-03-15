from bs4 import BeautifulSoup
import requests
from contextlib import closing
import re
import mysql.connector
from requests.exceptions import RequestException

def simple_get(url):
    try:
        with closing(requests.get(url, stream=True)) as resp:
            if is_good_response(resp):
                return resp.content
            else:
                return None

    except RequestException as e:
        log_error('Error during requests to {0} : {1}'.format(url, str(e)))
        return None

def is_good_response(resp):
    content_type = resp.headers['Content-Type'].lower()
    return (resp.status_code == 200
            and content_type is not None
            and content_type.find('html') > -1)


def log_error(e):
    print(e)

mydb = mysql.connector.connect(
  host="x.x.x.x",
  user="root",
  passwd="pass",
  database="theses"
)

print(mydb)
mycursor = mydb.cursor()
i = 1
while(i<288):
    page = "http://ncf.sobek.ufl.edu/theses/all/brief/"+str(i)
    raw_html = simple_get(page)
    html = BeautifulSoup(raw_html,'html.parser')
    theses = html.findAll("section", {"class": "sbkBrv_SingleResult"})

    for thesis in theses:

        title = thesis.find("span", {"class": "briefResultsTitle"})
        print(title.text)
        tlink = title.find('a').get('href')
        newraw_html = simple_get(tlink+"/00001/citation")
        newhtml = BeautifulSoup(newraw_html,'html.parser')
        abstract = newhtml.find("dd", {"class": "sbk_CivABSTRACT_Element"})
        if(abstract != None):
        	abstract=abstract.text.strip()
        	print(abstract)
        else:
        	abstract = ""


        print(tlink)

        detaildiv = thesis.find("dl", {"class" : "sbkBrv_SingleResultDescList"})
        details = detaildiv.findAll("dd")

        student = details[0].text.strip()


        if "Faculty Sponsor" in str(detaildiv):
            fsponsor = re.search(r"<dt>Faculty Sponsor:</dt>.*?\n", str(detaildiv)).group(0)
            fsponsor = BeautifulSoup(fsponsor,'html.parser')
            fsponsor = fsponsor.findAll("dd")
            if(len(fsponsor)>1):
                a = 0
                while(a<len(fsponsor)):
                    if(a == len(fsponsor) - 1):
                        facultysponsor = facultysponsor + fsponsor[a].text
                    else:
                        facultysponsor = facultysponsor + fsponsor[a].text + "& "
                    a+=1
            else:
                facultysponsor = fsponsor[0].text.strip()

        if "Graduation Date" in str(detaildiv):
            gdate = re.search(r"<dt>Graduation Date:</dt>.*?\n", str(detaildiv)).group(0)
            gdate = BeautifulSoup(gdate,'html.parser')
            gdate = gdate.findAll("dd")
            print(gdate)
            gdate = gdate[0].text.strip()

        if "Degree" in str(detaildiv):
            degree = re.search(r"<dt>Degree:</dt>.*?\n", str(detaildiv)).group(0)
            degree = BeautifulSoup(degree,'html.parser')
            degree = degree.findAll("dd")
            print(degree)
            degree = degree[0].text.strip()

        if "Grantor" in str(detaildiv):
            grantor = re.search(r"<dt>Thesis Degree Grantor:</dt>.*?\n", str(detaildiv)).group(0)
            grantor = BeautifulSoup(grantor,'html.parser')
            grantor = grantor.findAll("dd")
            grantor = grantor[0].text.strip()

        if "Division" in str(detaildiv):
            division = re.search(r"<dt>Thesis Division:</dt>.*?\n", str(detaildiv)).group(0)
            division = BeautifulSoup(division,'html.parser')
            division = division.findAll("dd")
            division = division[0].text.strip()

        if "Area of Concentration" in str(detaildiv):
            aoc = re.search(r"<dt>Area of Concentration:</dt>.*?\n", str(detaildiv)).group(0)
            aoc = BeautifulSoup(aoc,'html.parser')
            aoc = aoc.findAll("dd")
            print(aoc)


        if "Subjects.Display" in str(detaildiv):
            subjects = re.search(r"<dt>Subjects.Display:</dt>.*?\n", str(detaildiv)).group(0)
            subjects = BeautifulSoup(subjects,'html.parser')
            subjects = subjects.findAll("dd")
            print(subjects)

        sql = "INSERT INTO theses (title,student,sponsor,graduatedate,degree,grantor,division,tlink,abstract) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)"
        val = (title.text, student, facultysponsor, gdate, degree, grantor, division, tlink, abstract)
        mycursor.execute(sql, val)
        mydb.commit()
        lastid = mycursor.lastrowid
        a = 0
        
        while(a < len(aoc)):
        	if(aoc[a].text.strip() != "Humanities" or aoc[a].text.strip() != "Natural Science" or aoc[a].text.strip() != "Social Science"):
	            sql = "INSERT INTO aocs (aoc,thesis,division) VALUES (%s, %s, %s)"
	            val = (aoc[a].text.strip(), lastid , -1)
	            mycursor.execute(sql, val)
	            mydb.commit()
	        a+=1

        a = 0
        while(a < len(subjects)):
            sql = "INSERT INTO subjects (subject,thesis) VALUES (%s, %s)"
            val = (subjects[a].text.strip(), lastid)
            mycursor.execute(sql, val)
            mydb.commit()
            a+=1
        

        print('----------------------------------')
    i+=1
