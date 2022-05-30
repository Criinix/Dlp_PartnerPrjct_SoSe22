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

    session_start();
    session_destroy();

    echo "Logout erfolgreich";

    echo '<div>';
    ?>

</body>

</html>
<?php
$time_start = time();
while (time() - $time_start <= 6) {
    if (time() - $time_start >= 5) {
        header('Location: http://10.3.141.1/BeerMachine/index.html');
    }
}
?>