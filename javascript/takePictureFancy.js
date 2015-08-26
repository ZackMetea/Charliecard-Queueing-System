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
	// reset - clear - to Capture New Photo
	document.getElementById("reset").addEventListener("click", function() {
		$("#video").fadeIn("slow");
		$("#canvas").fadeOut("slow");
		$("#snap").show();
		$("#reset").hide();
		$("#closeBox").hide();
	});
	document.getElementById("closeBox").addEventListener("click", function() {
		$.fancybox.close();
		document.getElementById("sub").disabled = false;
	});
	
	document.getElementById("sub").addEventListener("click", function(){
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
		if(a=="TAP"){
			b=document.getElementById("expDate1").value;
			c=document.getElementById("expDate2").value;
		}else if(a=="The Ride"){
			c=(today.getFullYear()+5).toString();
			b=(today.getMonth()).toString();
		}else if(a=="Blind"){
			c=(today.getFullYear()+5).toString();
			b=(today.getMonth()).toString();
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
				expDate2: c
				
			}
		}).done(function(msg) {
		  console.log("customer saved");
		  window.location.reload(true);
		});
	});
});