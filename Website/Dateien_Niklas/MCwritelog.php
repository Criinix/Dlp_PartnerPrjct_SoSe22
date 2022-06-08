<?php
if ((isset($_GET['errorCode']))or(isset($_GET['Code']))) {
}
else {
    echo "-1:missing value for errorCode/Code";
}

//errorCode Auswerten und in logfile schreiben
$file = fopen("MClog.txt", "a");
$errorCode = $_GET['errorCode'];
$Code = $_GET['Code'];
if ($file) {
    //errocCode - Fehler
    if ($errorCode == -1) {
        $txt = date('d-m-y h:i:s')." | ErrorCode: ".$errocCode;
        fwrite($file, $txt."\n");
    }
    if ($errorCode == -2) {
        $txt = date('d-m-y h:i:s')." | ErrorCode: ".$errocCode;
        fwrite($file, $txt."\n");
    }
    if ($errorCode == -3) {
        $txt = date('d-m-y h:i:s')." | ErrorCode: ".$errocCode;
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