<?php
	$connecionInfoFile = parse_ini_file("connectionInfo.ini");
	$servername = "localhost";
	$username = $connecionInfoFile['username'];
	$password = $connecionInfoFile['password'];
	$dbname = $connecionInfoFile['dbname'];
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	$pid = $_POST['P_Id'];
	$sql = "UPDATE mainQueue set status = 4 where P_Id='".$pid."'";
	printf($sql);
	$stmt = $conn->prepare($sql);
	$stmt->execute();
?>