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
        <button class="Home_Button">BeerMachine</button>
        <div class="Menu ">
            <button class="Home_Button" onclick="IndexAufrufen()">BeerMachine</button>
            <a href="# " class="links ">Statistik</a>
            <a href="# " class="links ">Log</a>
            <a href="http://10.3.141.1/BeerMachine/Registrieren.html" class="links ">Registrieren</a>
        </div>
    </div>

    <script src=logic.js></script>




    <?php
    echo '<div class="Rückgabe-Bereich">';

    session_start(); //Session wird übergeben
    session_destroy();//Session wird beendet-->User wird augeloggt

    echo "Logout erfolgreich";

    echo '<div>';
    ?>

</body>
<script src=logic.js></script>
</html>
<?php
//nach 3s wird der User zurück auf die Index-Seite geleitet
$time_start = time();
while (time() - $time_start <= 4) {
    if (time() - $time_start >= 3) {
        header('Location: http://10.3.141.1/BeerMachine/index.html');
    }
}
?>