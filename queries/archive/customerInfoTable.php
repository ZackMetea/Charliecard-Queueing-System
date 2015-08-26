<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "hspidqdb";
	$conn = new mysqli($servername, $username, $password, $dbname);
	$count = 0;
	do{
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		$lock = rand();
		$sql = "Update mainqueue set userchanged = ". $lock ." where status = 1 order by timeNew LIMIT 1";
		$conn = new mysqli($servername, $username, $password, $dbname);
		$stmt = $conn->prepare($sql);
		time_nanosleep(0,1000000);
		$stmt->execute();
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
			timeNew,
			userchanged
			from mainQueue where userchanged=" . $lock ." and status = 1 order by timeNew LIMIT 1"; 
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
			$timeNew,
			$userChanged);
		$stmt->fetch();
		if ($Pid != null){
			$sql = "Update mainqueue set status = 2 where P_Id=" . $Pid;
			$conn = new mysqli($servername, $username, $password, $dbname);
			$stmt = $conn->prepare($sql);
			$stmt->execute();	
		}
		$count++;
	}while($Pid == null and $count < 5);

	$output = array('Pid'=>$Pid,'fname'=>$fname,'lname'=>$lname,'bday'=>$bday,'phone'=>$phone,'email'=>$email,'addone'=>$addone,'addtwo'=>$addtwo,'city'=>$city,'state'=>$state,'zip'=>$zip,'country'=>$country,'rtype'=>$rtype,'passtype'=>$passtype,'ispu'=>$ispu,'tvalue'=>$tvalue,'ppath'=>$ppath,'additionalInfo'=>$additionalInfo,'middleInitial'=>$middleInitial,'timeNew'=>$timeNew,'lock'=>$userChanged);
	echo json_encode($output, JSON_FORCE_OBJECT);
?>