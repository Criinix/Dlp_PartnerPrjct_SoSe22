
<html>
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
        <button class="Home_Button ">BeerMachine</button>
        <div class="Menu ">
            <a href="http://10.3.141.1/BeerMachine/Login.html" class="links ">Login</a>
            <a href="# " class="links ">Statistik</a>
            <a href="# " class="links ">Log</a>
            <a href="# " class="links ">Registrieren</a>
        </div>
    </div>
<?php
    if ( !isset($_POST["Username"])) {
    echo "Username fehlt!<br>";
    }
    if ( !isset($_POST["Password"])) {
        echo "Password fehlt!<br>";
    }
    if ( !isset($_POST["Password-wdh"])) {
        echo "Username wiederholen!<br>";
    }
    	// Daten in Datenbank schreiben		-> php Biliothek "mysqli"
	$db = new mysqli("localhost", "root", "123456789", "BeerMachine");
	if ($db->connect_error) {
		echo $db->connect_error;
	}
	else {
		
		echo "Datenbankverbindung hergestellt!<br>";

		// SQL 
		    $sql = "INSERT INTO Benutzer (Username, Password) VALUES ('".$_GET["Username"]."', '".$_GET["Password"]."')";
		    // SQL zum Datensatz verändern: "UPDATE"
		
		    echo $sql;
		    echo "<br>";
		
		    // sql an Datenbank schicken:
		    $result = $db->query($sql);
		    if ($result==true) {
		    	echo "Daten gespeichert!<br>";
		    }
		    else {
		    	echo "Speichern fehlgeschlagen!!<br>";
		
		    }
        }

	
?>
</body>
</html>