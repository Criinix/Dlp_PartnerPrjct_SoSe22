<?php
if (isset($_GET['neuerStatusMC'])) {
    $neuerStatus = $_GET['neuerStatusMC'];
    file_put_contents("MCtestdatei.txt", $neuerStatus);
}

//Hier Füllstände in Datenbank speichern
?>