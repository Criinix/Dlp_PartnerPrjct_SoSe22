<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href=" https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap " rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com ">



    <title>Registrierung</title>
</head>

<body>
    <div class="navbar ">
        <button class="Home_Button" onclick="IndexAufrufen()">BeerMachine</button>
        <div class="Menu ">
            <a href="http://10.3.141.1/BeerMachine/Login.html" class="links ">Login</a>
            <a href="# " class="links ">Statistik</a>
            <a href="# " class="links ">Log</a>
            <a href="http://10.3.141.1/BeerMachine/Registrieren.html" class="links ">Registrieren</a>
        </div>
    </div>

    <?php
    echo '<div class="Rückgabe-Bereich">';//Anfang des Rückgabe-Feldes
    session_start();//Erzeugen einer neuen Session
    $showFormular = true; //Variable ob das Registrierungsformular angezeigt wird
    $pdo = new pdo('mysql:host=localhost;dbname=BeerMachine', 'root', '123456789');//Wie mysqli nur in Sicherer-Ausführung --> Prinzip gleich
    if ($pdo->connect_error) {
        echo $pdo->connect_error;
    } else {
        echo "Datenbankverbindung hergestellt!<br>";
        //Deklarieren der benötigten Variablen zur Übergabe der Eingebenen Daten
        $error = false;
        $Username = "";
        $Password = "";
        $Password2 = "";
        //Überprüfen ob Username eingegeben wurde
        if (!isset($_POST["Username"])) {
            echo "Username fehlt!<br>";
            $error = true;
        } else {
            $Username = $_POST["Username"];
        }
        //Überprüfen ob Passwort eingegeben wurde
        if (!isset($_POST["Password"])) {
            echo "Password fehlt!<br>";
            $error = true;
        } else {
            $Password = $_POST["Password"];
        }
        //Überprüfen ob Passwort wiederholt wurde
        if (!isset($_POST["Password-wdh"])) {
            echo "Username wiederholen!<br>";
            $error = true;
        } else {
            $Password2 = $_POST["Password-wdh"];
        }
        //Überprüfen ob Passwörter übereinstimmen
        if ($Password != $Password2) {
            echo 'Die Passwörter müssen übereinstimmen<br>';
            $error = true;
        }
        //Überprüfen ob es den Username schon gibt
        if (!$error) {
            $statement = $pdo->prepare("SELECT * FROM Benutzer WHERE Username = :Username");
            $result = $statement->execute(array('Username' => $Username));
            $user = $statement->fetch();

            if ($user !== false) {
                echo 'Dieser Username ist bereits vergeben<br>';
                $error = true;
            }
        }
        //Wenn alles eingetragen und Username noch nicht vorhanden
        if (!$error) {
            //Password von Klartext in Hashwert umwandeln
            $passwort_hash = password_hash($Password, PASSWORD_DEFAULT);

            //Username und Password in Datenbank Tabelle Benutzer eintragen
            $statement = $pdo->prepare("INSERT INTO Benutzer (Username, Password) VALUES(:Username, :Password)");
            $result = $statement->execute(array('Username' => $Username, 'Password' => $passwort_hash));

            //Überprüfen ob Username und Password gespeichert wurden
            if ($result == true) {
                echo "Du wurdest erfolgreich registriert<br><br>Klicke nun auf den LOGIN-Button<br>Um dich einzuloggen";
                $showFormular = false;
            } else {
                echo "Speichern fehlgeschlagen!!<br>";
            }
        }

        echo '</div>';
    }
    //Wenn $showFormular true, dann wird Formular angezeigt
    if ($showFormular) {
    ?>
        <div class="login-box">
            <h2>Registrieren</h2>
            <form method="post" action="http://10.3.141.1/BeerMachine/Registrieren.php">
                <div class="user-box">
                    <input type="text" name="Username" required="">
                    <label>Username</label>
                </div>
                <div class="user-box">
                    <input type="password" name="Password" required="">
                    <label>Password</label>
                </div>
                <div class="user-box">
                    <input type="password" name="Password-wdh" required="">
                    <label>Password wiederholen</label>
                </div>
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

</html>