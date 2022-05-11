#include <ESP8266WiFi.h>  // Bibliothek zur Webkommunikation
#include <ESP8266HTTPClient.h>
#include <Arduino.h>

//Netzwerkdaten
const char *SSID = "Home-WLAN-FG"; // Hier Netzwerkname
const char *PASS = "2937784361936540"; // Hier Netzwerkpasswort

String SERVERURL = "http://192.168.178.85/MCtestdatei.txt"; // Hier URL des Webservers
String MCcomURL = "http://192.168.178.85/MCcom.php";
uint32_t timeLoopStart;

//Anfrage an Server stellen
String serverRequest(String adr) {
  HTTPClient http;
  String url = adr;
  http.begin(url);
  int httpCode = http.GET();

  String response = http.getString();
  http.end();
  return response;
}

//Klassendefinition
class cGetraenk {
  public:
  int fuellstand;
  unsigned char pin;
  String statuswert;
  cGetraenk (int fuellstandI, unsigned char pinI, int statuswertI) {
    fuellstand = fuellstandI;
    pin = pinI;
    statuswert = statuswertI;
  }
  void pumpeEin() {
    digitalWrite(pin, LOW);
    if ((millis()-timeLoopStart)>3000) { //Status auf Server auf 0 setzen nach Zeit
      String URLStatus0 = MCcomURL + "?neuerStatusMC=0";
      serverRequest(URLStatus0);
    }
  }
  void pumpeAus() {
    digitalWrite(pin, HIGH);
  }
};

//Objekte erzeugen
cGetraenk *Wasser = new cGetraenk(400, D6, 1);
cGetraenk *Bier = new cGetraenk(500, D7, 2);

void setup() {
Serial.begin(115200);
pinMode(D5, OUTPUT); //Grüne LED, WIFI Status
pinMode(D6, OUTPUT); //Gelbe LED, simuliert Pumpe Wasser
pinMode(D7, OUTPUT); //Rote LED, simuliert Pumpe Bier
Wasser->pumpeAus();
Bier->pumpeAus();

//WIFI Connection
WiFi.begin(SSID, PASS);
int retries = 0;
while((WiFi.status() != WL_CONNECTED) && (retries < 50)) {
  retries++;
  Serial.println("Netzwerkverbindung wird hergestellt...");
  delay(500);
  
if (retries >= 50) {
  Serial.println("Fehler: Netzwerkverbindung konnte nicht hergestellt werden");
}

}
if (WiFi.status() == WL_CONNECTED) {
  Serial.println("Netzwerkverbindung hergestellt");
  digitalWrite(D5, HIGH);
}
}

void loop() {
  
if (WiFi.status() == WL_CONNECTED) {
  digitalWrite(D5, HIGH);
}

String serverResponse = serverRequest(SERVERURL);
Serial.println("Status: "+serverResponse);

if ((serverResponse != Wasser->statuswert) && (serverResponse != Bier->statuswert)) {
  Wasser->pumpeAus();
  Bier->pumpeAus();
  timeLoopStart = millis();
}
if (serverResponse == Wasser->statuswert) {
  Wasser->pumpeEin();
  Bier->pumpeAus();
}
if (serverResponse == Bier->statuswert) { 
  Bier->pumpeEin();
  Wasser->pumpeAus();
}

delay(1000);
}
