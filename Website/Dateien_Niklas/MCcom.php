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
            while ($datensatz = $result->fetch_objekt()) {
                echo $datensatz->Status;
            }
        }
        else {
            echo "Lesen fehlgeschlagen!<br>";
        }
    }
}


//Hier Füllstände in Datenbank speichern
?>
