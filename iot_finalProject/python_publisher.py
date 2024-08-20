import paho.mqtt.client as mqtt
import json
import mysql.connector

# MQTT Configuration
broker_address = "172.20.10.2"  # Adjust if different
port = 1883
subscribe_topic = "iot_lab6/temperature"  # Adjust to your topic structure

# MySQL Database Configuration
db_host = "localhost"  # Adjust if different
db_user = "root"
db_password = "ayobalima"
db_name = "spiffs"

# Callback when the client receives a CONNACK response from the server
def on_connect(client, userdata, flags, rc, properties=None):
    print("Connected with result code "+str(rc))
    client.subscribe(subscribe_topic)

# Callback for when a PUBLISH message is received from the server
def on_message(client, userdata, msg):
    print(f"Received message on topic: {msg.topic} with payload: {msg.payload}")
    try:
        # Extract temperature value from the payload
        temperature = str(msg.payload.decode('utf-8'))
        print("Temperature:", temperature)
        
        # Insert temperature data into the database
        insert_temperature(temperature)
    except ValueError as e:
        print("Error decoding temperature value:", e)
    except Exception as e:
        print("An unexpected error occurred:", e)

def insert_temperature(temperature):
    try:
        # Connect to the MySQL database
        db_connection = mysql.connector.connect(
            host=db_host,
            user=db_user,
            password=db_password,
            database=db_name
        )
        cursor = db_connection.cursor()

        # Insert the temperature data into the database
        sql = "INSERT INTO sensor_data (temperature) VALUES (%s)"
        val = (temperature,)
        cursor.execute(sql, val)
        db_connection.commit()

        print("Temperature data inserted into the database")
    except mysql.connector.Error as err:
        print("Error:", err)
    finally:
        # Close the database connection
        cursor.close()
        db_connection.close()

client = mqtt.Client(client_id="MQTTSubscriber", callback_api_version=mqtt.CallbackAPIVersion.VERSION2)
client.on_connect = on_connect
client.on_message = on_message

client.connect(broker_address, port=port)
client.loop_forever()
