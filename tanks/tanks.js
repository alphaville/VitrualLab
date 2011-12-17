var lev1;
var lev2;
var r1, r2;
var marto1=186, marto2=186;
function randomizeInitialLevels(){
 lev1 = (Math.ceil(Math.random()*53)+20);
 lev2 = (Math.ceil(Math.random()*53)+20);
 r1 = 2+Math.round(Math.random()*790)/100;
 r2 = 2+Math.round(Math.random()*860)/100;
 a1 = Math.round(Math.random()*600)/100;
 a2 = Math.round(Math.random()*550)/100; 
 setLevel('level1',lev1);
 setLevel('level2',lev2);
 document.getElementById('l1msg').innerHTML=(lev1/10).toFixed(1)+" m";
 document.getElementById('l2msg').innerHTML=(lev2/10).toFixed(1)+" m";
 document.getElementById('r1msg').innerHTML="R<sub>1</sub>="+r1.toFixed(2)+" m s kg<sup>-1</sup>";
 document.getElementById('r2msg').innerHTML="R<sub>2</sub>="+r2.toFixed(2)+" m s kg<sup>-1</sup>";
 document.getElementById('a1msg').innerHTML="A<sub>1</sub>="+a1.toFixed(1)+" m<sup>2</sup>";
 document.getElementById('a2msg').innerHTML="A<sub>2</sub>="+a2.toFixed(1)+" m<sup>2</sup>";
}


function doMove(){
 document.getElementById('l2msg').innerHTML=(lev2/10).toFixed(1)+" m";
 changeLevel('level2',1)
 if (lev2<100){
 setTimeout("doMove();",20);}
}

function setLevel(ele,level){
var H = parseFloat(getStyle(ele,"height"));
diff=level-H;
var level1 = document.getElementById(ele);
level1.style.height=level+"px";
if ('level1'==ele){
 marto1=marto1-parseFloat(diff);
 level1.style.marginTop=marto1+"px";
}else{
 marto2=marto2-parseFloat(diff);
 level1.style.marginTop=marto2+"px";
}

}

function changeLevel(ele,diff){
var H = parseFloat(getStyle(ele,"height"));
H = H + diff;
var level1 = document.getElementById(ele);
level1.style.height=H+"px";
lev2=H;
var MAR = parseFloat(getStyle(ele,"margin-top"));
if ('level1'==ele){
 marto1=marto1-parseFloat(diff);
 level1.style.marginTop=marto1+"px";
}else{
 marto2=marto2-parseFloat(diff);
 level1.style.marginTop=marto2+"px";
}

}


// Method from http://www.quirksmode.org/dom/getstyles.html
function getStyle(el,styleProp)
{
	var x = document.getElementById(el);
	if (x.currentStyle)
		var y = x.currentStyle[styleProp];
	else if (window.getComputedStyle){
		var y = document.defaultView.getComputedStyle(x,null).getPropertyValue(styleProp);}
	return y;
}