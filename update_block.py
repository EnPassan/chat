import sqlite3
from send import sent_question
connect = sqlite3.connect("database/database.sqlite")
cursor = connect.cursor()
new_body = sent_question()
request_2 = cursor.execute("UPDATE blogs SET body=? WHERE id=?",[new_body, 1])
connect.commit()
print(new_body)

