<?php
	$connecionInfoFile = parse_ini_file("connectionInfo.ini");
	$servername = "localhost";
	$username = $connecionInfoFile['username'];
	$password = $connecionInfoFile['password'];
	$dbname = $connecionInfoFile['dbname'];
	
	$pid = $_POST['pidText'];
	//$sql = "select `P_Id`, `status` from mainQueue where P_Id='".$pid."'";
	$sql = "UPDATE mainQueue set status = 6 where P_Id='".$pid."' and status = 4";
	//printf($sql);
	$conn = new mysqli($servername, $username, $password, $dbname);
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	//$stmt->bind_result($pidRes,$statusRes);
	//$count = $stmt->rowCount();
	$count = $stmt->affected_rows;
	printf($count);
?>