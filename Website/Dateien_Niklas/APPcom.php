<?php
$db = new mysqli("localhost", "root","123456789", "BeerMachine");
if ($db->connect_error) {
    echo $db->connect_error;
}
else {
    //Status in Datenbank ändern
    if (isset($_GET['neuerStatusAPP'])) {
        $neuerStatus = $_GET['neuerStatusAPP'];
        $sql = "UPDATE Mikrocontroller SET Status = $neuerStatus";
        $result = $db->Query($sql);

        if ($result) {
            echo "Status aktualisiert";
        }
        else {
            echo "Statusänderung fehlgeschlagen!";
        
        }
        //file_put_contents("APPcomTest.txt", $neuerStatus); //Test mit Textdatei

    }

    //Status aus Datenbank abfragen
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
        echo file_get_contents('APPcomTest.txt');
    }
}
?>