<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="http://10.3.141.1/BeerMachine/Website/fonts" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com ">



    <title>Login</title>
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

    <?php
    echo '<div class="Rückgabe-Bereich">'; //Anfang des Rückgabe-Feldes
    session_start(); //Erzeugen einer neuen Session
    $showFormular = true; //Variable ob das Registrierungsformular angezeigt wird
    $pdo = new pdo('mysql:host=localhost;dbname=BeerMachine', 'root', '123456789'); //Wie mysqli nur in Sicherer-Ausführung --> Prinzip gleich
    //Überprüfen der Datenbankverbindung
    if ($pdo->connect_error) {
        echo $pdo->connect_error;
    } else {
        echo "Datenbankverbindung hergestellt!<br>";
    }
    //Überprüfen ob die Felder Username und Password ausgefüllt sind
    if (isset($_POST["Username"]) && isset($_POST["Password"])) {
        $Username = $_POST["Username"];
        $Password = $_POST["Password"];
        //Abfragen des Username in der Datenbank
        $statement = $pdo->prepare("SELECT * FROM Benutzer WHERE Username = :Username");
        $result = $statement->execute(array('Username' => $Username));
        $user = $statement->fetch();
        //Überprüfen des Passworts
        if ($user !== false && password_verify($Password, $user['Password'])) { //Passwordverfiy überprüft eingegebenes Passwort mit Hashwert des eingebenen Passworts
            $_SESSION['userid'] = $user['Username'];//Username an Session-Cookie als ID übergeben
            die('Login erfolgreich. <br> Weiter zu <br>
                <a href="http://10.3.141.1/BeerMachine/GeschützterBereich.php">Geschützter Bereich</a>'); //Aufforderung in den Geschützten-Bereich zu gelangen über Button-click
            $showFormular = false;//Wenn True dann wird Login-Formular nicht mehr angezeigt
        } else {
            echo "Username oder Password war ungültig<br>";
        }
    }

    echo '</div>';
    //Wenn $showFormular true, dann wird Formular angezeigt
    if ($showFormular) {
    ?>
        <div class="login-box">
            <h2>Login</h2>
            <form method="post" action="http://10.3.141.1/BeerMachine/Login.php">
                <div class="user-box">
                    <input type="text" name="Username" required="">
                    <label>Username</label>
                </div>
                <div class="user-box">
                    <input type="password" name="Password" required="">
                    <label>Password</label>
                </div>
                <!--
            <div class="checkbox">
                <label><input type="checkbox" name="angemeldet_bleiben" value="1"> Angemeldet bleiben</label>
            </div>
            -->
                <button type="submit">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>submit
                </button>
            </form>
        </div>
    <?php
    } //Ende von if($showFormular)
    ?>


</body>
<script src=logic.js></script>
</html>