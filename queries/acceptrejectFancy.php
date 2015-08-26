
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
	if ($_POST['accept'] == "accept") {	
		$sql = "UPDATE mainQueue set status = 1, additionalInfo ='".mysql_escape_string(trim($_POST["addInfo"]))."' where P_Id=". htmlspecialchars($_POST["pidText"]) ."";
		printf("sql = " . $sql);
		if ($conn->query($sql) === TRUE) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
    } else {
		$sql = "UPDATE mainQueue set status = 5 where P_Id=". htmlspecialchars($_POST["pidText"]) ."";
		printf("sql = " . $sql);
		if ($conn->query($sql) === TRUE) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
    }
	$conn->close();
	//header( $connecionInfoFile['acceptreject'] ) ;
?>