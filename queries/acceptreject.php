
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
		
		
if (isset($_GET['approve'])) {
        
		
        $instorepickup = False;
		if($_GET["pickupType"]=="Yes"){
			$instorepickup = True;
		}


		$sql = "UPDATE mainQueue set status = 1 where P_Id='". htmlspecialchars($_GET["P_Id"]) ."'";
		
		if ($conn->query($sql) === TRUE) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
    } else {
        $instorepickup = False;
		if($_GET["pickupType"]=="Yes"){
			$instorepickup = True;
		}


		$sql = "UPDATE mainQueue set status = 5 where P_Id='". htmlspecialchars($_GET["P_Id"]) ."'";
		if ($conn->query($sql) === TRUE) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
    }
	
			$conn->close();
	
	header( $connecionInfoFile['acceptreject'] ) ;

?>