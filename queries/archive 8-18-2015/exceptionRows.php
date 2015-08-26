<?php
	$connecionInfoFile = parse_ini_file("queries/connectionInfo.ini");
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
		from mainQueue  where status=4 order by timeNew ASC LIMIT 100 ";
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
	$count = 0;
	while ($stmt->fetch()){
		$count++;
		echo "<tr>\n";
		echo "<td style=\"Display:none;\">\n<input id=\"row".$count."\" type=\"hidden\" name=\"P_Id\" size=\"10%\" value=\"",$P_Id,"\" readonly />\n";
		echo "<input id=\"addInfo".$P_Id."\" type=\"hidden\" name=\"additionalInfo\" size=\"10%\" value=\"",$additionalInfo,"\" readonly />\n</td>\n";
		echo "<td>\n<input type=\"text\" name=\"Name\" style=\"display:table-cell;width:100%;border:none\" value=\"",$fname . " ". $lname,"\" readonly />\n</td>\n";
		echo "<td>\n<input type=\"text\" name=\"phone1\" style=\"display:table-cell;width:100%;border:none\" value=\"",$phone,"\" readonly />\n</td>\n";
		echo "<td>\n<input type=\"text\" name=\"email\" style=\"display:table-cell;width:100%;border:none\" value=\"",$email,"\" readonly />\n</td>\n";
		echo "<td>\n<input type=\"text\" name=\"passType\" style=\"display:table-cell;width:100%;border:none\" value=\"",$passtype,"\" size=\"6\" readonly />\n</td>\n";
		echo "<td>\n<textarea  rows=\"2\" cols=\"50\" name=\"exceptionReason\" style=\"display:table-cell;width:100%;border:none\" readonly>",$exceptionreason."</textarea>\n</td>\n";
		echo "<td>\n<input type=\"text\" name=\"timeNew\" style=\"display:table-cell;width:100%;border:none\" value=\"",$timeNew,"\" readonly />\n</td>\n";	
		echo "<td>\n<input type=\"button\" id= \"approve\" name=\"approve\" size=\"10%\" value=\"Approve\" onClick=\"acceptButton(".$P_Id.");\" />\n";
		echo "<input type=\"button\" name=\"reject\" size=\"10%\" value=\"Reject\" onClick=\"rejectButton(".$P_Id.");\" />\n</td>\n";
		echo "</tr>\n";
	}
	$conn->close();
?>