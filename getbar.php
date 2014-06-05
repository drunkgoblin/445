<?php
header('Access-Control-Allow-Origin: *');
$dsn = "mysql:host=localhost;dbname=drinks";
$dbuser = "root";
$dbpass = "";
$userID = $_POST["userid"];

try {	//Connect to MySQL Server & database
$pdo = new PDO($dsn, $dbuser, $dbpass);
} catch(PDOException $e) {
	die("Unable to connect to database!\n");
}

$res = $pdo->prepare("SELECT * FROM alcohol NATURAL JOIN bottle WHERE idAlcohol = Alcohol_idAlcohol AND Bar_idBar = 
					(SELECT idBar FROM bar WHERE User_idUser='$userID')");
$res->execute();
$rows = $res->fetchAll();

echo json_encode($rows);
?>