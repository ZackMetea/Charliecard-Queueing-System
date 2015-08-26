<?php
	$connecionInfoFile = parse_ini_file("connectionInfo.ini");
	$servername = "localhost";
	$username = $connecionInfoFile['username'];
	$password = $connecionInfoFile['password'];
	$dbname = $connecionInfoFile['dbname'];
	
	$pid = $_POST['pidText'];
	//printf($pid);
	$sql = "select `P_Id`, `status` from mainQueue where P_Id='".$pid."'";
	//header('Location:http://172.17.0.57/preprod/edittable.php');
	//printf($sql);
	$conn = new mysqli($servername, $username, $password, $dbname);
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$stmt->bind_result($pidRes,$statusRes);
	$stmt->fetch();
	//printf("pid: ".$pidRes." status: ".$statusRes);
	//$output = array('status'=>$status);
	//echo json_encode($output, JSON_FORCE_OBJECT);
	if(strcmp($statusRes, "1") == 0){
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
	//echo '<script language="javascript">';
	//	echo 'alert("Message not sent")';
	//	echo '</script>';
		$sql = "UPDATE mainQueue set status = 6 where P_Id='".$pid."'";
		//printf($sql);
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		printf("Locked");
	}else{
		//echo '<script language="javascript">';
		//echo 'alert("Message sent")';
		//echo '</script>';
		//header('Location:http://172.17.0.57/preprod/edittable.php');
		printf("NotLocked");
	}
?>