<?php
if (isset($_GET['Code'])) {
}
else {
    echo "-1:missing value for Code";
}

//Code Auswerten und in logfile schreiben
$file = fopen("MClog.txt", "a");
$Code = $_GET['Code'];
if ($file) {
    //Code - Fehler
    if ($Code == -1) {
        $txt = date('d-m-y h:i:s')." | Code: ".$Code." | Fehlermeldung";    //currently not in use
        fwrite($file, $txt."\n");
    }
    if ($Code == -2) {
        $txt = date('d-m-y h:i:s')." | Code: ".$Code." | Fehlermeldung";    //currently not in use
        fwrite($file, $txt."\n");
    }
    if ($Code == -3) {
        $txt = date('d-m-y h:i:s')." | Code: ".$Code." | Fehlermeldung";    //currently not in use
        fwrite($file, $txt."\n");
    }

    //Code - normaler Eintrag in logfile
    if ($Code == 0) {  //Heartbeat
        $txt = date('d-m-y h:i:s')." | Code: ".$Code." | Verbindung: MC->Server steht";
        fwrite($file, $txt."\n");
        
        $db = new mysqli("localhost", "root", "123456789", "BeerMachine");
	    if ($db->connect_error) {
		    echo $db->connect_error;
	    }
        else {
            $sql = "UPDATE Mikrocontroller SET TimeStamp = CURRENT_TIMESTAMP";
        }
        $result = $db->query($sql);
		if ($result==true) {
			echo "Daten gespeichert!<br>";
		}
		else {
			echo "Speichern fehlgeschlagen!!<br>";
		}
    }
    if ($Code == 1) {
        $txt = date('d-m-y h:i:s')." | Code: ".$Code." | Wasser ausgegeben";
        fwrite($file, $txt."\n");
    }
    if ($Code == 2) {
        $txt = date('d-m-y h:i:s')." | Code: ".$Code." | Orangensaft ausgegeben";
        fwrite($file, $txt."\n");
    }
}
else {
    echo "-1:file error";
}
?>
