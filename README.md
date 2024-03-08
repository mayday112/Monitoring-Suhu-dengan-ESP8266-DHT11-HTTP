- Projek ini menggunakan XAMPP dengan database MySQL, ESP8266, sensor DHT11
- Pengiriman data dilakukan melalui DHT11->ESP8266->HTTP(GET methode)->API->database server
- untuk melihat pembacaan sensor dilakukan melalui web browser
  
=================================================

Disini saya menggunakan XAMPP dan database MySQL 

-setelah didownload dalam bentuk ZIP
- ekstrak projek ini ke htdocs atau root dari server kalian
- buka xampp, nyalakan apache server dan mysql
- klik admin disebelah mysql di xampp
- buat database dengan nama dht11
- lalu impor file .sql yang sdh diekstrak tadi
====================================================


skema wiring ESP8266 ==> DHT11
---------                      -------
|ESP8266| D1(GPIO 5) ---->data |DHT11|
---------                      -------


================================================
 buka file .ino pada folder esp8266
pada kode
const char* ssid = "Wifi ANda";
const char* password = "Password wifi Anda";

ganti ssid dengan ssid wifi anda
dan ganti password dengan password wifi anda

pada 
//Your Domain name with URL path or IP address with path
String serverName = "http://192.168.43.130/dht11/simpan_data_sensor.php";//contoh : http://192.168.43.130/dht11/simpan_data_sensor.php
ganti IP "192.168.43.130" dengan IP address laptop atau kompute yang anda jadikan server, caranya :
-pastikan esp dan server(komputer anda) nantinya tersambung pada jaringan yang sama
-buka CMD pada komputer anda
-ketik "ipconfig", lalu enter
-copy IP pada  IPv4 Address 
-masukkan IP ke kode diatas


upload program 
buka browser anda
masukkan url "localhost/dht11"



credits :
https://randomnerdtutorials.com/esp8266-dht11dht22-temperature-and-humidity-web-server-with-arduino-ide/
https://randomnerdtutorials.com/esp8266-nodemcu-http-get-post-arduino/
https://www.w3schools.com/js/js_json.asp
https://www.w3schools.com/js/js_json_php.asp


library yg sy gunakan:
https://getbootstrap.com/
https://www.chartjs.org/
https://bernii.github.io/gauge.js/

