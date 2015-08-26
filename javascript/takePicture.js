// Put event listeners into place
$(document).ready(function() {
	// Grab elements, create settings, etc.
	var canvas = document.getElementById("canvas"),
		context = canvas.getContext("2d"),
		video = document.getElementById("video"),
		videoObj = { "video": true },
		image_format= "jpeg",
		jpeg_quality= 85,
		errBack = function(error) {
			console.log("Video capture error: ", error.code); 
		};
		
	$("button#start_snap").click(function(){
		// Put video listeners into place
		if(navigator.getUserMedia) { // Standard
			navigator.getUserMedia(videoObj, function(stream) {
				video.src = stream;
				video.play();
				$("#snap").show();
			}, errBack);
		} else if(navigator.webkitGetUserMedia) { // WebKit-prefixed
			navigator.webkitGetUserMedia(videoObj, function(stream){
				video.src = window.webkitURL.createObjectURL(stream);
				video.play();
				$("#snap").show();
			}, errBack);
		} else if(navigator.mozGetUserMedia) { // moz-prefixed
			navigator.mozGetUserMedia(videoObj, function(stream){
				video.src = window.URL.createObjectURL(stream);
				video.play();
				$("#snap").show();
			}, errBack);
		}
		$("#snap").show();
		$("#reset").hide();
		$("#closeBox").hide();
	});
	// video.play();       these 2 lines must be repeated above 3 times
	// $("#snap").show();  rather than here once, to keep "capture" hidden
	//                     until after the webcam has been activated.  
	// Get-Save Snapshot - image 
	document.getElementById("snap").addEventListener("click", function() {
		context.drawImage(video, 0, 0, 640, 480);
		// the fade only works on firefox?
		$("#video").fadeOut("slow");
		$("#canvas").fadeIn("slow");
		$("#snap").hide();
		$("#reset").show();
		$("#closeBox").show();
	});
	document.getElementById("closeBox").addEventListener("click", function() {
		$.fancybox.close();
		document.getElementById("sub").disabled = false;
	});
	// reset - clear - to Capture New Photo
	document.getElementById("reset").addEventListener("click", function() {
		$("#video").fadeIn("slow");
		$("#canvas").fadeOut("slow");
		$("#snap").show();
		$("#reset").hide();
		$("#closeBox").hide();
	});
	// Upload image to sever 
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
	document.getElementById("sub").addEventListener("click", function(){
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
				
				
				
				
				
				var dataUrl = canvas.toDataURL("image/jpeg", 0.85);
				//$("#uploading").show();
				var today = new Date();
				var monthString = today.getMonth()+1;
				if(monthString < 10){ monthString = '0' + monthString; }
				var newday=today.getDate();
				if(newday < 10){ newday = '0' + newday; }
				var todayString = today.getFullYear().toString() + "-" + monthString + "-" + newday.toString();
				var photoPathString = todayString + "/" + document.getElementById("firstName").value + "-" + document.getElementById("lastName").value + "-" + document.getElementById("birthDate1").value + document.getElementById("birthDate2").value + document.getElementById("birthDate3").value + ".jpg";
				document.getElementById("photoPath").value = photoPathString;
				
				
				console.log(photoPathString.toString());
				//document.getElementById("photoPath").value = "images/customers/".concat(document.getElementById("birthDate1").value).concat(document.getElementById("birthDate2").value).concat(document.getElementById("birthDate3").value).concat("-").concat(document.getElementById("firstName").value).concat("-").concat(document.getElementById("lastName").value).concat(".jpg");
				$.ajax({
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
				});
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
				$.ajax({
					type: "POST",
					url: "queries/responsePost.php",
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
						photoPath: document.getElementById("photoPath").value,
						additionalInfo: document.getElementById("additionalInfo").value,
						middleInitial: document.getElementById("middleInitial").value,
						expDate1: b,
						expDate2: c,
						expDateday: d
						
					}
				}).done(function(msg) {
				  console.log("customer saved");
				  window.location.reload(true);
				});
			
		
		}
	});
	
	function isNumeric(n){
	return !isNaN(parseFloat(n)) && isFinite(n);
}
});
