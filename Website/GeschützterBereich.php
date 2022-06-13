<!DOCTYPE html>
<html lang="de">
<!--Erster Kommentar zum Verständnis-->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href=" https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap " rel="stylesheet">
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

    $db = new mysqli("localhost", "root","123456789", "BeerMachine");
    if ($db->connect_error) {
        echo $db->connect_error;
    }
    else {
        echo "Datenbankverbindung hergestellt!<br>";

        $sql = "UPDATE Mikrocontroller SET AktuellerUser = $userid";

        echo $sql+'<br>';
        $result = $db->query($sql);
        if ($result == true) {
            echo "Userid übergeben<br>";
        }
        else {
            echo "Speichern fehlgeschlagen<br>";
        }

    }

    echo "Hallo User: " . $userid;

    echo '</div>';


    if ($showActions) {
    ?>
        <div class="User_Input">
            <form mehtod= "GET" action="http://10.3.141.1/BeerMachine/GeschützterBereich.php">
                <button name="O-Saft" class="O-Saft_Button" type="submit">O-Saft</button>
                <button name="Wasser"class="Wasser_Button" type="submit">Wasser</button>
            
                <select size="2" name="Auswahl_LGetränk">
                    <option>--Lieblingsgetränk--</option>   
                    <option>Cola</option>
                    <option>Wasser</option>
                </select>
            </form>
            
        </div>
    <?php
    }
    ?>



</html>