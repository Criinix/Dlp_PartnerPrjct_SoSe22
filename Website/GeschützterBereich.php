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
echo '<div class="Begrüßung">';
session_start();
if (!isset($_SESSION['userid'])) {
    die('Bitte zuerst <a href="http://10.3.141.1/BeerMachine/Login.php">einloggen</a>');
}

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];

echo "Hallo User: " . $userid;

echo '</div>'
?>



</html>