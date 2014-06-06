<?php
header('Access-Control-Allow-Origin: *');
$dsn = "mysql:host=localhost;dbname=drinks";
$dbuser = "root";
$dbpass = "";
$userid = $_POST["userid"];
$ret;
$mix;
$ret2;
$mix2;
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
$rows = json_encode($rows);
for ($i = 0; $i < count($rows); ++$i) {
	$t = $rows[$i].idRecipies;
	$r = $rows[$i].mainAlcohol;
	$mix[$i] = $pdo->prepare("SELECT * FROM ingredient 
	NATURAL JOIN alcohol 
	WHERE Alcohol_idAlcohol = idAlcohol 
	AND Recipies_idRecipies = '$t' 
	AND alcoholName != 'Empty' 
	AND alcoholName != '$r';");
	$ret[$i] = $pdo->prepare("SELECT * FROM ingredient 
	NATURAL JOIN mixer 
	WHERE Recipies_idRecipies = '$t' 
	AND mixerName != 'Empty' 
	AND Mixer_idMixer = idMixer;");
	$mix[$i]->execute();
	$mix2[$i] = $mix[$i]->fetchAll();
	$ret[$i]->execute();
	$ret2[$i] = $ret[$i]->fetchAll();
}
/*for ($i = 0; $i < count($mix2); ++$i) {
$mix2[$i] = json_encode($mix2[$i]);
}
$ret2 = json_encode($ret2);*/
$arr = array('a' => $rows, 'b' => $mix2, 'c' => $ret2);

echo json_encode($arr);
?>