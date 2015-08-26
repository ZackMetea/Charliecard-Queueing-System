$(document).ready(function(){
	$.post("queries/customerInfoTable.php", function(data) {
		var response = $.parseJSON(data);
		$('#P_Id').val(response.Pid);
		$('#cardType').text(response.passtype);
		$('#requestType').text(response.rtype);
		$('#requestDate').text(response.timeNew);
		$('#firstName').text(response.fname);
		$('#middleInitial').text(response.middleInitial);
		$('#lastName').text(response.lname);
		$('#birthDate').text(response.bday);
		$('#addressOne').text(response.addone);
		$('#addressTwo').text(response.addtwo);
		$('#city').text(response.city);
		$('#state').text(response.state);
		$('#zip').text(response.zip);
		$('#country').text(response.country);
		$('#phoneNumber').text(response.phone);
		$('#email').text(response.email);
		if(response.tvalue==0){
			$('#transferVal').text("No");
		}else if(response.tvalue==1){
			$('#transferVal').text("Yes");
		}else{
			$('#transferVal').text("null");
		}
		if(response.ispu==0){
			$('#storePickUp').text("No");
		}else if(response.ispu==1){
			$('#storePickUp').text("Yes");
		}else{
			$('#storePickUp').text("null");
		}
		$('#photoPath').attr("src","images/customers/" +response.ppath);
		$('#lock').val(response.lock);
		$('#additionalInfo').text(response.additionalInfo);
		$('#expirationDate').text(response.expDate);
	});
	$("#newTransaction").hide();
	$("#newTransactionException").hide();
	(document).getElementById("completeTransaction").addEventListener("click", function() {
		console.log(document.getElementById("P_Id").value);
		var transValue = document.getElementById("dollars").value + "." + document.getElementById("cents").value;
		var combinedAddInfo = document.getElementById("additionalInfo").innerHTML;
		if(combinedAddInfo == ""){
			if(document.getElementById("additionalInfoBack").value != ""){
				combinedAddInfo = document.getElementById("additionalInfoBack").value;
			}else{
				combinedAddInfo = "";
			}
		}else{
			if(document.getElementById("additionalInfoBack").value != ""){
				combinedAddInfo = combinedAddInfo + " " + document.getElementById("additionalInfoBack").value;
			}
		}
		console.log(transValue);
		console.log(combinedAddInfo);
		$.ajax({
			type: "POST",
			url: "queries/recordCompleted.php",
			data: {
				pidText: document.getElementById("P_Id").value,
				processedBy: document.getElementById("processedBy").value,
				cardSerial: document.getElementById("cardSerial").value,
				expiration: "20" + document.getElementById("expiration2").value + "/" + document.getElementById("expiration1").value + "/01",
				updateAdd: document.getElementById("changeAddress").value,
				monthlyPassTransfer: document.getElementById("transferPass").value,
				transferValue: transValue,
				additionalInfo: combinedAddInfo
			}
		}).done(function(msg) {
			$("#cantProduceCard").hide();
			$("#completeTransaction").hide();
			$("#newTransaction").show();
			$("#unlockTheRecord").val("completed");
		});
	});
	(document).getElementById("newTransaction").addEventListener("click", function() {
		window.location.reload(true);	
	});
	(document).getElementById("newTransactionException").addEventListener("click", function() {
		window.location.reload(true);	
	});
	(document).getElementById("cantProduceCardAction").addEventListener("click", function() {
		$.fancybox.close();
		$.ajax({
		  type: "POST",
		  url: "queries/markException.php",
		  data: {
		  pidText: document.getElementById("P_Id").value,
		  exception: document.getElementById("exceptionInformation").value
		  }
		}).done(function(msg) {
			$("#completeTransaction").hide();
			$("#cantProduceCard").hide();
			$("#newTransactionException").show();
			$("#unlockTheRecord").val("completed");
		});
	});
	(document).getElementById("closeShift").addEventListener("click", function() {
		if(document.getElementById("unlockTheRecord").value != "completed"){
			$.ajax({
			  type: "POST",
			  url: "queries/unlockRecord.php",
			  data: {pidText: document.getElementById("P_Id").value}
			}).done(function(msg) {
				//window.location.reload();
				window.location.href = 'home.html';
			});
		}else{
			window.location.href = 'home.html';
		}
	});
	$('#loaderFrame').load(function(){
		var w = (this.contentWindow || this.contentDocument.defaultView);
		var doc = w.document;
		doc.getElementById("cardNumber").textContent = "5-" + document.getElementById("cardSerial").value;
		var today = new Date();
		doc.getElementById("orderDate").textContent = (today.getMonth()+1).toString() + "/" + today.getDate().toString() + "/" + today.getFullYear().toString();
		doc.getElementById("fullName").textContent = document.getElementById("firstName").textContent + " " + document.getElementById("lastName").textContent + " " + document.getElementById("middleInitial").textContent;
		doc.getElementById("addressOne").textContent = document.getElementById("addressOne").textContent + " " + document.getElementById("addressTwo").textContent;
		doc.getElementById("addressTwo").textContent = document.getElementById("city").textContent + ", " + document.getElementById("state").textContent + " " + document.getElementById("zip").textContent;
		doc.getElementById("passType").textContent = document.getElementById("cardType").textContent;
		doc.getElementById("monthlyTransfer").textContent = document.getElementById("transferPass").value;
		var transferValuePrint = "$";// + document.getElementById("dollars").value + "." + document.getElementById("cents").value;
		if(document.getElementById("dollars").value == ""){
			transferValuePrint = transferValuePrint + "0";
		}else{
			transferValuePrint = transferValuePrint + document.getElementById("dollars").value;
		}
		if(document.getElementById("cents").value == ""){
			transferValuePrint = transferValuePrint + ".00";
		}else{
			transferValuePrint = transferValuePrint + "." + document.getElementById("cents").value;
		}
		doc.getElementById("transferValue").textContent = transferValuePrint;
		w.print();
	});
	$('#printerButton').click(function(){
		$('#loaderFrame').attr('src', 'print/customerPackingSlip.htm');
	});
	$("a#inlineBackOffice").fancybox({
		'hideOnContentClick': true
	});
});