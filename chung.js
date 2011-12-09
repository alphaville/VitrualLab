// On load
function loadMe(){
if (document.getElementsByClassName == undefined) {
	document.getElementsByClassName = function(className)
	{
		var hasClassName = new RegExp("(?:^|\\s)" + className + "(?:$|\\s)");
		var allElements = document.getElementsByTagName("*");
		var results = [];

		var element;
		for (var i = 0; (element = allElements[i]) != null; i++) {
			var elementClass = element.className;
			if (elementClass && elementClass.indexOf(className) != -1 && hasClassName.test(elementClass))
				results.push(element);
		}

		return results;
	}
}
}
// Check whether variable is OK
function check(val){
	if (val.length==0){
		document.getElementById("sb").disabled=true;
	}else{
		if (isNumeric(val)==true){
			document.getElementById("sb").disabled=false;
		}else{document.getElementById("sb").disabled=true;}		
	}
}


// Check whether variable is numeric
function isNumeric(x) {
  return !isNaN(parseFloat(x)) && isFinite(x);
}


// Action Upon click on the checkbox openLoop
function openLoopAction(chkBox) {
  if (chkBox.checked){
    document.images.flowchart.src="PIDS2.jpg";    
    document.getElementById("openLoopHint").innerHTML="<span class=\"hotspot\" onmouseover=\"tooltip.show(\'Uncheck this box to run simulations on the closed loop system (see figure)\');\" onmouseout=\"tooltip.hide();\">Open Loop</span>";
  }else{
    document.images.flowchart.src="PIDS.jpg";
document.getElementById("openLoopHint").innerHTML="<span class=\"hotspot\" onmouseover=\"tooltip.show(\'Check this box to run simulations on the open loop system (see figure)\');\" onmouseout=\"tooltip.hide();\">Open Loop</span>";
    
  }
}


// NEW POPUP
function newPopup(url) {
	popupWindow = window.open(
		url,'popUpWindow','height=250,width=500,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no');
}

function showAdvanced(){
 var toggleText = document.getElementById("advancedOptionsText");
 var eleBode = document.getElementById("advOptions");
 var stepEle = document.getElementById('step');
 var harmEle = document.getElementById('harmonic');
 if(eleBode.style.display != "none") {
  eleBode.style.display = "none";
  toggleText.innerHTML = "Show Advanced Options";
  stepEle.style.display="none";
  harmEle.style.display="none";
 }else {
  eleBode.style.display = "inherit";
  toggleText.innerHTML = "Hide Advanced Options";
  stepEle.style.display="block";
 }   
}

function signalParameters(selector){
 var option = selector.selectedIndex;
 var stepEle = document.getElementById('step');
 var harmEle = document.getElementById('harmonic');
 if(option==0){
  stepEle.style.display="block";
  harmEle.style.display="none";
 }else if (option==1){  
  harmEle.style.display="none";
  stepEle.style.display="none";
 }else if (option==2){
  harmEle.style.display="block";
  stepEle.style.display="none";
 }
}