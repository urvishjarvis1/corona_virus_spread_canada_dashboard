import csv
import pymysql as sql

connection = sql.connect(host="localhost",user="root",passwd="",database="coronavirusvisualization")
cursor = connection.cursor()
with open('C:/Users/urvis/OneDrive/Documents/University Of Regina/Term 2/Information Visualization/Project/13100781.csv','r') as f:
    reader=csv.reader(f)
    next(reader,None)
    previousId = '1'
    for row in reader:
        caseid=row[3]
        if caseid == previousId:
            #print ('caseId ',caseid)
            if row[4] == 'Region':
                region=int(row[11])
                #print("region:",region)
            elif row[4] == 'Episode week':
                episodeweek=int(row[11])
                #print("episodeweek",episodeweek)
            elif row[4] == 'Episode year':
                episodeyear=int(row[11])
                #print("episodeyear",episodeyear)
            elif row[4] == 'Gender':
                gender = int(row[11])
                #print("gender",gender)
            elif row[4] == 'Age group':
                agegroup = int(row[11])
                #print("agegroup", agegroup)
            elif row[4] == 'Occupation':
                occupation = int(row[11])
                #print("occupation",occupation)
            elif row[4] == 'Asymptomatic':
                asymptomatic = int(row[11])
                #print("asymptomatic",asymptomatic)
            elif row[4] == 'Onset week of symptoms':
                onsetweekofsym = int(row[11])
                #print("onsetweekofsym",onsetweekofsym)
            elif row[4] == 'Onset year of symptoms':
                onsetyearofsym=int(row[11])
                #print("onsetyearofsym",onsetyearofsym)
            elif row[4] == 'Hospital status':
                hospitalstatus = int(row[11])
                #print("hospitalstatus",hospitalstatus)
            elif row[4] == 'Recovered':
                recovered = int(row[11])
                #print("recovered",recovered)
            elif row[4] == 'Recovery week':
                recoveryweek = int(row[11])
                #print("recoveryweek",recoveryweek)
            elif row[4] == 'Recovery year':
                recoveryyear=int(row[11])
                #print ("recoveryyear",recoveryyear)
            elif row[4] == 'Death':
                death=int(row[11])
                #print("death",death)
            elif row[4] == "Transmission":
                transmission = int(row[11])
            elif row[4] == "Death":
                death = int(row[11])
                #print("transmission",transmission)
        else:
            print("region:",region,"episodeweek",episodeweek,"gender",gender,"agegroup", agegroup,"occupation",occupation,"asymptomatic",asymptomatic,"onsetweekofsym",onsetweekofsym,"onsetyearofsym",onsetyearofsym,"hospitalstatus",hospitalstatus,"recovered",recovered,"recoveryweek",recoveryweek,"recoveryyear",recoveryyear,"transmission",transmission)

            if region == 1:
                insertquery=""" INSERT INTO atlantic VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"""
            elif region == 2:
                insertquery=""" INSERT INTO quebec VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"""
            elif region == 3:
                insertquery=""" INSERT INTO ontario VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"""
            elif region == 4:
                insertquery=""" INSERT INTO prairies VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"""
            elif region == 5:
                insertquery=""" INSERT INTO britishcolumbia VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"""
            previousid=int(previousId)
            previousid=int(previousId)
            recordtuple=(previousid,episodeweek,episodeyear,gender,agegroup,occupation,asymptomatic,onsetweekofsym,onsetyearofsym,hospitalstatus,recovered,recoveryweek,recoveryyear,death,transmission,region)
            cursor.execute(insertquery,recordtuple)
            connection.commit()
            if row[4] == 'Region':
                region=int(row[11])
                print("caseId",caseid)
            previousId=caseid
