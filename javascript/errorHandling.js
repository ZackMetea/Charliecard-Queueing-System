$(document).ready(function(){
	var eSelect = document.getElementById('country');
	var changeVal = document.getElementById('state');
	eSelect.onchange = function(){
		if(eSelect.selectedIndex != 0){
			changeVal.value = 'NA';
			$('#zipRequired').attr("src",'images/whitespace.jpg');
		}else{
			$('#zipRequired').attr("src",'images/redstar%20trans.gif');
		}
	}
});
function tabToNext(pageElement, characterNumber, nextPageElement){
	var elementStringLength = document.getElementById(pageElement).value.length;//"#" + pageElement;
	if(elementStringLength == characterNumber){
		//var nextElementString = "#" + nextPageElement;
		document.getElementById(nextPageElement).focus();
	}
}
function checkCharCount(pageElement, characterNumber){
	var elementStringLength = document.getElementById(pageElement).value.length;//"#" + pageElement;
	if(elementStringLength >= characterNumber){
		//var nextElementString = "#" + nextPageElement;
		document.getElementById(pageElement).value = "";
	}
}