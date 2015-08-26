<html>
	<head>
		<link rel="stylesheet" type="text/css" href="styles/stylesZack.css" />
		<script src="javascript/navigationFunctions.js"></script>
	</head>
	<body id="main_page">
		<div id="main_div">
			<div id="header">
				<div id="logopad">
					<img id="mbta_intranet_logo" src="images/mbta-logo-white.png" alt="mbta intranet logo" style="height:50px; width:50px">
				</div>
				<div id="headertext">
					<h1>Work in Progress</h1>
				</div>
			</div>
			<!--<div id="searchbar_div">
				<form action="searchResults.php" method="get">
						 First Name:
					<input type="text" name="firstName" >
						 Last Name:
					<input type="text" name="lastName" >
						 Phone Number:
					<input type="text" name="phone" >
						 Email:
					<input type="text" name="email" >
					<input type="submit" value="Search" />&#160;</p>
				</form>
			</div>-->
			<div id="content_div">
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
						timechanged,
						exceptionreason,
						status,
						additionalInfo,
						timeNew
						from mainQueue  where status=2 order by timeNew ASC LIMIT 100 ";
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
						$timeChanged,
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
					//echo "<td>In store pick up</td>";
					echo "<td>Time record has been open</td>";

					echo "<td>Time of request</td>";
					echo "<td>Action</td>";

					while ($stmt->fetch()){
					echo "<form action=\"queries/release.php\" method=\"get\">";
					$dateCompleted = date('Y-m-d H:i:s');
						if($ispu == 1){
							$ispu = "Yes";
						}
						else{
							$ispu = "No";
						}
						if($status==2){
							$exceptionreason = "Record is either currently being produced or has been locked out of the system.  If no one is currently producing cards, accept this record.";
						}
						echo "<tr>";
						echo "<input type=\"hidden\" name=\"P_Id\" size=\"10%\" value=\"",$P_Id,"\" readonly>";
						echo "<td><input type=\"text\" name=\"Name\" style=\"display:table-cell;width:100%;border:none\" value=\"",$fname . " ". $lname,"\" readonly></td>";
						echo "<input type=\"hidden\" name=\"firstName\" size=\"10%\" value=\"",$fname,"\" readonly>";
						echo "<input type=\"hidden\" name=\"lastName\" size=\"10%\" value=\"",$lname,"\" readonly>";
						echo "<input type=\"hidden\" name=\"birthDate1\" size=\"10%\" value=\"",$bday,"\" size=\"6\" readonly>";
						echo "<td><input type=\"text\" name=\"phone1\" style=\"display:table-cell;width:100%;border:none\" value=\"",$phone,"\" readonly></td>";
						echo "<td><input type=\"text\" name=\"email\" style=\"display:table-cell;width:100%;border:none\" value=\"",$email,"\" readonly></td>";
						echo "<input type=\"hidden\" name=\"address1name\" size=\"10%\" value=\"",$addone,"\" readonly>";
						echo "<input type=\"hidden\" name=\"address2name\" size=\"10%\" value=\"",$addtwo,"\" readonly>";
						echo "<input type=\"hidden\" name=\"city\" size=\"10%\" value=\"",$city,"\" readonly>";
						echo "<input type=\"hidden\" name=\"state\" size=\"10%\" value=\"",$state,"\" readonly>";	
						echo "<input type=\"hidden\" name=\"addressconcate\" size=\"10%\" value=\"",$addone.", ". $city .", " . $state,"\" readonly>";
						echo "<input type=\"hidden\" name=\"zip\" size=\"10%\" value=\"",$zip,"\" readonly>";
						echo "<input type=\"hidden\" name=\"country\" size=\"10%\" value=\"",$country,"\" readonly>";
						echo "<input type=\"hidden\" name=\"requestType\" size=\"10%\" value=\"",$rtype,"\" readonly>";
						echo "<td><input type=\"text\" name=\"passType\" style=\"display:table-cell;width:100%;border:none\" value=\"",$passtype,"\" size=\"6\" readonly></td>";
						echo "<input type=\"text\" name=\"pickupType\" size=\"10%\" value=\"",$ispu,"\" size=\"10\" hidden readonly>";
						echo "<input type=\"hidden\" name=\"transferValue\" size=\"10%\" value=\"",$tvalue,"\" readonly>";	
						echo "<input type=\"hidden\" name=\"photoPath\" size=\"10%\" value=\"",$ppath,"\" readonly>";
						echo "<input type=\"hidden\" name=\"additionalInfo\" size=\"10%\" value=\"",$additionalInfo,"\" readonly>";
						echo "<input type=\"hidden\" name=\"status\" size=\"10%\" value=\"",$status,"\" readonly>";
						echo "<input type=\"hidden\" rows=\"2\" cols=\"50\" name=\"exceptionReason\" style=\"display:table-cell;width:100%;border:none\" value=\"",$exceptionreason,"\" readonly>";
						$interval = date_diff(date_create_from_format('Y-m-d H:i:s',$timeChanged),date_create_from_format('Y-m-d H:i:s',$dateCompleted));
						echo "<td><input type=\"text\" name=\"timeChanged\" style=\"display:table-cell;width:100%;border:none\" value=\"", $interval->format('%H:%i:%s'),"\" readonly></td>";
						echo "<td><input type=\"text\" name=\"timeNew\" style=\"display:table-cell;width:100%;border:none\" value=\"",$timeNew,"\" readonly></td>";	
						echo "<td><input type=\"submit\" id= \"approve\" name=\"approve\" size=\"10%\" style=\"display:table-cell;width:100%\" value=\"Release Record\" />";
						
						echo "</form>";
						echo "</tr>";
					}
					echo "</table>";
					$conn->close();
				?>
				<p align="center">
					<input type="button" id="goHome" value="Go Home" onclick="home()" />
				</p>
			</div>
		</div>
	
	</body>
</html>