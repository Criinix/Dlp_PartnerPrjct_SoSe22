cButton ButtonWasser;
cButton ButtonOSaft;
String APPcomBase = "http://10.3.141.1/BeerMachine/Dateien_Niklas/APPcom.php";

void setup() {
  size(1000, 1000);
  frameRate(1);
  ButtonWasser = new cButton(color(255,0,0),100,100,"Wasser", 1); 
  ButtonOSaft = new cButton(color(255,0,0),600,100,"Orangensaft", 2); 
}

void draw() {
  background(0,0,50);
  String[] retVal;
  retVal = loadStrings("http://10.3.141.1/BeerMachine/Dateien_Niklas/APPcom.php?Statusabfrage=1");
  textSize(32);
  
  if (int(retVal[0]) == 0) {
    text("Was wollen Sie trinken?", 200, 700);
  }
  else if (int(retVal[0]) == 1) {
    text("Wasser wird ausgegeben", 200, 700);
  }
  else if (int(retVal[0]) == 2) {
      text("Orangensaft wird ausgegeben", 200, 700);
  }
  else {
      text("Verbindung zum Server fehlgeschlagen", 200, 700);
  }
  
  ButtonWasser.display();
  ButtonOSaft.display();
}

void mousePressed() {
  ButtonWasser.mouseOver(mouseX, mouseY);
  ButtonOSaft.mouseOver(mouseX, mouseY);
}

class cButton { 
  color c;
  float xPos;
  float yPos;
  float xSize;
  float ySize;
  String tag;
  int status;
  cButton(color colI, float xPosI, float yPosI, String tagI, int statusI) { 
    c = colI;
    xPos = xPosI;
    yPos = yPosI;
    xSize = 200;
    ySize = 100;
    tag = tagI;
    status = statusI;
  }
  void display() {
    stroke(0);
    fill(c);
    rectMode(CORNER);
    rect(xPos,yPos,xSize,ySize);
    textSize(32);
    fill(255, 255, 255);
    text(tag, xPos+10, yPos+ySize/2+10);
  }
  boolean mouseOver(int mX, int mY){
   if ( mX >= xPos && mX <=xPos+xSize && mY >= yPos && mY < yPos+ySize) {
     String StatusUpdateURL = APPcomBase+"?neuerStatusAPP="+status;
     println(StatusUpdateURL);
     loadStrings(StatusUpdateURL);
     return true;
   }
   return false;
 }
}
