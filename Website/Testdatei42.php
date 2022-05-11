<html>
<body>
    <h1> Test-HTML-Datei </h1>
<p>
    Das ist die erste Testzeile <br>
    zweite Testzeile
</p>

<a href="https://www.youtube.com/" target="_blank">Youtube Link</a>

<p> <img src="https://media.os.fressnapf.com/cms/2020/05/Ratgeber-Katze-Gesundheit-KatzeWiese_1200x527.jpg?t=cmsimg_920"> Katze </p>

<p>
<form method="get">
    Wunschgetränk: <input type ="text" name="getraenk"></input><br><br>
    <input type="submit" value="Senden"></input>
</p>

<p>
<?php
    $getraenk = $_GET['getraenk'];
    file_put_contents("aktuellesgetraenk.txt", $getraenk);
    echo "Getränk wurde auf $getraenk gesetzt<br>";
?>
</p>

<br>

<p>
<form method="get">
Status: <input type ="text" name="status"></input><br><br>
<input type="submit" value="Senden"></input>
</p>

<p>
<?php
    $status = $_GET['status'];
    file_put_contents("MCtestdatei.txt", $status);
    echo "Status in Datei MCtestdatei wurde auf $status gesetzt<br>";
?>

</body>
</html>