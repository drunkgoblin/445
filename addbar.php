<?php
header('Access-Control-Allow-Origin: *');
$dsn = "mysql:host=localhost;dbname=drinks";
$dbuser = "root";
$dbpass = "";
$userID = $_POST["userid"];
$alcohol = $_POST["alcohol"];
$quantity = $_POST["quantity"];
$quanttype = $_POST["quanttype"];

try {	//Connect to MySQL Server & database
$pdo = new PDO($dsn, $dbuser, $dbpass);
}
catch(PDOException $e) {
	die("Unable to connect to database!\n");
}

/*$res = $pdo->prepare("SELECT * FROM alcohol NATURAL JOIN bottle WHERE alcoholName = '$alcohol' AND Bar_idBar = 
					(SELECT idBar FROM bar WHERE User_idUser='$userID')"*/
$res = $pdo->prepare("SELECT idBar FROM bar WHERE User_idUser='$userID';");
$res->execute();
$ru = $res->fetch();
$res = $pdo->prepare("SELECT idAlcohol FROM alcohol WHERE alcoholName='$alcohol';");
$res->execute();
$run = $res->fetch();
$ins = $pdo->prepare("INSERT INTO bottle VALUES('$quantity','$quanttype','$ru[0]','$run[0]');");
$ins->execute();
//$rows = $res->fetch();

?>