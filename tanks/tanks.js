function setLevel(ele,level){
var H = parseFloat(getStyle(ele,"height"));
diff=level-H;
var level1 = document.getElementById(ele);
level1.style.height=level+"px";
var MAR = parseFloat(getStyle(ele,"margin-top"));
level1.style.marginTop=MAR-diff+"px";
}

function changeLevel(ele,diff){
var H = parseFloat(getStyle(ele,"height"));
H = H + diff;
var level1 = document.getElementById(ele);
level1.style.height=H+"px";
var MAR = parseFloat(getStyle(ele,"margin-top"));
level1.style.marginTop=MAR-diff+"px";
}

// Method from http://www.quirksmode.org/dom/getstyles.html
function getStyle(el,styleProp)
{
	var x = document.getElementById(el);
	if (x.currentStyle)
		var y = x.currentStyle[styleProp];
	else if (window.getComputedStyle)
		var y = document.defaultView.getComputedStyle(x,"").getPropertyValue(styleProp);
	return y;
}