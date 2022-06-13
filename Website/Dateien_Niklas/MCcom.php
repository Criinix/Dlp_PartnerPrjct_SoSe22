<?php
$db = new mysqli("localhost", "root","123456789", "BeerMachine");
if ($db->connect_error) {
    echo $db->connect_error;
}
else {
    //MC setzt Status auf 0
    if (isset($_GET['neuerStatusMC'])) {
        $neuerStatus = $_GET['neuerStatusMC'];
        $sql = "UPDATE Mikrocontroller SET Status = $neuerStatus";
        echo $sql;
        $result=$db->query($sql);
        if ($result) {
            echo "Status auf 0 gesetzt";
        }
        else {
            echo "Statusänderung fehlgeschlagen!";
        
        }

    }


    //MC holt Status aus DB
    if (isset($_GET['Statusabfrage'])) {
        $sql = "SELECT Status FROM Mikrocontroller";
        $result = $db->query($sql);
        if ($result) {
            while ($datensatz = $result->fetch_object()) {
                echo $datensatz->Status;
            }
        }
        else {
            echo "Lesen fehlgeschlagen!<br>";
        }
    }
    
    //MC übermittelt Füllstände in Datenbank
    if (isset($_GET['standWasser']) && isset($_GET['standOSaft'])) {
        $sql = "UPDATE Mikrocontroller SET Fuellstand_Wasser = $_GET['standWasser'], Fuellstand_OSaft = $_GET['standOSaft']";
        $result = db->query($sql);
        if ($result) {
            echo "Füllstände aktualisiert";
        }
        else {
            echo "Füllstand Aktualisierung fehlgeschlagen";
        }
    }
}
?>
