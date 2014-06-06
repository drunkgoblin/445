<?php
header('Access-Control-Allow-Origin: *');
$dsn = "mysql:host=localhost;dbname=drinks";
$dbuser = "root";
$dbpass = "";

try {	//Connect to MySQL Server & database
$pdo = new PDO($dsn, $dbuser, $dbpass);
}
catch(PDOException $e) {
	die("Unable to connect to database!\n");
}
$res = $pdo->prepare("SELECT * FROM alcohol WHERE alcoholName != 'Empty'");
$res->execute();

$rows = $res->fetchAll();

echo json_encode($rows);


/*
$user = $_POST['user_name'];

$query = "SELECT points FROM users WHERE username = '$user'";
$qry_result = mysqli_query($con,$query) or die(mysql_error());
$res = mysqli_fetch_row($qry_result);
$count = mysqli_num_rows($qry_result);
if ($count < 1) {
    $res = "false";
	echo $res;
} else {
    echo $res[0];
}
mysqli_free_result($qry_result);
mysqli_close($con);
*/
?>
