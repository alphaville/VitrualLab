// On load

function doget(){
    $.ajax({
        url: 'http://localhost/a.txt',
        type: 'GET',                            
        error: function() {
            alert('FAILURE');
        },
        success: function() {
            alert('SUCCESS')
            }
    }).done(function(data){
        alert(data);
    });
    
}

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
function checkNumeric(inputElement){
    var val = inputElement.value;
    if (val.length==0){
        document.getElementById("sb").disabled=true;
        inputElement.className='error';
    }else{
        if (isNumeric(val)==true){
            document.getElementById("sb").disabled=false;
            inputElement.className='normal';
        }else{
            document.getElementById("sb").disabled=true;
            inputElement.className='error';
        }
    }
}


function checkSign(inputElement,strict){
    var val = inputElement.value;
    if (val.length==0){
        document.getElementById("sb").disabled=true;
        inputElement.className='errortiny';		
    }else{
        var flag = false;
        if (strict==1)
        {
            flag = isNumeric(val)==true && val>0;
        }else if (strict==0)
        {
            flag = isNumeric(val)==true && val>=0;
        }else
        {
            flag = isNumeric(val);
        }
        if (flag){
            document.getElementById("sb").disabled=false;
            inputElement.className='tinyInput';
        }else{
            document.getElementById("sb").disabled=true;
            inputElement.className='errortiny';
        }
    }
}

function checkTi(inputElement){
    var val = inputElement.value;
    if (val.length==0){
        document.getElementById("sb").disabled=true;
        inputElement.className='error';
    }else{
        if (isNumeric(val)==true||val=='infty'){
            document.getElementById("sb").disabled=false;
            inputElement.className='normal';
        }else{
            document.getElementById("sb").disabled=true;
            inputElement.className='error';
        }
    }
}

// Check whether variable is numeric
function isNumeric(x) {
    return !isNaN(parseFloat(x)) && isFinite(x);
}


// Action Upon click on the checkbox openLoop
function openLoopAction(chkBox) {
    if (chkBox.checked){
        document.getElementById("flowcharthref").href="PIDS2.png";
        document.images.flowchart.src="PIDS2.png";
        document.getElementById("openLoopHint").innerHTML="<span class=\"hotspot\" onmouseover=\"tooltip.show(\'Uncheck this box to run simulations on the closed loop system (see figure)\');\" onmouseout=\"tooltip.hide();\">Open Loop</span>";
    }else{
        document.getElementById("flowcharthref").href="PIDS.png";
        document.getElementById("flowcharthref").href="PIDS.png";
        document.images.flowchart.src="PIDS.png";
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
    var eleSimPar = document.getElementById("simulationParameters");
    var stepEle = document.getElementById('step');
    var harmEle = document.getElementById('harmonic');
    if(eleBode.style.display != "none") {
        eleBode.style.display = "none";
        toggleText.innerHTML = "Show Advanced Options";
        stepEle.style.display="none";
        harmEle.style.display="none";
        eleSimPar.style.display="none";
    }else {
        eleBode.style.display = "inherit";
        toggleText.innerHTML = "Hide Advanced Options";
        stepEle.style.display="block";
        eleSimPar.style.display="block";
        signalParameters(document.getElementById("selectInputSignal"));
    }
}

function signalParameters(selector){
    var option = selector.options[selector.selectedIndex].value;
    var stepEle = document.getElementById('step');
    var harmEle = document.getElementById('harmonic');
    if(option=="1"){
        stepEle.style.display="block";
        harmEle.style.display="none";
    }else if (option=="2"){  
        harmEle.style.display="none";
        stepEle.style.display="none";
    }else if (option=="3"){
        harmEle.style.display="block";
        stepEle.style.display="none";
    }
}

function highlight(object){
    object.className="highlighted";
}

function dehighlight(object){
    object.className="navLink";
}

(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

!function(d,s,id){
    var js,fjs=d.getElementsByTagName(s)[0];
    if(!d.getElementById(id)){
        js=d.createElement(s);
        js.id=id;
        js.src="//platform.twitter.com/widgets.js";
        fjs.parentNode.insertBefore(js,fjs);
    }
}(document,"script","twitter-wjs");

function highlightButton(){
    var excl = document.getElementById("exclamation");
    excl.style.display="block";
}

function dehighlightButton(){
    var excl = document.getElementById("exclamation");
    excl.style.display="none";
}