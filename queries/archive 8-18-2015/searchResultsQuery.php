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
		additionalInfo,
		middleInitial,
		expDate,
		timeNew
		from mainQueue
		Where 
		(status = 1 ) and
		firstname LIKE '%" . $_GET['firstName'] ."%' and  
		lastname LIKE '%" . $_GET['lastName'] ."%' and  
		email LIKE '%" . $_GET['email'] ."%' and 
		phonenumber LIKE '%" . $_GET['phone'] ."%' 
		order by timeNew DESC LIMIT 100";
	

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
		$expDate,
		$timeNew);
	
	echo "<table style=\"width:100%\">\n";
	echo "<tr>\n";
	echo "<td>First Name</td>\n";
	echo "<td>Last Name</td>\n";
	echo "<td>Birthday</td>\n";
	echo "<td>Email</td>\n";
	echo "<td>Address</td>\n";
	echo "<td>Pass</td>\n";
	echo "<td>Pick up in Store</td>\n";

	echo "<td>Time stamp</td>\n";
	echo "<td>Action</td>\n";
	echo "</tr>\n";
	$count = 0;
	while ($stmt->fetch()){
		$count++;
		if($ispu == 1){
			$ispu = "Yes";
		}
		else{
			$ispu = "No";
		}
		echo "<tr id=\"row".$count."\">\n";
		echo "<td style=\"Display:none\"><input  name=\"P_Id\" value=\"",$P_Id,"\" readonly></td>\n";
		echo "<td><input type=\"text\" name=\"firstName\" value=\"",$fname,"\" readonly></td>\n";
		echo "<td><input type=\"text\" name=\"lastName\" value=\"",$lname,"\" readonly></td>\n";
		echo "<td><input type=\"text\" name=\"birthDate1\" value=\"",$bday,"\" size=\"6\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input  name=\"phone1\" value=\"",$phone,"\" readonly></td>\n";
		echo "<td><input type=\"text\" name=\"email\" value=\"",$email,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input  name=\"address1name\" value=\"",$addone,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input  name=\"address2name\" value=\"",$addtwo,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input  name=\"city\" value=\"",$city,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input  name=\"state\" value=\"",$state,"\" readonly>";
		echo "<td><input type=\"text\" name=\"addressconcate\" value=\"",$addone.", ". $city .", " . $state,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input  name=\"zip\" value=\"",$zip,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input  name=\"country\" value=\"",$country,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input  name=\"requestType\" value=\"",$rtype,"\" readonly></td>\n";
		echo "<td><input type=\"text\" name=\"passType\" value=\"",$passtype,"\" size=\"6\" readonly></td>\n";
		echo "<td><input type=\"text\" name=\"pickupType\" value=\"",$ispu,"\" size=\"10\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input  name=\"transferValue\" value=\"",$tvalue,"\" readonly></td>\n";	
		echo "<td style=\"Display:none\"><input  name=\"photoPath\" value=\"",$ppath,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input  name=\"additionalInfo\" value=\"",$additionalInfo,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input  name=\"middleInitial\" value=\"",$middleInitial,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input  name=\"expDate1\" value=\"",$expDate,"\" readonly></td>\n";
		echo "<td><input type=\"text\" name=\"timeNew\" value=\"",$timeNew,"\" readonly></td>\n";	
		echo "<td><input type=\"button\" name=\"printcard\" value=\"Edit Record\" onclick=\"createFormFunction('row".$count."')\" /></td>\n";
		echo "</tr>\n";
	}
	echo "</table>\n";
	$conn->close();
?>