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
	$pid = $_POST['pidText'];
	$processedBy = $_POST['processedBy'];
	$cardSerial =$_POST['cardSerial'];
	$expiration =$_POST['expiration'];
	if($_POST['updateAdd']=="Yes"){
		$updateAdd=1;
	}else{
		$updateAdd=0;
	}
	if($_POST['monthlyPassTransfer']=="Yes"){
		$monthlyPassTransfer=1;
	}else{
		$monthlyPassTransfer=0;
	}
	$transferValue = floatval($_POST['transferValue']);
	$dateCompleted = date('Y-m-d H:i:s');
	$val = $_POST['additionalInfo'];
	$addValNew = mysql_escape_string(trim($val));
	$sql = "INSERT INTO `csrhistory`(
		`trans_Id`, 
		`P_Id`, 
		`CSR_name`, 
		`dateCompleted`, 
		`newCardSerial`, 
		`newCardExpiration`, 
		`updateAddress`,
		`monthlyPassTransfer`,
		`transferValue` ) VALUES (DEFAULT,'"
		. $pid."','"
		. $processedBy."','"
		.$dateCompleted."','"
		.$cardSerial ."','"
		. $expiration."','"
		.$updateAdd ."','"
		.$monthlyPassTransfer."',"
		.$transferValue."
		)";
	echo $sql;
	$fileName = 'statementLogs/sqlRecordCompletedLogFile.txt';
	$theTime = date('m/d/Y H:i:s', time());
	$logText = $theTime . " - " . trim(preg_replace('/\t+/','',str_replace(array("\r","\n"),"",$sql))) . PHP_EOL;
	file_put_contents($fileName, $logText, FILE_APPEND);
	if ($conn->query($sql) === TRUE) {
		echo "New record created successfully";
	} else {
		 $fileName = 'statementLogs/sqlRecordCompletedLogFile.txt';
		$theTime = date('m/d/Y H:i:s', time());
		$logText = $theTime . " - " . trim(preg_replace('/\t+/','',str_replace(array("\r","\n"),"",$sql))) . PHP_EOL;
		file_put_contents($fileName, $conn->error, FILE_APPEND);
	} 
	$sql = "UPDATE mainQueue set status = 3, additionalInfo = '".$addValNew."' where P_Id='".$pid."'";
	$fileName = 'statementLogs/sqlRecordCompletedLogFile.txt';
	$theTime = date('m/d/Y H:i:s', time());
	$logText = $theTime . " - " . trim(preg_replace('/\t+/','',str_replace(array("\r","\n"),"",$sql))) . PHP_EOL;
	file_put_contents($fileName, $logText, FILE_APPEND);
	printf($sql);
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->query($sql) === TRUE) {
		echo "New record created successfully";
	} else {		
		$fileName = 'statementLogs/sqlRecordCompletedLogFile.txt';
		$theTime = date('m/d/Y H:i:s', time());
		$logText = $theTime . " - " . trim(preg_replace('/\t+/','',str_replace(array("\r","\n"),"",$sql))) . PHP_EOL;
		file_put_contents($fileName, $conn->error, FILE_APPEND);
	}
?>