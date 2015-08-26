//Function for editTable.php
function createFormFunction(tableRowName, pageName){
	//Put all input boxes into an array
	var rowObject = document.getElementById(tableRowName);
	var inputRowElements = rowObject.getElementsByTagName("input");
	//Try to lock record
	var tempValue = inputRowElements[0].value;
	var checkLocalReturn = checkLock(tempValue, pageName);
	if(checkLocalReturn == 1){
		//Success
		//Put all elements in hidden form then submit
		var form = document.createElement("form");
		form.setAttribute("method", "get");
		form.setAttribute("action", "frontReplace.html");
		for(i=0; i < inputRowElements.length; i++){
			var hiddenField = document.createElement("input");
			hiddenField.setAttribute("type", "hidden");
			hiddenField.setAttribute("name", inputRowElements[i].name);
			hiddenField.setAttribute("value", inputRowElements[i].value);					
			form.appendChild(hiddenField);
		}
		var hiddenField2 = document.createElement("input");
		hiddenField2.setAttribute("type", "hidden");
		hiddenField2.setAttribute("name", "pageName");
		hiddenField2.setAttribute("value", pageName);					
		form.appendChild(hiddenField2);
		document.body.appendChild(form);
		form.submit();
	}else if(checkLocalReturn == 2){
		//Launch Fancy Box caused its locked
		launchFancyBox("Record is locked and can't be edited.");
	}else{
		//Error something went wrong
		launchFancyBox("Error! Something went wrong.");
	}
}
//Function to check if the record is locked
function checkLock(pidNumber, pageName){
	var result;
	$.ajax({
		type: "POST",
		url: "queries/lockEdit"+pageName+".php",
		async: false,
		data: { 
			pidText: pidNumber
		}
	}).done(function(data) {
		console.log("What is data: " + data + "\n");
		//console.log("saved");
		if(data == 0){
			//Can't edit record
			console.log("Can't edit record\n");
			result = 2;
		}else if(data == 1){
			//Record locked for editing
			console.log("Record locked for editing\n");
			result = 1;
		}else{
			//Error
			console.log("Error!\n");
			result = -1;
		}
	});
	
	return result;
}
//Function for exceptions.php
function createFormFunctionExceptions(tableRowName){
	//Put all input boxes into an array
	var rowObject = document.getElementById(tableRowName);
	var inputRowElements = rowObject.getElementsByTagName("input");
	//Try to lock record
	var tempValue = inputRowElements[0].value;
	var checkLocalReturn = checkLockExceptions(tempValue);
	if(checkLocalReturn == 1){
		//Success
		//Put all elements in hidden form then submit
		var form = document.createElement("form");
		form.setAttribute("method", "get");
		form.setAttribute("action", "frontReplace.html");
		for(i=0; i < inputRowElements.length; i++){
			var hiddenField = document.createElement("input");
			hiddenField.setAttribute("type", "hidden");
			hiddenField.setAttribute("name", inputRowElements[i].name);
			hiddenField.setAttribute("value", inputRowElements[i].value);					
			form.appendChild(hiddenField);
		}
		document.body.appendChild(form);
		form.submit();
	}else if(checkLocalReturn == 2){
		//Launch Fancy Box caused its locked
		launchFancyBox("Record is locked and can't be edited.");
	}else{
		//Error something went wrong
		launchFancyBox("Error! Something went wrong.");
	}
}
function checkLockExceptions(pidNumber){
	var result;
	$.ajax({
		type: "POST",
		url: "queries/lockEditExceptions.php",
		async: false,
		data: { 
			pidText: pidNumber
		}
	}).done(function(data) {
		console.log("What is data: " + data + "\n");
		if(data == 1){
			result = 1;
		}else if(data == 0){
			result = 2;
		}else{
			result = -1;
		}
	});
	console.log(result);
	return result;
}
function launchFancyBox(message){
	document.getElementById("fancyBoxText").textContent = message;
	$.fancybox({
		'href': "#fancyBoxDiv",
		'hideOnContentClick': true, 
		'modal': true
	});
}