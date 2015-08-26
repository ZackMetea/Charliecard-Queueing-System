$(document).ready(function() {
	document.getElementById("sub").addEventListener("click", function(){
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