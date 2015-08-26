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
		from mainQueue  order by timeNew DESC LIMIT 100 ";
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
		$additionalInfo,
		$middleInitial,
		$timeNew);
	echo "<table style=\"width:100%\">";
	echo "<tr>";
	echo "<td>First Name</td>";
	echo "<td>Last Name</td>";
	echo "<td>Birthday</td>";
	echo "<td>Email</td>";
	echo "<td>Address</td>";
	echo "<td>Pass</td>";
	echo "<td>Pick up in Store</td>";

	echo "<td>Time stamp</td>";
	echo "<td>Action</td>";

	while ($stmt->fetch()){
		echo "<form action=\"frontReplace.html\" method=\"get\">";
		if($ispu == 1){
			$ispu = "Yes";
		}
		else{
			$ispu = "No";
		}
		echo "<tr>";
		echo "<input type=\"hidden\" name=\"P_Id\" value=\"",$P_Id,"\" readonly>";
		echo "<td><input type=\"text\" name=\"firstName\" value=\"",$fname,"\" readonly></td>";
		echo "<td><input type=\"text\" name=\"lastName\" value=\"",$lname,"\" readonly></td>";
		echo "<td><input type=\"text\" name=\"birthDate1\" value=\"",$bday,"\" size=\"6\" readonly></td>";
		echo "<input type=\"hidden\" name=\"phone1\" value=\"",$phone,"\" readonly>";
		echo "<td><input type=\"text\" name=\"email\" value=\"",$email,"\" readonly></td>";
		echo "<input type=\"hidden\" name=\"address1name\" value=\"",$addone,"\" readonly>";
		echo "<input type=\"hidden\" name=\"address2name\" value=\"",$addtwo,"\" readonly>";
		echo "<input type=\"hidden\" name=\"city\" value=\"",$city,"\" readonly>";
		echo "<input type=\"hidden\" name=\"state\" value=\"",$state,"\" readonly>";	
		echo "<td><input type=\"text\" name=\"addressconcate\" value=\"",$addone.", ". $city .", " . $state,"\" readonly></td>";
		echo "<input type=\"hidden\" name=\"zip\" value=\"",$zip,"\" readonly>";
		echo "<input type=\"hidden\" name=\"country\" value=\"",$country,"\" readonly>";
		echo "<input type=\"hidden\" name=\"requestType\" value=\"",$rtype,"\" readonly>";
		echo "<td><input type=\"text\" name=\"passType\" value=\"",$passtype,"\" size=\"6\" readonly></td>";
		echo "<td><input type=\"text\" name=\"pickupType\" value=\"",$ispu,"\" size=\"10\" readonly></td>";
		echo "<input type=\"hidden\" name=\"transferValue\" value=\"",$tvalue,"\" readonly>";	
		echo "<input type=\"hidden\" name=\"photoPath\" value=\"",$ppath,"\" readonly>";
		echo "<input type=\"hidden\" name=\"additionalInfo\" value=\"",$additionalInfo,"\" readonly>";
		echo "<input type=\"hidden\" name=\"middleInitial\" value=\"",$middleInitial,"\" readonly>";
		echo "<td><input type=\"text\" name=\"timeNew\" value=\"",$timeNew,"\" readonly></td>";	
		echo "<td><input type=\"submit\" name=\"printcard\" value=\"Edit Record\" /></td>";
		echo "</form>";
		echo "</tr>";
	}
	echo "</table>";
	$conn->close();
?>