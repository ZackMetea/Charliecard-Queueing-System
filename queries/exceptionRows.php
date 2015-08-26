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
		middleInitial,
		expDate,
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
		$middleInitial,
		$expDate,
		$timeNew);
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
		echo "<td style=\"Display:none;\">\n<input id=\"row".$count."\" type=\"hidden\" name=\"P_Id\" size=\"10%\" value=\"",$P_Id,"\" readonly />\n";
		echo "<input id=\"addInfo".$P_Id."\" type=\"hidden\" name=\"additionalInfo\" size=\"10%\" value=\"",$additionalInfo,"\" readonly />\n</td>\n";
		echo "<td>\n<input type=\"text\" name=\"Name\" style=\"display:table-cell;width:100%;border:none\" value=\"",$fname . " ". $lname,"\" readonly />\n</td>\n";
		echo "<td style=\"Display:none\"><input  name=\"firstName\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$fname,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input name=\"lastName\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$lname,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input name=\"birthDate1\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$bday,"\" size=\"6\" readonly></td>\n";
		echo "<td><input type=\"text\" name=\"phone1\"  style=\"border: none; display: table-cell; width: 100%\" value=\"",$phone,"\" readonly></td>\n";
		echo "<td>\n<input type=\"text\" name=\"email\" style=\"display:table-cell;width:100%;border:none\" value=\"",$email,"\" readonly />\n</td>\n";
		echo "<td style=\"Display:none\"><input name=\"address1name\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$addone,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input name=\"address2name\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$addtwo,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input name=\"city\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$city,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input name=\"state\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$state,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input name=\"zip\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$zip,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input name=\"country\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$country,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input name=\"requestType\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$rtype,"\" readonly></td>\n";	
		echo "<td>\n<input type=\"text\" name=\"passType\" style=\"display:table-cell;width:100%;border:none\" value=\"",$passtype,"\" size=\"6\" readonly />\n</td>\n";
		echo "<td style=\"Display:none\"><input name=\"pickupType\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$ispu,"\" size=\"10\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input name=\"transferValue\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$tvalue,"\" readonly></td>\n";	
		echo "<td style=\"Display:none\"><input name=\"photoPath\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$ppath,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input type=\"text\" name=\"additionalInfo\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$additionalInfo,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input name=\"middleInitial\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$middleInitial,"\" readonly></td>\n";
		echo "<td style=\"Display:none\"><input name=\"expDate1\" style=\"border: none; display: table-cell; width: 100%\" value=\"",$expDate,"\" readonly></td>\n";
		echo "<td>\n<textarea  rows=\"2\" cols=\"50\" name=\"exceptionReason\" style=\"display:table-cell;width:100%;border:none\" readonly>",$exceptionreason."</textarea>\n</td>\n";
		echo "<td>\n<input type=\"text\" name=\"timeNew\" style=\"display:table-cell;width:100%;border:none\" value=\"",$timeNew,"\" readonly />\n</td>\n";	
		echo "<td>\n<input type=\"button\" id= \"approve\" name=\"approve\" size=\"10%\" value=\"Approve\" onClick=\"acceptButton(".$P_Id.");\" />\n";
		echo "<input type=\"button\" name=\"reject\" size=\"10%\" value=\"Reject\" onClick=\"rejectButton(".$P_Id.");\" />\n";
		echo "<input type=\"button\" name=\"editRecord\" size=\"10%\" value=\"Edit Record\" onclick=\"createFormFunction('row".$count."','Exceptions')\" />\n";
		echo "</td>\n";
		echo "</tr>\n";
	}
	$conn->close();
?>