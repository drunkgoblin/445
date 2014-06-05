<?php
header('Access-Control-Allow-Origin: *');
$dsn = "mysql:host=localhost;dbname=drinks";
$dbuser = "root";
$dbpass = "";
$user = $_POST["username"];
$newid = -1;
$row = null;
try {	//Connect to MySQL Server & database
$pdo = new PDO($dsn, $dbuser, $dbpass);
}
catch(PDOException $e) {
	die("Unable to connect to database!\n");
}
$res = $pdo->prepare("SELECT idUser FROM user WHERE uName='$user'");
$res->execute();
$rows = $res->fetch();

if (is_null($rows[0])) {
$maxid = $pdo->prepare("SELECT MAX(idUser) AS mx FROM user");
$maxid->execute();
$row = $maxid->fetch();
$newid = $row[mx] + 1;
$ins = $pdo->prepare("INSERT INTO user VALUES('$newid','$user')");
$ins->execute();
}
if ($newid !== -1) {
echo $newid;
} else {
echo $rows[0];
}

?>