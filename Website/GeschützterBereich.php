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
    echo "<br>";
    $MAC = 1;
    $db = new mysqli("localhost", "root","123456789", "BeerMachine");
    if ($db->connect_error) {
        echo $db->connect_error;
    }
    else {
        echo "<br>Datenbankverbindung hergestellt!<br>";
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
        $sql = "SELECT Fuelstand_Wasser from Mikrocontroller WHERE MAC = 1";
        $result = $db->query($sql);

        if($result) {
            $FüllstandWasser = $result->fetch_object();
            echo $FüllstandWasser;
        }

        $sql = "SELECT Fuelstand_OSaft from Mikrocontroller WHERE MAC = 1";
        $result = $db->query($sql);

        if($result) {
            $FüllstandOSaft = $result->fetch_object();
            echo $FüllstandOSaft;
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
        <div  id="Log" class="Log"></div>
    <script>
        window.onload = function() {
            div = document.getElementById('Log');
            var linksrc = "http://10.3.141.1/BeerMachine/Dateien_Niklas/MClog.txt";
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    let response = this.responseText;
                    div.innerHTML += response;
                    div.style.color = '#03e9f4';
                    div.style.background = 'rgba(0, 0, 0, .5)';
                    div.style.width = '450px';
                    div.style.height = 'auto';
                    div.style.borderRadius = '5px';
                    div.style.borderColor = 'black';
                    div.style.marginLeft = '70%';
                    div.style.boxShadow = '0 15px 25px rgba(0, 0, 0, .6)';
                    div.style.paddingLeft = '15px';
                }
            }
            xhr.open("GET", linksrc);
            xhr.send();
        }
    </script>
    <?php
    }
    ?>

   
    

</body>
</html>