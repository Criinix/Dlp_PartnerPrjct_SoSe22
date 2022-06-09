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
    if ($Code == 0) {
        $txt = date('d-m-y h:i:s')." | Code: ".$Code." | Verbindung: MC->Server steht";
        fwrite($file, $txt."\n");
    }
    if ($Code == 1) {
        $txt = date('d-m-y h:i:s')." | Code: ".$Code." | Wasser ausgeschenkt";
        fwrite($file, $txt."\n");
    }
    if ($Code == 2) {
        $txt = date('d-m-y h:i:s')." | Code: ".$Code." | Bier ausgeschenkt";
        fwrite($file, $txt."\n");
    }
}
else {
    echo "-1:file error";
}
?>
