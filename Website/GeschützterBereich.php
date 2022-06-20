<!DOCTYPE html>
<html lang="de">
<!--Erster Kommentar zum Verständnis-->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="http://10.3.141.1/BeerMachine/Website/fonts" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com ">



    <title>Schankanlage Grande & Donath</title>
</head>

<body>
    <div class="navbar ">
        <button class="Home_Button" onclick="IndexAufrufen()">BeerMachine</button>
        <div class="Menu ">
            <a href="http://10.3.141.1/BeerMachine/Login.html" class="links ">Login</a>
            <a href="# " class="links ">Statistik</a>
            <a href="# " class="links ">Log</a>
            <a href="http://10.3.141.1/BeerMachine/Logout.php" class="links ">Logout</a>
        </div>
    </div>
</body>
<script src=logic.js></script>
<?php
    $showActions = true;
    echo '<div class="Begrüßung">';
    session_start();
    if (!isset($_SESSION['userid'])) {
        die('Bitte zuerst <a href="http://10.3.141.1/BeerMachine/Login.html">einloggen</a>');
        $showActions = false;
    }

    //Abfrage der Nutzer ID vom Login
    //Abfrage der Nutzer ID vom Login
    $userid = $_SESSION['userid'];
    echo "Hallo User: " . $userid;
    $MAC = 1;
    $db = new mysqli("localhost", "root","123456789", "BeerMachine");
    if ($db->connect_error) {
        echo $db->connect_error;
    }
    else {
        echo "Datenbankverbindung hergestellt!<br>";
        //Aktuellen User an Mikrocontroller übergeben
        $sql = "UPDATE Mikrocontroller SET AktuellerUser = '$userid' WHERE MAC = '$MAC'";

        //echo $sql+'<br>';
        $result = $db->query($sql);
        if ($result == true) {
            echo "Userid übergeben<br>";
        }
        else {
            echo "Speichern fehlgeschlagen<br>";
        }
        //Status MC auf O-Saft setzen
        if(isset($_GET['O-Saft'])) {
            $sql = "UPDATE Mikrocontroller SET Status = 2 WHERE MAC = '$MAC'";
            $result = $db->query($sql);
            if ($result == true) {
                echo "O-Saft wird zubereitet<br>";
            }
            else {
                echo "Befehl fehlgeschlagen<br>";
            }
        }
        //Status MC auf Wasser setzen
        if(isset($_GET['Wasser'])) {
            $sql = "UPDATE Mikrocontroller SET Status = 1 WHERE MAC = '$MAC'";
            $result = $db->query($sql);
        if ($result == true) {
                echo "Wasser wird zubereitet<br>";
            }
        else {
                echo "Befehl fehlgeschlagen<br>";
            }
        }
        //Lieblingsgetränk ändern
        if(isset($_GET['LGetränk'])) {
            $LGetränk = $_GET['LGetränk'];
            $sql = "SELECT Lieblingsgetränk from Benutzer WHERE Username = '$userid'";

            $result = $db->query($sql);

            if ($result) {
                $Lieblingsgetränk = $result->fetch_object();

                if($Lieblingsgetränk != $_GET['LGetränk']) {
                        $sql = "UPDATE Benutzer SET Lieblingsgetränk ='$LGetränk' WHERE Username = '$userid' ";
                        $result = $db->query($sql);
                    if ($result == true) {
                            echo "Lieblingsgetränk aktualisiert<br>";
                        }
                    else {
                            echo "Aktualisierung fehlgeschlagen<br>";
                        }
                }
            }

        }


    }

  

    echo '</div>';


    if ($showActions) {
    ?>
        <div class="User_Input">
            <form method= "GET" action="http://10.3.141.1/BeerMachine/GeschützterBereich.php">
                <button name="O-Saft" class="O-Saft_Button" type="submit">O-Saft</button><br>
                <button name="Wasser"class="Wasser_Button" type="submit">Wasser</button><br><br>
            
                <u>Lieblingsgetränk:</u><br>
                <select name="LGetränk">
                    <!--<option>--Lieblingsgetränk--</option>   -->
                    <option>O-Saft</option>
                    <option>Wasser</option>
                </select>
            </form>
            
        </div>
    <?php
    }
    ?>



</html>