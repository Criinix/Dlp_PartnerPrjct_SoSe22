<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href=" https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap " rel="stylesheet">
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
            <a href="http://10.3.141.1/BeerMachine/Registrieren.html" class="links ">Registrieren</a>
        </div>
    </div>

    <?php
    echo '<div class="Rückgabe-Bereich">';
    session_start();
    $showFormular = true; //Variable ob das Registrierungsformular angezeigt wird
    $pdo = new pdo('mysql:host=localhost;dbname=BeerMachine', 'root', '123456789');
    if ($pdo->connect_error) {
        echo $pdo->connect_error;
    } else {
        echo "Datenbankverbindung hergestellt!<br>";
    }
    if (isset($_POST["Username"]) && isset($_POST["Password"])) {
        $Username = $_POST["Username"];
        $Password = $_POST["Password"];

        $statement = $pdo->prepare("SELECT * FROM Benutzer WHERE Username = :Username");
        $result = $statement->execute(array('Username' => $Username));
        $user = $statement->fetch();
        //Überprüfen des Passworts
        if ($user !== false && password_verify($Password, $user['Password'])) {
            $_SESSION['userid'] = $user['Username'];
            die('Login erfolgreich. Weiter zu <a href="http://10.3.141.1/BeerMachine/GeschützterBereich.php">internen Bereich</a>');
            $showFormular = false;
        } else {
            echo "Username oder Password war ungültig<br>";
        }
    }

    echo '</div>';
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

</html>