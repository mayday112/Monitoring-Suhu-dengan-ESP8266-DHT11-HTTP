/*
  Rui Santos
  Complete project details at Complete project details at https://RandomNerdTutorials.com/esp8266-nodemcu-http-get-post-arduino/

  Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files.
  The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
  
  Code compatible with ESP8266 Boards Version 3.0.0 or above 
  (see in Tools > Boards > Boards Manager > ESP8266)
*/
#include <Arduino.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include <Adafruit_Sensor.h>
#include <DHT.h>

#define DHTPIN 5     // Digital pin connected to the DHT sensor

// Uncomment the type of sensor in use:
#define DHTTYPE    DHT11     // DHT 11
//#define DHTTYPE    DHT22     // DHT 22 (AM2302)
//#define DHTTYPE    DHT21     // DHT 21 (AM2301)

DHT dht(DHTPIN, DHTTYPE);

// current temperature & humidity, updated in loop()
float t = 0.0;
float h = 0.0;

const char* ssid = "Wifi ANda";
const char* password = "Password wifi Anda";

//Your Domain name with URL path or IP address with path
String serverName = "http://192.168.43.130/dht11/simpan_data_sensor.php";//contoh : http://192.168.43.130/dht11/simpan_data_sensor.php

// the following variables are unsigned longs because the time, measured in
// milliseconds, will quickly become a bigger number than can be stored in an int.
unsigned long lastTime = 0;
// Timer set to 10 minutes (600000)
//unsigned long timerDelay = 600000;
// Set timer to 5 seconds (5000)
unsigned long timerDelay = 10000;//interval pengiriman data, 10 detik

void setup() {
  Serial.begin(115200); //serial begin
  dht.begin();//begin untuk sensor DHT

  //menyambungkan ke WiFi 
  WiFi.begin(ssid, password);
  Serial.println("Connecting");
  while(WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());//mencetak ip s
 
  Serial.println("Timer set to 10 seconds (timerDelay variable), it will take 5 seconds before publishing the first reading.");
}

void loop() {
  
  // Send an HTTP POST request depending on timerDelay
  //pelajari tentang fungsi millis() jika anda bingung disini
  if ((millis() - lastTime) > timerDelay) {

  //membaca suhu
    float newT = dht.readTemperature();
    // Read temperature as Fahrenheit (isFahrenheit = true)
    //float newT = dht.readTemperature(true);
    // if temperature read failed, don't change t value
    if (isnan(newT)) {
      Serial.println("Failed to read from DHT sensor!");
    }
    else {
      //menyimpan pembacaan suhu
      t = newT;
      Serial.print("Temperature : ");
      Serial.println(t);
    }
    // Read Humidity/kelembaban
    float newH = dht.readHumidity();
    // if humidity read failed, don't change h value 
    if (isnan(newH)) {
      Serial.println(" Failed to read from DHT sensor!");
    }
    else {
      //menyimpan pembacaan
      h = newH;
      Serial.print("Humidity : ");
      Serial.println(h);
    }
    
    //Check WiFi connection status WL_CONNECTED = wifi tersambung
    if(WiFi.status()== WL_CONNECTED){
      //membuat objek client dan http
      WiFiClient client;
      HTTPClient http;

//membuat alamat tujuan API untuk menyimpan data, beserta data yang akan dikirimkan. 
//UNTUK PROJEK INI SENDIRI PENGIRIMAN DATA MENGGUNAKAN HTTP METHOD GET, JADI DATA TIDAK DI ENCODE ATAU DATA-NYA TIDAK DISEMBUNYIKAN
      String serverPath = serverName + "?temperature="+ t + "&humidity=" + h;
      
      // Your Domain name with URL path or IP address with path
      http.begin(client, serverPath.c_str());
  
      // If you need Node-RED/server authentication, insert user and password below
      //http.setAuthorization("REPLACE_WITH_SERVER_USERNAME", "REPLACE_WITH_SERVER_PASSWORD");
        
      // Send HTTP GET request
      int httpResponseCode = http.GET();
//     0 = error
      if (httpResponseCode>0) {
        Serial.print("HTTP Response code: ");
        Serial.println(httpResponseCode);
        String payload = http.getString();
//        mencetak respon dari server 
        Serial.println(payload);
      }
      else {
        Serial.print("Error code: ");
        Serial.println(httpResponseCode);
      }
      // Free resources
//      menutup http
      http.end();
    }
    else {
      Serial.println("WiFi Disconnected");
    }
//    menyimpan waktu millis()
    lastTime = millis();
  }
}
