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
		(status in (1,2,6) ) and
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
	
	echo "<table style=\"border: none; width:100%\">\n";
	echo "<tr>\n";
	echo "<td style = \"width: 20%\">Name</td>\n";
	
	echo "<td style = \"width: 6%\">Birthday</td>\n";
	echo "<td style = \"width: 7%\">Phone</td>\n";
	
	echo "<td style = \"width: 25%\">Address</td>\n";
	echo "<td style = \"width: 4%\">Pass</td>\n";
	
	echo "<td style = \"width: 30%\">Additional Info</td>\n";

	echo "<td style = \"width: 15%\">Time stamp</td>\n";
	echo "<td style = \"width: 4%\">Action</td>\n";
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
		echo "<td style=\"Display:none\"><input name=\"P_Id\" style=\"border: none; width: 100%\" value=\"",$P_Id,"\" readonly></td>\n";
		echo "<td><input type=\"text\" name=\"Name\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$fname,", ",$lname,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input  name=\"firstName\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$fname,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input name=\"lastName\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$lname,"\" readonly></td>\n";
		echo "<td><input type=\"text\" name=\"birthDate1\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$bday,"\" size=\"6\" readonly></td>\n";
		echo "<td><input type=\"text\" name=\"phone1\"  style=\"border: none; display: table-cell; width: 100%\" value=\"",$phone,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input name=\"email\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$email,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input name=\"address1name\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$addone,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input name=\"address2name\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$addtwo,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input name=\"city\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$city,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input name=\"state\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$state,"\" readonly></td>\n";	
		echo "<td><input type=\"text\" name=\"addressconcate\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$addone.", ". $city .", " . $state,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input name=\"zip\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$zip,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input name=\"country\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$country,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input name=\"requestType\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$rtype,"\" readonly></td>\n";
		echo "<td><input type=\"text\" name=\"passType\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$passtype,"\" size=\"6\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input name=\"pickupType\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$ispu,"\" size=\"10\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input name=\"transferValue\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$tvalue,"\" readonly></td>\n";	
		echo "<td style=\"Display:none\"><input name=\"photoPath\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$ppath,"\" readonly></td>\n";
		echo "<td><input type=\"text\" name=\"additionalInfo\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$additionalInfo,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input name=\"middleInitial\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$middleInitial,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input name=\"expDate1\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$expDate,"\" readonly></td>\n";
		echo "<td><input type=\"text\" name=\"timeNew\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$timeNew,"\" readonly></td>\n";	
		echo "<td><input type=\"button\" name=\"printcard\" style=\"border: none; display: table-cell; width: 100%\" value=\"Edit Record\" onclick=\"createFormFunction('row".$count."')\" /></td>\n";
		echo "</tr>\n";
	}
	echo "</table>\n";
	$conn->close();
?>