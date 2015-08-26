<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "hspidqdb";

	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	$date = date('Y-m-d H:i:s');
	
	//validate required fields
	$fnamethere= isset($_GET["firstname"]);		
	$lnamethere=isset($_GET["lastname"]);
	$bday1there=isset($_GET["birthDate3"]) ;
	$bday2there = isset($_GET["birthDate1"]) ;
	$bday3there = isset($_GET["birthDate2"]) ;
	$phone1there = isset($_GET["phone1"]) ;
	$phone2there = isset($_GET["phone2"]) ;
	$phone3there = isset($_GET["phone3"]) ;
	$add1there = isset($_GET["address1name"]) ;
	$citythere = isset($_GET["cityname"]) ;
	$statethere = isset($_GET["state"]) ;
	$zipthere = isset($_GET["zip"]) ;
	$countrythere = isset($_GET["country"]) ;
	$rtypethere = isset($_GET["requestType"]) ;
	$ptypethere = isset($_GET["passType"]) ;
	$pickupthere = isset($_GET["pickupType"]) ;
	
	
	//value constraints
	$bday1value = $_GET["birthDate3"]>1880;
	$bday2value = $_GET["birthDate2"]<32 and $_GET["birthDate2"]>0;
	$bday3value = $_GET["birthDate1"]<13 and $_GET["birthDate2"]>0;
	
	//type constraints
	$bday1type = is_numeric($_GET["birthDate3"]);
	$bday2type = is_numeric($_GET["birthDate2"]);
	$bday3type = is_numeric($_GET["birthDate1"]);
	$phone1type = is_numeric($_GET["phone1"]);
	$phone2type = is_numeric($_GET["phone2"]);
	$phone3type = is_numeric($_GET["phone3"]);
	$ziptype = is_numeric($_GET["zip"]);
	
	//$fnamethere and $lnamethere and $bday1there and $bday2there and $bday3there and $phone1there and $phone2there and $phone3there and $add1there
	//and $citythere and $statethere and $zipthere and $countrythere and $rtypethere and $ptypethere and $pickupthere and $bday1value and $bday2value and $bday3value
	//and $bday1type and $bday2type and $bday3type and $phone1type and $phone2type and $phone3type and $ziptype		
	
	$instorepickup = False;
	if($_GET["pickupType"]=="Yes"){
		$instorepickup = True;
	}

	$textNewDate = date($_GET["birthDate3"]."-".$_GET["birthDate1"]."-".$_GET["birthDate2"]);
	$sql = "
		REPLACE INTO mainQueue( 
		P_Id,
		firstname,
		lastname,
		birthdate,
		phonenumber,
		email,
		addressone,
		addresstwo,
		city,
		state,
		zipcode,
		country,
		requesttype,
		passtype,
		instorepickup,
		transfervalue,
		photopath,
		additionalInfo,
		middleInitial,
		exceptionreason,
		status,
		timeNew) 
		VALUES (
		DEFAULT,
		'" . htmlspecialchars($_GET["firstName"]) ."' ,
		'" . htmlspecialchars($_GET["lastName"]) ."',
		'" . htmlspecialchars($textNewDate) ."',
		'" . htmlspecialchars($_GET["phone1"].$_GET["phone2"].$_GET["phone3"]) ."',
		'" . htmlspecialchars($_GET["email"]) ."',
		'" . htmlspecialchars($_GET["address1name"]) ."',
		'" . htmlspecialchars($_GET["address2name"]) ."',
		'" . htmlspecialchars($_GET["cityname"]) ."',
		'" . htmlspecialchars($_GET["state"]) ."',
		'" . htmlspecialchars($_GET["zip"]) ."',
		'" . htmlspecialchars($_GET["country"]) ."',
		'" . htmlspecialchars($_GET["requestType"]) ."',
		'" . htmlspecialchars($_GET["passType"]) ."',
		'" . htmlspecialchars($instorepickup) ."',
		'" . htmlspecialchars($_GET["transferValue"]) ."',
		'" . htmlspecialchars($_GET["photoPath"]) ."',
		'" . htmlspecialchars($_GET["additionalInfo"]) ."',
		'" . htmlspecialchars($_GET["middleInitial"]) ."',
		'',
		'1',
		'" . $date . "')";
	if ($conn->query($sql) === TRUE) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();
	header( 'Location:http://172.17.0.57/preprod/front.html' ) ;
?>