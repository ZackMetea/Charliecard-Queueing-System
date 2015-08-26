<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="styles/stylesZack.css" />
		<script src="javascript/jquery-1.11.3.min.js"></script>
		<script src="javascript/navigationFunctions.js"></script>
		<script src="javascript/editRecordFunctions.js"></script>
        <script type="text/javascript" src="javascript/fancyBox/jquery.fancybox.pack.js"></script>
		<link rel="stylesheet" href="javascript/fancyBox/jquery.fancybox.css" type="text/css" media="screen" />
		<script type="text/javascript">
				function acceptQuery(){
					var P_Id = document.getElementById("pidHolderAccept").value;					
					$.ajax({
						type: "POST",
						url: "queries/acceptrejectFancy.php",
						data: {
							pidText: P_Id,
							accept: "accept",
							addInfo: document.getElementById("additionalInfo").value
						}
					}).done(function(msg) {
						window.location.reload(true);
					});
				}
				function acceptButton(P_Id){
					var textAreaName = "addInfo" + P_Id;
					document.getElementById("pidHolderAccept").value = P_Id;
					document.getElementById("additionalInfo").value = document.getElementById(textAreaName).value;
					$.fancybox({
						'href': "#fancyBoxDivAccept",
						'hideOnContentClick': true,
						'modal': true
					});
				}
				function rejectQuery(){
					var P_Id = document.getElementById("pidHolder").value;	
					$.ajax({
						type: "POST",
						url: "queries/acceptrejectFancy.php",
						data: {
							pidText: P_Id,
							accept: "reject"
						}
					}).done(function(msg) {
						window.location.reload(true);
					});
				}
				function rejectButton(P_Id){
					document.getElementById("pidHolder").value = P_Id;
					$.fancybox({
						'href': "#fancyBoxDivReject",
						'hideOnContentClick': true, 
						'modal': true
					});
				}
				
		</script>
	</head>
	<body id="main_page">
		<div id="main_div">
			<div id="header">
				<div id="logopad">
					<img id="mbta_intranet_logo" src="images/mbta-logo-white.png" alt="mbta intranet logo" style="height:50px; width:50px">
				</div>
				<div id="headertext">
					<h1>Exceptions Queue</h1>
				</div>
			</div>
			<div id="content_div">
				<table style="width:100%">
					<tr>
						<td>Name</td>
						<td>Phone #</td>
						<td>Email</td>
						<td>Pass Type</td>
						<!-- <td>In store pick up</td>"; -->
						<td>Reason</td>
						<td>Time of request</td>
						<td>Action</td>
					</tr>
					<?php include('queries\exceptionRows.php') ?>
				</table>
				<p align="center">
					<input type="button" id="goHome" value="Go Home" onclick="home()" />
				</p>
				<div style="Display:none">
					<div id="fancyBoxDivReject">
						<input type="text" name="pidHolder" id="pidHolder" hidden />
						<br />
						Are you sure that you want to reject this record? <br />
						<br />
						<div style="text-align:center">
							<input type="button" id="fancyBoxButton" value="Yes" onClick="rejectQuery()" style="padding-left: 20px; padding-right: 20px; margin-right: 20px;" />
							<input type="button" id="fancyBoxButton" value="No" onClick="$.fancybox.close();" style="padding-left: 20px; padding-right: 20px; margin-left: 20px;" />
						</div>
					</div>
				</div>
				<div style="Display:none">
					<div id="fancyBoxDivAccept">
						<input type="text" name="pidHolder" id="pidHolderAccept" hidden />
						<br />
						<br />
						<b>Would you like to add some additional information?</b> <br />
						<textarea name="additionalInfo" title="Enter any additional information to assist in processing the request." class="design_textfield" id="additionalInfo" style="width: 668px; height: 78px;" rows="4" cols="73"></textarea>
						<br />
						<br />
						<br />
						<div style="text-align:center">
							<input type="button" id="fancyBoxButton" value="Submit" onClick="acceptQuery()" style="padding-left: 20px; padding-right: 20px; margin-right: 20px;" />
							<input type="button" id="fancyBoxButton" value="Cancel" onClick="$.fancybox.close();" style="padding-left: 20px; padding-right: 20px; margin-left: 20px;" />
						</div>
					</div>
				</div>
				<div style="Display:none">
					<div id="fancyBoxDiv">
						<br />
						<span id="fancyBoxText"></span> <br />
						<br />
						<div style="text-align:center">
							<input type="button" id="fancyBoxButton" value="Ok" onClick="$.fancybox.close();" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>