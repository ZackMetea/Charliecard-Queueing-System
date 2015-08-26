function getValuesFromRequest(){
	var c = new Date(urldecode(getUrlVars()["birthDate1"]));
	var d = new Date(urldecode(getUrlVars()["expDate1"]));
	var phone = new String(urldecode(getUrlVars()["phone1"]));
	var birthDateFull = urldecode(getUrlVars()["birthDate1"]);
	birthDateYear = birthDateFull.substring(0,4);
	birthDateMonth = birthDateFull.substring(5,7);
	birthDateDay = birthDateFull.substring(8,10);
	var expDateFull = urldecode(getUrlVars()["expDate1"]);
	expDateYear = expDateFull.substring(0,4);
	expDateMonth = expDateFull.substring(5,7);
	expDateDay = expDateFull.substring(8,10);
	var p1 =phone.substring(0, 3);
	var p2 =phone.substring(3, 6);
	var p3 =phone.substring(6, 10);
	if(urldecode(getUrlVars()["pickupType"])=="Yes"){
	document.getElementById("pickupType").selectedIndex = 2;
	}else{
	document.getElementById("pickupType").selectedIndex = 1;
	}
	var set="Yes";
	var other= urldecode(getUrlVars()["transferValue"]); 
	if(urldecode(getUrlVars()["transferValue"])=="0"){

	document.getElementById("transferValue").value="No";
	document.getElementById("transferValue").selectedIndex = 0;
	}else{
	document.getElementById("transferValue").value="Yes";
	document.getElementById("transferValue").selectedIndex = 1;
	}
	document.getElementById("P_Id").value  						=urldecode(getUrlVars()["P_Id"]);
	document.getElementById("firstName").value  				=urldecode(getUrlVars()["firstName"]);
	document.getElementById("lastName").value  					=urldecode(getUrlVars()["lastName"]);
	document.getElementById("lastName").value  					=urldecode(getUrlVars()["lastName"]);
	document.getElementById("birthDate1").value  				=birthDateMonth; //c.getMonth()+1;
	document.getElementById("birthDate2").value 				=birthDateDay; //c.getDate()+1;
	document.getElementById("birthDate3").value 				=birthDateYear; //c.getFullYear();
	document.getElementById("phone1").value  					=p1;
	document.getElementById("phone2").value 					=p2;
	document.getElementById("phone3").value 					=p3;
	document.getElementById("email").value  					=urldecode(getUrlVars()["email"]);
	document.getElementById("address1").value  					=urldecode(getUrlVars()["address1name"]);
	document.getElementById("address2").value  					=urldecode(getUrlVars()["address2name"]);
	document.getElementById("city").value  						=urldecode(getUrlVars()["city"]);
	document.getElementById("state").value  					=urldecode(getUrlVars()["state"]);
	document.getElementById("zip").value  						=urldecode(getUrlVars()["zip"]);
	document.getElementById("country").value  					=urldecode(getUrlVars()["country"]);
	document.getElementById("requestType").value  				=urldecode(getUrlVars()["requestType"]);
	document.getElementById("passType").value  					=urldecode(getUrlVars()["passType"]);
	document.getElementById("pickupType").value  				=urldecode(getUrlVars()["pickupType"]);
	//document.getElementById("transferValue").value  			=set;
	//document.getElementById("photoPath").value  				=urldecode(getUrlVars()["photoPath"]);
	document.getElementById("additionalInfo").value		  		=urldecode(getUrlVars()["additionalInfo"]);
	document.getElementById("requestDate").value		  		=urldecode(getUrlVars()["timeNew"]);
	document.getElementById("middleInitial").value				=urldecode(getUrlVars()["middleInitial"]);
	document.getElementById("expDate1").value  					=expDateMonth; //d.getMonth()+1;
	document.getElementById("expDateday").value 				=expDateDay; //d.getDate()+1;
	document.getElementById("expDate2").value 					=expDateYear; //d.getFullYear();
}
function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
	
    return vars;
}
function urldecode(str) {
 return decodeURIComponent((str + '')
    .replace(/%(?![\da-f]{2})/gi, function() {
      // PHP tolerates poorly formed escape sequences
      return '%25';
    })
    .replace(/\+/g, '%20'));
}
$(function(){
	$("#header").load("theHeader.html");
});
function goBackToPage(){
	var pageReturn = urldecode(getUrlVars()["pageName"]);
	if(pageReturn == "Exceptions"){
		exceptions();
	}
	if(pageReturn == "Record"){
		editTable();
	}
}
function statusNumberFunction(){
	var pageReturn = urldecode(getUrlVars()["pageName"]);
	if(pageReturn == "Exceptions"){
		return 4;
	}
	if(pageReturn == "Record"){
		return 1;
	}
}
function cancelButton(){
	$.ajax({
		type: "POST",
		url: "queries/unlockedit"+urldecode(getUrlVars()["pageName"])+".php",
		async: false,
		data: { 
			P_Id: document.getElementById("P_Id").value
		}
	}).done(function(msg) {
	  console.log("cancelled");
	  goBackToPage();	  
	});
}
function homeUnlock(){
	$.ajax({
		type: "POST",
		url: "queries/unlockedit"+urldecode(getUrlVars()["pageName"])+".php",
		async: false,
		data: { 
			P_Id: document.getElementById("P_Id").value
		}
	}).done(function(msg) {
	  console.log("cancelled go home");
	  home();
	});
}
$(document).ready(function() {
	getValuesFromRequest();
	$("a#inline").fancybox({
		'hideOnContentClick': true,
		'modal': true
	});
	var aa= document.getElementById("P_Id").value  ;
	var cc=true;
	window.onbeforeunload = function(){
		//if (sessionStorage.getItem("is_reloaded")) alert ('reload');
		sessionStorage.setItem("is_reloaded",true);
		if(cc){
			$.ajax({
			  type: "POST",
			  url: "queries/unlockedit"+urldecode(getUrlVars()["pageName"])+".php",
			  async: false,
			  data: { 
				 
				 P_Id:   aa
				}
			}).done(function(msg) {
			  console.log("saved");
			});
		}
	};
	var rSelect = document.getElementById('requestType');
	var TchangeVal = document.getElementById('transferValue');
	$('#transferValue').hide();
	$('#ttext').hide();
	if(rSelect.selectedIndex == 0){
		$('#transferValue').hide();
		$('#ttext').hide();
		if(TchangeVal.selectedIndex == 0){
			TchangeVal.value = 'No';
		}
		else{
			TchangeVal.value = 'Yes';
		}
	}else{
		$('#transferValue').show();
		$('#ttext').show();
		if(TchangeVal.selectedIndex == 0){
			TchangeVal.value = 'No';
		}
		else{
			TchangeVal.value = 'Yes';
		}
	}
	rSelect.onchange = function(){
		if(rSelect.selectedIndex == 0){
			$('#transferValue').hide();
			$('#ttext').hide();
			if(TchangeVal.selectedIndex == 0){
				TchangeVal.value = 'No';
			}
			else{
				TchangeVal.value = 'Yes';
			}
		}else{
			$('#transferValue').show();
			$('#ttext').show();
			if(TchangeVal.selectedIndex == 0){
				TchangeVal.value = 'No';
				}
			else{
				TchangeVal.value = 'Yes';
			}
		}
	}
	var ctSelect = document.getElementById('passType');
	$('#expdate').hide();
	$('#expdatetd').hide();
	if(ctSelect.selectedIndex != 1){
		$('#expdate').hide();
		$('#expdatetd').hide();
	}else{
		$('#expdate').show();
		$('#expdatetd').show();
	}
	ctSelect.onchange = function(){
		if(ctSelect.selectedIndex != 1){
			$('#expdate').hide();
			$('#expdatetd').hide();
		}else{
			$('#expdate').show();
			$('#expdatetd').show();
		}
	}
	$("#fnamereq").hide();
	$("#lnamereq").hide();
	$("#bdayreq").hide();
	$("#bdaynumreq").hide();
	
	$("#phonereq").hide();
	$("#phonenumreq").hide();
	$("#addressreq").hide();
	$("#cityreq").hide();
	$("#expdatereq").hide();
		$("#expdatenumreq").hide();
		$("#zipreq").hide();
	document.getElementById("update").addEventListener("click", function(){
		var fname=document.getElementById("firstName").value;
		$("#fnamereq").hide();
		$("#lnamereq").hide();
		$("#bdayreq").hide();
		$("#bdaynumreq").hide();
		$("#phonereq").hide();
		$("#phonenumreq").hide();
		$("#addressreq").hide();
		$("#cityreq").hide();
		$("#expdatereq").hide();
		$("#expdatenumreq").hide();
		$("#zipreq").hide();
		var daysinmonth= new Date(document.getElementById("birthDate3").value, document.getElementById("birthDate1").value,0).getDate();
		if(document.getElementById("firstName").value===""){$("#fnamereq").show();}
		if(document.getElementById("lastName").value===""){	$("#lnamereq").show();}
		if(document.getElementById("zip").value==="" || !isNumeric(document.getElementById("zip").value)){	$("#zipreq").show();}
		if(document.getElementById("birthDate1").value==="" || document.getElementById("birthDate2").value==="" || document.getElementById("birthDate3").value===""){	$("#bdayreq").show();}
		else if(
		document.getElementById("birthDate1").value<1 || 
		document.getElementById("birthDate1").value>12 || 
		document.getElementById("birthDate2").value<1 ||  
		document.getElementById("birthDate2").value>daysinmonth || 
		document.getElementById("birthDate3").value>new Date().getFullYear() ||
		!isNumeric(document.getElementById("birthDate1").value) ||
		!isNumeric(document.getElementById("birthDate2").value) ||
		!isNumeric(document.getElementById("birthDate3").value) 
		){	$("#bdaynumreq").show();}
		
		if(document.getElementById("passType").value=="TAP"){
			var daysinmonthexp= new Date(document.getElementById("expDate2").value, document.getElementById("expDate1").value,0).getDate();
			if(document.getElementById("expDate1").value==="" || document.getElementById("expDateday").value==="" || document.getElementById("expDate2").value===""){	$("#expdatereq").show();}
			else if(
			document.getElementById("expDate1").value<1 || 
			document.getElementById("expDate1").value>12 || 
			document.getElementById("expDateday").value<1 ||  
			document.getElementById("expDateday").value>daysinmonthexp || 
			document.getElementById("expDate2").value<new Date().getFullYear() ||
			!isNumeric(document.getElementById("expDate1").value) ||
			!isNumeric(document.getElementById("expDateday").value) ||
			!isNumeric(document.getElementById("expDate2").value) 
			){	$("#expdatenumreq").show();}
	}
		
		
		
		if(document.getElementById("phone1").value==="" || document.getElementById("phone2").value==="" || document.getElementById("phone3").value===""){	$("#phonereq").show();}
		else if(!isNumeric(document.getElementById("phone1").value) || !isNumeric(document.getElementById("phone2").value) || !isNumeric(document.getElementById("phone3").value)){	$("#phonenumreq").show();}
		if(document.getElementById("address1").value===""){	$("#addressreq").show();}
		if(document.getElementById("city").value===""){	$("#cityreq").show();}
		
		
		
		if(document.getElementById("firstName").value===""){document.getElementById("firstName").focus();			
		}else if(document.getElementById("lastName").value===""){document.getElementById("lastName").focus();	
		}else if(
		document.getElementById("birthDate1").value==="" || 
		document.getElementById("birthDate2").value==="" || 
		document.getElementById("birthDate3").value==="" ||
		document.getElementById("birthDate1").value<1 || 
		document.getElementById("birthDate1").value>12 || 
		document.getElementById("birthDate2").value<1 ||  
		document.getElementById("birthDate2").value>daysinmonth || 
		document.getElementById("birthDate3").value>new Date().getFullYear() ||
		!isNumeric(document.getElementById("birthDate1").value) ||
		!isNumeric(document.getElementById("birthDate2").value) ||
		!isNumeric(document.getElementById("birthDate3").value) 
		){document.getElementById("birthDate1").focus();			
		}else if(
		document.getElementById("phone1").value==="" || 
		document.getElementById("phone2").value==="" || 
		document.getElementById("phone3").value==="" ||
		!isNumeric(document.getElementById("phone1").value) ||
		!isNumeric(document.getElementById("phone2").value) ||
		!isNumeric(document.getElementById("phone3").value) 
		){document.getElementById("phone1").focus();
		}else if(document.getElementById("address1").value===""){document.getElementById("address1").focus();
		}else if(document.getElementById("city").value===""){document.getElementById("city").focus();
		}else if(document.getElementById("zip").value==="" || !isNumeric(document.getElementById("zip").value)){	document.getElementById("zip").focus()
		}else if(
		(document.getElementById("passType").value=="TAP") &&	
		(document.getElementById("expDate1").value==="" || 
		document.getElementById("expDateday").value==="" || 
		document.getElementById("expDate2").value==="" ||
		document.getElementById("expDate1").value<1 || 
		document.getElementById("expDate1").value>12 || 
		document.getElementById("expDateday").value<1 ||  
		document.getElementById("expDateday").value>new Date(document.getElementById("expDate2").value, document.getElementById("expDate1").value,0).getDate() || 
		document.getElementById("expDate2").value<new Date().getFullYear() ||
		!isNumeric(document.getElementById("expDate1").value) ||
		!isNumeric(document.getElementById("expDateday").value) ||
		!isNumeric(document.getElementById("expDate2").value) 
		)){	document.getElementById("expDate1").focus();
		}else{
				//var dataUrl = canvas.toDataURL("image/jpeg", 0.85);
				//$("#uploading").show();
				var today = new Date();
				var monthString = today.getMonth()+1;
				if(monthString < 10){ monthString = '0' + monthString; }
				var newday=today.getDate();
				if(newday < 10){ newday = '0' + newday; }
				var todayString = today.getFullYear().toString() + "-" + monthString + "-" + newday.toString();
				var photoPathString = todayString + "/" + document.getElementById("firstName").value + "-" + document.getElementById("lastName").value + "-" + document.getElementById("birthDate1").value + document.getElementById("birthDate2").value + document.getElementById("birthDate3").value + ".jpg";
				//document.getElementById("photoPath").value = photoPathString;
				//console.log(photoPathString.toString());
				//document.getElementById("photoPath").value = "images/customers/".concat(document.getElementById("birthDate1").value).concat(document.getElementById("birthDate2").value).concat(document.getElementById("birthDate3").value).concat("-").concat(document.getElementById("firstName").value).concat("-").concat(document.getElementById("lastName").value).concat(".jpg");
				/*$.ajax({
				  type: "POST",
				  url: "queries/html5-webcam-save.php",
				  data: { 
					 imgBase64: dataUrl,
					 firstname: document.getElementById("firstName").value,        
					 lastname: document.getElementById("lastName").value,
					 phone: document.getElementById("phone1").value.concat(document.getElementById("phone2").value).concat(document.getElementById("phone3").value),
					 bday: document.getElementById("birthDate1").value.concat(document.getElementById("birthDate2").value).concat(document.getElementById("birthDate3").value)
				  }
				}).done(function(msg) {
				  console.log("saved");
				  //$("#uploading").hide();
				  //$("#uploaded").show();
				});*/
				var a = document.getElementById("passType").value;
				var b;
				var c;
				var today = new Date();
				c=(today.getFullYear()+8).toString();
				b=(today.getMonth()).toString();
				d=(today.getDay()).toString();
				if(a=="TAP"){
					b=document.getElementById("expDate1").value;
					c=document.getElementById("expDate2").value;
					d=document.getElementById("expDateday").value;
				}else if(a=="The Ride"){
					c=(today.getFullYear()+5).toString();
					b=(today.getMonth()).toString();
					d=(today.getDay()).toString();
				}else if(a=="Blind"){
					c=(today.getFullYear()+5).toString();
					b=(today.getMonth()).toString();
					d=(today.getDay()).toString();
				}
				var statusNumber = statusNumberFunction();
				$.ajax({
					type: "POST",
					url: "queries/responsePostReplace.php",
					async: false,
					data: {
						firstName: document.getElementById("firstName").value,
						lastName: document.getElementById("lastName").value,
						birthDate1: document.getElementById("birthDate1").value,
						birthDate2: document.getElementById("birthDate2").value,
						birthDate3: document.getElementById("birthDate3").value,
						phone1: document.getElementById("phone1").value,
						phone2: document.getElementById("phone2").value,
						phone3: document.getElementById("phone3").value,
						email: document.getElementById("email").value,
						address1name: document.getElementById("address1").value,
						address2name: document.getElementById("address2").value,
						cityname: document.getElementById("city").value,
						state: document.getElementById("state").value,
						zip: document.getElementById("zip").value,
						country: document.getElementById("country").value,
						requestType: document.getElementById("requestType").value,
						passType: document.getElementById("passType").value,
						pickupType: document.getElementById("pickupType").value,
						transferValue: document.getElementById("transferValue").value,
						additionalInfo: document.getElementById("additionalInfo").value,
						middleInitial: document.getElementById("middleInitial").value,
						expDate1: b,
						expDate2: c,
						expDateday: d,
						P_Id: document.getElementById("P_Id").value
					}
				}).done(function(msg) {
				  console.log("customer saved");
				  goBackToPage();
				});
		}
	});
	
	function isNumeric(n){
	return !isNaN(parseFloat(n)) && isFinite(n);
}
});
