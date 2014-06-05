<?php
header('Access-Control-Allow-Origin: *');
$dsn = "mysql:host=localhost;dbname=drinks";
$dbuser = "root";
$dbpass = "";
$userid = $_POST["userid"];

try {	//Connect to MySQL Server & database
$pdo = new PDO($dsn, $dbuser, $dbpass);
} catch(PDOException $e) {
	die("Unable to connect to database!\n");
}

$res = $pdo->prepare("SELECT * FROM recipes WHERE mainAlcohol = 
any(SELECT alcoholName from alcohol WHERE idAlcohol = 
any(SELECT Alcohol_idAlcohol FROM bottle WHERE Bar_idBar = 
(SELECT idBar FROM bar where User_idUser = '$userid')));");
$res->execute();
$rows = $res->fetchAll();

echo json_encode($rows);
?>