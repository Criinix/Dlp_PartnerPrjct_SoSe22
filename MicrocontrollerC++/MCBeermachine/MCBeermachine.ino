#include <ESP8266WiFi.h>  // Bibliothek zur Webkommunikation
#include <ESP8266HTTPClient.h>
#include <Arduino.h>

//Netzwerkdaten
const char *SSID = "Home-WLAN-FG"; // Hier Netzwerkname
const char *PASS = "2937784361936540"; // Hier Netzwerkpasswort

String SERVERURL = "http://192.168.178.85/MCstatus.txt"; // Hier URL des Webservers
String MCcomURL = "http://192.168.178.85/MCcom.php"; 

//Timer
uint32_t tLoopStart;
uint32_t tgetDataUSS;
uint32_t theartbeat;

//Hilfsvariablen
String responseStatus;
String stateLED;

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

//----------------------------------------------Klasse und Objekte--------------------------------------------------------------

//Klassendefinition
class cGetraenkeeinheit {
  public:
  int fuellstand;
  unsigned char pinPumpe;
  unsigned char trigPinUSS;
  unsigned char echoPinUSS;
  String statuswert;
  
  cGetraenkeeinheit (int fuellstandI, unsigned char pinPumpeI, unsigned char trigPinUSSI, unsigned char echoPinUSSI, int statuswertI) {
    fuellstand = fuellstandI;
    pinPumpe = pinPumpeI;
    trigPinUSS = trigPinUSSI;
    echoPinUSS = echoPinUSSI;
    statuswert = statuswertI;
  }
  
  void pumpeEin() {
    digitalWrite(pinPumpe, LOW);
    if ((millis()-tLoopStart)>3000) { //Status auf Server auf 0 setzen nach Zeit
      String URLStatus0 = MCcomURL + "?neuerStatusMC=0";
      serverRequest(URLStatus0);
    }
  }
  
  void pumpeAus() {
    digitalWrite(pinPumpe, HIGH);
  }
  
  int getDataUSS() {
  digitalWrite(trigPinUSS, LOW);
  delay(5);
  digitalWrite(trigPinUSS, HIGH);
  delay(10);
  digitalWrite(trigPinUSS, LOW);
  int duration = pulseIn(echoPinUSS, HIGH);
  int distance = duration * 0.034/2;
  fuellstand = 20-distance;
  return distance;
  //Serial.println("Abstand: " + (String)distance + " cm");
  }
};

//Objekte erzeugen
cGetraenkeeinheit *Wasser = new cGetraenkeeinheit(0, D6, D1, D2, 1);  //fuellstand|pinPumpe|trigPinUSS|echoPinUSS|statuswert
cGetraenkeeinheit *Bier = new cGetraenkeeinheit(0, D7, D3, D5, 2);    //fuellstand|pinPumpe|trigPinUSS|echoPinUSS|statuswert

//---------------------------------------------------Setup---------------------------------------------------------

void setup() {
Serial.begin(115200);
pinMode(D4, OUTPUT);                  //Blaue LED, WIFI Status/Heartbeat
pinMode(Wasser->pinPumpe, OUTPUT);    //Gelbe LED, simuliert Pumpe Wasser
pinMode(Bier->pinPumpe, OUTPUT);      //Rote LED, simuliert Pumpe Bier
pinMode(Wasser->trigPinUSS, OUTPUT);  //Trigger-Pin 1
pinMode(Wasser->echoPinUSS, INPUT);   //Echo-Pin 1
pinMode(Bier->trigPinUSS, OUTPUT);    //Trigger-Pin 2
pinMode(Bier->echoPinUSS, INPUT);     //Echo-Pin 2
digitalWrite(D4, HIGH);               //Blaue LED ausschalten
stateLED="aus";
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
    digitalWrite(D4, LOW);
    stateLED = "an";
  }
}

//-------------------------------------------------------Loop-----------------------------------------------------

void loop() {

checkWiFiconnection(); //inklusive Heartbeat

if ((millis()-tgetDataUSS)>1000) {
  Wasser->fuellstand = 20-Wasser->getDataUSS();
  Bier->fuellstand = 20-Bier->getDataUSS();
  Serial.println("Füllstand Wasser: " + (String)Wasser->fuellstand + "   " + "Füllstand Bier: " + (String)Bier->fuellstand);
  tgetDataUSS = millis();
}

responseStatus = serverRequest(SERVERURL);
Serial.println("Status: "+responseStatus);
checkStatus();

delay(1000);
}

//--------------------------------------------------------Functions----------------------------------------------------

void checkWiFiconnection() {
  if (WiFi.status() == WL_CONNECTED) {
    heartbeat();
  }
  else {
    digitalWrite(D4, HIGH);
    stateLED = "aus";
  }
}

//Heartbeat - LED blinken lassen
void heartbeat() {
  if (stateLED=="aus") {
    if ((millis()-theartbeat)>3000) {
      digitalWrite(D4, LOW);
      stateLED = "an";
    }
  }
  else {
    if ((millis()-theartbeat)>50) { //geht nicht durch delay in loop!!!!!!!!!!!!!!!!!!!!!!!!!!!!
      digitalWrite(D4, HIGH);
      stateLED = "aus";
      theartbeat = millis();
    }
  }
}

//Statusantwort auswerten
void checkStatus() {
  if ((responseStatus != Wasser->statuswert) && (responseStatus != Bier->statuswert)) {
    Wasser->pumpeAus();
    Bier->pumpeAus();
    tLoopStart = millis();
  }
    if (responseStatus == Wasser->statuswert) {
    Wasser->pumpeEin();
    Bier->pumpeAus();
  }
    if (responseStatus == Bier->statuswert) { 
    Bier->pumpeEin();
    Wasser->pumpeAus();
  }
}
