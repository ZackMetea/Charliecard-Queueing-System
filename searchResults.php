<html>
	<head>
		<link rel="stylesheet" type="text/css" href="styles/stylesZack.css" />
		<script src="javascript/editRecordFunctions.js"></script>
		<script src="javascript/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="javascript/fancyBox/jquery.fancybox.pack.js"></script>
		<link rel="stylesheet" href="javascript/fancyBox/jquery.fancybox.css" type="text/css" media="screen" />
		<script src="javascript/navigationFunctions.js"></script>
	</head>
	<body id="main_page">
		<div id="main_div">
			<div id="header">
				<div id="logopad">
					<img id="mbta_intranet_logo" src="images/mbta-logo-white.png" alt="mbta intranet logo" style="height:50px; width:50px">
				</div>
				<div id="headertext">
					<h1>Search and Edit Page</h1>
				</div>
			</div>
			<div id="searchbar_div">
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
			</div>
			<div id="content_div">
				<?php include("queries/searchResultsQuery.php"); ?>
			</div>
		</div>
		<p align="center">
			<input type="button" value="Go Home" onClick="home()" />
		</p>
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
	</body>
</html>
