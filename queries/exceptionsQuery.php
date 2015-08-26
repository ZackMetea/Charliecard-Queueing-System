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
		exceptionreason,
		status,
		additionalInfo,
		timeNew
		from mainQueue  where status=4 order by timeNew DESC LIMIT 100 ";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$stmt->bind_result(
		$P_Id,
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
		
		$exceptionreason,
		$status,
		$additionalInfo,
		$timeNew);

	echo "<table style=\"width:100%\">";
	echo "<tr>";
	echo "<td>Name</td>";
	echo "<td>Phone #</td>";

	echo "<td>Email</td>";
	echo "<td>Pass Type</td>";
	echo "<td>In store pick up</td>";
	echo "<td>Reason</td>";

	echo "<td>Time of request</td>";
	echo "<td>Action</td>";

	while ($stmt->fetch()){
	echo "<form action=\"acceptreject.php\" method=\"get\">";
		if($ispu == 1){
			$ispu = "Yes";
		}
		else{
			$ispu = "No";
		}
		echo "<tr>";
		echo "<input type=\"hidden\" name=\"P_Id\" value=\"",$P_Id,"\" readonly>";
		echo "<td><input type=\"text\" name=\"Name\" value=\"",$fname . " ". $lname,"\" readonly></td>";
		echo "<input type=\"hidden\" name=\"firstName\" value=\"",$fname,"\" readonly>";
		echo "<input type=\"hidden\" name=\"lastName\" value=\"",$lname,"\" readonly>";
		echo "<input type=\"hidden\" name=\"birthDate1\" value=\"",$bday,"\" size=\"6\" readonly>";
		echo "<td><input type=\"text\" name=\"phone1\" value=\"",$phone,"\" readonly></td>";
		echo "<td><input type=\"text\" name=\"email\" value=\"",$email,"\" readonly></td>";
		echo "<input type=\"hidden\" name=\"address1name\" value=\"",$addone,"\" readonly>";
		echo "<input type=\"hidden\" name=\"address2name\" value=\"",$addtwo,"\" readonly>";
		echo "<input type=\"hidden\" name=\"city\" value=\"",$city,"\" readonly>";
		echo "<input type=\"hidden\" name=\"state\" value=\"",$state,"\" readonly>";	
		echo "<input type=\"hidden\" name=\"addressconcate\" value=\"",$addone.", ". $city .", " . $state,"\" readonly>";
		echo "<input type=\"hidden\" name=\"zip\" value=\"",$zip,"\" readonly>";
		echo "<input type=\"hidden\" name=\"country\" value=\"",$country,"\" readonly>";
		echo "<input type=\"hidden\" name=\"requestType\" value=\"",$rtype,"\" readonly>";
		echo "<td><input type=\"text\" name=\"passType\" value=\"",$passtype,"\" size=\"6\" readonly></td>";
		echo "<td><input type=\"text\" name=\"pickupType\" value=\"",$ispu,"\" size=\"10\" readonly></td>";
		echo "<input type=\"hidden\" name=\"transferValue\" value=\"",$tvalue,"\" readonly>";	
		echo "<input type=\"hidden\" name=\"photoPath\" value=\"",$ppath,"\" readonly>";
		echo "<input type=\"hidden\" name=\"additionalInfo\" value=\"",$additionalInfo,"\" readonly>";
		echo "<input type=\"hidden\" name=\"status\" value=\"",$status,"\" readonly>";
		echo "<td><input type=\"text\" name=\"exceptionReason\" value=\"",$exceptionreason,"\" readonly></td>";
		echo "<td><input type=\"text\" name=\"timeNew\" value=\"",$timeNew,"\" readonly></td>";	
		echo "<td><input type=\"submit\" id= \"approve\" name=\"approve\" value=\"Approve\" />";
		echo "<input type=\"submit\" name=\"reject\" value=\"Reject\" /></td>";
		echo "</form>";
		echo "</tr>";
	}
	echo "</table>";
	$conn->close();
?>