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
	//To Do
	$sql = "SELECT count(*) FROM mainqueue where status = 1";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$stmt->bind_result($toDoCount);
	$stmt->fetch();
	//Completed
	$conn = new mysqli($servername, $username, $password, $dbname);
	$sql = "SELECT count(*) FROM mainqueue where status = 3";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$stmt->bind_result($completedCount);
	$stmt->fetch();
	//Total
	$conn = new mysqli($servername, $username, $password, $dbname);
	$sql = "SELECT count(*) FROM mainqueue where 1";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$stmt->bind_result($totalCount);
	$stmt->fetch();
	//Oldest
	$conn = new mysqli($servername, $username, $password, $dbname);
	$sql = "SELECT timeNew FROM mainqueue where status = 1 order by timeNew LIMIT 1";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$stmt->bind_result($oldestRecord);
	$stmt->fetch();
	$tempDate = strtotime($oldestRecord);
	$formattedOldestRecord = date('m-d-Y H:i:s', $tempDate);
	$output = array('toDoCount'=>$toDoCount,'completedCount'=>$completedCount,'totalCount'=>$totalCount,'oldestRecord'=>$formattedOldestRecord);
	echo json_encode($output, JSON_FORCE_OBJECT);
?>