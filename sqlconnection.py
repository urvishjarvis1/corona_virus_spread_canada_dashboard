import pymysql as sql

connection = sql.connect(host="localhost",user="root",passwd="",database="coronavirusvisualization")
cursor = connection.cursor()
region_table= """ CREATE TABLE IF NOT EXISTS region_table ( reg_id INT(20) PRIMARY KEY AUTO_INCREMENT, region_name CHAR(200))"""

cursor.execute(region_table)
atlantictabel = """ CREATE TABLE IF NOT EXISTS atlantic
( case_id INT(20) PRIMARY KEY,
episodeweek INT(20),
gender CHAR(200),
agegroup INT(20),
occupation INT(20),
asymptomatic INT(20),
onsetweekofsym INT(20),
onsetyearofsym INT(20),
hospitalstatus INT(20),
recovered INT(20),
recoveryweek INT(20),
recoveryyear INT(20),
transmission INT(20),
reg_id INT(20),FOREIGN KEY (reg_id)  REFERENCES region_table(reg_id)) """
cursor.execute(atlantictabel)

atlantictabel = """ CREATE TABLE IF NOT EXISTS quebec
( case_id INT(20) PRIMARY KEY,
episodeweek INT(20),
gender CHAR(200),
agegroup INT(20),
occupation INT(20),
asymptomatic INT(20),
onsetweekofsym INT(20),
onsetyearofsym INT(20),
hospitalstatus INT(20),
recovered INT(20),
recoveryweek INT(20),
recoveryyear INT(20),
transmission INT(20),
reg_id INT(20),FOREIGN KEY (reg_id)  REFERENCES region_table(reg_id)) """
cursor.execute(atlantictabel)

atlantictabel = """ CREATE TABLE IF NOT EXISTS ontario
( case_id INT(20) PRIMARY KEY,
episodeweek INT(20),
gender CHAR(200),
agegroup INT(20),
occupation INT(20),
asymptomatic INT(20),
onsetweekofsym INT(20),
onsetyearofsym INT(20),
hospitalstatus INT(20),
recovered INT(20),
recoveryweek INT(20),
recoveryyear INT(20),
transmission INT(20),
reg_id INT(20),FOREIGN KEY (reg_id)  REFERENCES region_table(reg_id)) """
cursor.execute(atlantictabel)

atlantictabel = """ CREATE TABLE IF NOT EXISTS prairies
( case_id INT(20) PRIMARY KEY,
episodeweek INT(20),
gender CHAR(200),
agegroup INT(20),
occupation INT(20),
asymptomatic INT(20),
onsetweekofsym INT(20),
onsetyearofsym INT(20),
hospitalstatus INT(20),
recovered INT(20),
recoveryweek INT(20),
recoveryyear INT(20),
transmission INT(20),
reg_id INT(20),FOREIGN KEY (reg_id)  REFERENCES region_table(reg_id)) """
cursor.execute(atlantictabel)

atlantictabel = """ CREATE TABLE IF NOT EXISTS britishcolumbia
( case_id INT(20) PRIMARY KEY,
episodeweek INT(20),
gender CHAR(200),
agegroup INT(20),
occupation INT(20),
asymptomatic INT(20),
onsetweekofsym INT(20),
onsetyearofsym INT(20),
hospitalstatus INT(20),
recovered INT(20),
recoveryweek INT(20),
recoveryyear INT(20),
transmission INT(20),
reg_id INT(20),FOREIGN KEY (reg_id)  REFERENCES region_table(reg_id)) """



cursor.execute(atlantictabel)
connection.close()
