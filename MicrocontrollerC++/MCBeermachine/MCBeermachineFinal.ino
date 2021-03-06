#include <ESP8266WiFi.h>  // Bibliothek zur Webkommunikation
#include <ESP8266HTTPClient.h>
#include <Arduino.h>

//Netzwerkdaten
const char *NAME = "BeerMachine"; // Hier Netzwerkname
const char *PASS = "123456789"; // Hier Netzwerkpasswort

String SERVERURL = "http://10.3.141.1/BeerMachine/Dateien_Niklas/MCstatus.txt"; // Hier URL des Webservers
String MCcomBase = "http://10.3.141.1/BeerMachine/Dateien_Niklas/MCcom.php"; 

//Timer
long tLoopDelay1s;
long tLoopDelay3s;
long tlastBeat;

//Hilfsvariablen
String responseStatus;
bool stateLED;
String UserID;

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
  bool isBusy;
  int fuellstand;
  int statuswert;  
  long tPumpeStart;
  unsigned char pinPumpe;
  unsigned char trigPinUSS;
  unsigned char echoPinUSS;
  
  cGetraenkeeinheit (unsigned char pinPumpeI, unsigned char trigPinUSSI, unsigned char echoPinUSSI, int statuswertI) {
    statuswert = statuswertI;
    pinPumpe = pinPumpeI;
    trigPinUSS = trigPinUSSI;
    echoPinUSS = echoPinUSSI;
  }
  
  void pumpeEin() {
    digitalWrite(pinPumpe, HIGH);
    if ((millis()-tPumpeStart)>3000) {
      String URLStatus0 = MCcomBase + "?neuerStatusMC=0";
      serverRequest(URLStatus0); //Status auf Server auf 0 setzen nach Zeit
      isBusy=0;
      responseStatus="0";
      sendtolog(statuswert);
      updateUser(statuswert, UserID);
    }
  }
  
  void pumpeAus() {
    digitalWrite(pinPumpe, LOW);
  }
  
  int getDataUSS() {
  digitalWrite(trigPinUSS, LOW);
  delay(5);
  digitalWrite(trigPinUSS, HIGH);
  delay(10);
  digitalWrite(trigPinUSS, LOW);
  int duration = pulseIn(echoPinUSS, HIGH);
  int distance = duration * 0.034/2;
  return distance;
  }
};

//Objekte erzeugen
cGetraenkeeinheit *Wasser = new cGetraenkeeinheit(D6, D1, D2, 1);  //pinPumpe|trigPinUSS|echoPinUSS|statuswert
cGetraenkeeinheit *Bier = new cGetraenkeeinheit(D7, D3, D5, 2);    //pinPumpe|trigPinUSS|echoPinUSS|statuswert

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
Wasser->pumpeAus();
Bier->pumpeAus();

//WIFI Connection
WiFi.begin(NAME, PASS);
int retries = 0;
while((WiFi.status() != WL_CONNECTED) && (retries < 50)) {
  retries++;
  Serial.println("Netzwerkverbindung wird hergestellt...");
  delay(500);
  
  if (retries >= 50) {
    Serial.println("Fehler: Netzwerkverbindung konnte nicht hergestellt werden!");
  }
}

if (WiFi.status() == WL_CONNECTED) {
  Serial.println("Netzwerkverbindung hergestellt");
}
}

//-------------------------------------------------------Loop-----------------------------------------------------

void loop() {

checkWiFiconnection(); //inklusive Heartbeat

if ((millis()-tLoopDelay1s)>1000) {
  responseStatus = serverRequest(MCcomBase+"?Statusabfrage=1");
  Serial.println("Status: "+responseStatus);
  UserID = getUserID();
  Serial.println("Aktueller User: "+UserID);
  tLoopDelay1s = millis();
}

actOnStatus();

if ((millis()-tLoopDelay3s)>30000) {
  Wasser->fuellstand = 20-Wasser->getDataUSS();
  Bier->fuellstand = 20-Bier->getDataUSS();
  sendFuellstand();
  Serial.println("F??llstand Wasser: " + (String)Wasser->fuellstand + "   " + "F??llstand OSaft: " + (String)Bier->fuellstand);
  if (Wasser->fuellstand<0) {
    sendtolog(-1); 
  }
  if (Bier->fuellstand<0) {
    sendtolog(-2); 
  }
  tLoopDelay3s = millis();
}

}

//--------------------------------------------------------Functions----------------------------------------------------

void checkWiFiconnection() {
  if (WiFi.status() == WL_CONNECTED) {
    heartbeat();
  }
  else {
    digitalWrite(D4, LOW);
    stateLED = 1;
    Serial.println("Netzwerkverbindung verloren!");
  }
}

//Heartbeat - LED blinken lassen
void heartbeat() {
  if (!stateLED) {
    if (millis()-tlastBeat>50) {
      stateLED = !stateLED;
      digitalWrite(D4,stateLED);  // LED an
    }
  }
  else {
    if (millis()-tlastBeat>30000) {
      stateLED = !stateLED;
      digitalWrite(D4,stateLED);  // LED aus
      tlastBeat=millis();
      sendtolog(0); //R??ckmeldung beim Server
    }
  }
}

//Statusantwort auswerten
void actOnStatus() {
  if ((responseStatus == (String)Wasser->statuswert)&&(Wasser->isBusy == 0)&&(Bier->isBusy == 0)&&(Wasser->fuellstand>=0)) {
    Wasser->isBusy = 1;
    Wasser->tPumpeStart=millis();
    Serial.println("Wasser is busy");     
  }
  if ((responseStatus == (String)Bier->statuswert)&&(Wasser->isBusy == 0)&&(Bier->isBusy == 0)&&(Bier->fuellstand>=0)) {
    Bier->isBusy = 1;
    Bier->tPumpeStart=millis();
    Serial.println("Bier is busy"); 
  }

  if (Wasser->isBusy) {
    Wasser->pumpeEin();
  }
  else {
    Wasser->pumpeAus();
  }
  if (Bier->isBusy) {
    Bier->pumpeEin();
  }
  else {
    Bier->pumpeAus();
  }
}

//Meldung in logfile schreiben
void sendtolog(int Code) {
  String logURL = "http://10.3.141.1/BeerMachine/Dateien_Niklas/MCwritelog.php?Code="+(String)Code;
  //Serial.println(logURL);
  if (serverRequest(logURL)) {
  Serial.println("Eintrag mit Code: "+(String)Code+" in logfile geschrieben");
  }
  else {
      Serial.println("Eintrag mit Code: NICHT logfile geschrieben");
    }
}

//Aktuelle User ID aus DB holen
String getUserID() {
  String UserIDURL = MCcomBase+"?Userabfrage=1";
  String responseUserID = serverRequest(UserIDURL);
  return responseUserID;
}

//F??llst??nde an Server senden
void sendFuellstand() {
  String dataUssURL = MCcomBase+"?standWasser="+Wasser->fuellstand+"&standOSaft="+Bier->fuellstand;
  //Serial.println(dataUssURL);
  serverRequest(dataUssURL);
}

//Getr??nk ausgegeben, Update User Getr??nekmenge
void updateUser(int statuswert, String UserID) {
  String updateUserURL = MCcomBase+"?getraenk="+statuswert+"&UserID="+UserID;
  serverRequest(updateUserURL);
}