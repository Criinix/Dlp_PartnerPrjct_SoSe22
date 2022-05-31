<?php
if (isset($_GET['neuerStatusMC'])) {
    $neuerStatus = $_GET['neuerStatusMC'];
    file_put_contents("MCstatus.txt", $neuerStatus);
}

//Hier Füllstände in Datenbank speichern
?>