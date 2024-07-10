import mysql.connector

# Define the database connection parameters
username = 'avnadmin'
password = 'AVNS_uEF6bJfuxSZNiWz646W'
host = 'mysql-bottele-bottele.d.aivencloud.com'
port = 19333
database = 'defaultdb'

# Establish the database connection
cnx = mysql.connector.connect(
    user=username,
    password=password,
    host=host,
    port=port,
    database=database
)

# Create a cursor object to execute SQL queries
cursor = cnx.cursor()

# Retrieve the values from the 'USERS' table
query = "SELECT * FROM users"
cursor.execute(query)

# Fetch all the rows
rows = cursor.fetchall()

# Print the column names
print("Column names: ", [desc[0] for desc in cursor.description])

# Print the values
for row in rows:
    print(row)

# Close the cursor and connection
cursor.close()
cnx.close()