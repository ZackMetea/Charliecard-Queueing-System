<?php
	$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hspidqdb";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		
			$sql = "Select 
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
		timeNew
		from mainQueue where status = 1 order by timeNew DESC LIMIT 1"; 
		$stmt = $conn->prepare($sql);
		$stmt->execute();

		$stmt->bind_result(
		$Pid,
		$fname,
		$lname,
		$bday,
		$phone,
		$email,
		$addone,
		$addtwo,
		$city,
		$state,
		$zip,
		$country,
		$rtype,
		$passtype,
		$ispu,
		$tvalue,
		$ppath,
		$additionalInfo,
		$middleInitial,
		$timeNew);
		$stmt->fetch();
		$output = array('Pid'=>$Pid,'fname'=>$fname,'lname'=>$lname,'bday'=>$bday,'phone'=>$phone,'email'=>$email,'addone'=>$addone,'addtwo'=>$addtwo,'city'=>$city,'state'=>$state,'zip'=>$zip,'country'=>$country,'rtype'=>$rtype,'passtype'=>$passtype,'ispu'=>$ispu,'tavlue'=>$tvalue,'ppath'=>$ppath,'additionalInfo'=>$additionalInfo,'middleInitial'=>$middleInitial,'timeNew'=>$timeNew);
		echo json_encode($output, JSON_FORCE_OBJECT);
?>