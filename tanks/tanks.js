var pid, meas,fce, l1msg, l2msg,rr1msg,r2msg,tlevel1,tlevel2,showPid,showFce,showMeasDev,lev1, lev2,r1, r2, kc;
var marto1=186,marto2=186, mode=true;

function randomizeInitialLevels(){
    init();
    lev1 = (Math.ceil(Math.random()*53)+20);
    lev2 = (Math.ceil(Math.random()*53)+20);
    r1 = 2+Math.round(Math.random()*790)/100;
    r2 = 2+Math.round(Math.random()*860)/100;
    a1 = 1+Math.round(Math.random()*600)/100;
    a2 = 1+Math.round(Math.random()*550)/100; 
    setLevel('level1',lev1);
    setLevel('level2',lev2);
    l1msg.innerHTML=(lev1/10).toFixed(1)+" m";
    l2msg.innerHTML=(lev2/10).toFixed(1)+" m";
    r1msg.innerHTML="R<sub>1</sub>="+r1.toFixed(2)+" m s kg<sup>-1</sup>";
    r2msg.innerHTML="R<sub>2</sub>="+r2.toFixed(2)+" m s kg<sup>-1</sup>";
    document.getElementById('a1msg').innerHTML="A<sub>1</sub>="+a1.toFixed(1)+" m<sup>2</sup>";
    document.getElementById('a2msg').innerHTML="A<sub>2</sub>="+a2.toFixed(1)+" m<sup>2</sup>";
}

function init(){
    meas=document.getElementById('measmenu');
    pid=document.getElementById('pidmenu');
    fce=document.getElementById('fcemenu');
    l1msg=document.getElementById('l1msg');
    l2msg=document.getElementById('l2msg');
    r1msg=document.getElementById('r1msg');
    r2msg=document.getElementById('r2msg');
    tlevel1=document.getElementById('level1');
    tlevel2=document.getElementById('level2');
    showPid=false;
    showFce=false;
    showMeasDev=false;
    kc=document.getElementById("Kc");
}

function doMove(){
    var high = 115, low=10, delay=120;
    if (mode){
        if (lev2<high){
            l2msg.innerHTML=(lev2/10).toFixed(1)+" m";
            changeLevel('level2',4);
        }
        if (lev1>low){
            l1msg.innerHTML=(lev1/10).toFixed(1)+" m";
            changeLevel('level1',-1);
        }
        if (lev2<high||lev1>low){
            setTimeout("doMove();",delay);
        }else{
            mode=!mode;
        }
    }else{
        if (lev1<high){
            l1msg.innerHTML=(lev1/10).toFixed(1)+" m";
            changeLevel('level1',1);
        }
        if (lev2>low){
            l2msg.innerHTML=(lev2/10).toFixed(1)+" m";
            changeLevel('level2',-4);
        }
        if (lev1<high||lev2>low){
            setTimeout("doMove();",delay);
        }else{
            mode=!mode;
        }
    }
}

function setLevel(ele,level){
    var H = parseFloat(getStyle(ele,"height"));
    diff=level-H;
    var l = ele=='level1'?tlevel1:tlevel2;
    l.style.height=level+"px";
    if ('level1'==ele){
        marto1=marto1-parseFloat(diff);
        l.style.marginTop=marto1+"px";
    }else{
        marto2=marto2-parseFloat(diff);
        l.style.marginTop=marto2+"px";
    }

}

function changeLevel(ele,diff){
    var H = parseFloat(getStyle(ele,"height"));
    H = H + diff;
    var level;
    level=ele=='level1'?tlevel1:tlevel2;
    level.style.height=H+"px";
    if ('level1'==ele){
        lev1=H;
    }else{
        lev2=H;
    }
    if ('level1'==ele){
        marto1=marto1-parseFloat(diff);
        level.style.marginTop=marto1+"px";
    }else{
        marto2=marto2-parseFloat(diff);
        level.style.marginTop=marto2+"px";
    }

}


// Method from http://www.quirksmode.org/dom/getstyles.html
function getStyle(el,styleProp)
{
    var x = document.getElementById(el),y;
    if (x.currentStyle)
        y = x.currentStyle[styleProp];
    else if (window.getComputedStyle){
        y = document.defaultView.getComputedStyle(x,null).getPropertyValue(styleProp);
    }
    return y;
}


function pidmenu(){
    if (showPid){
        pidmenuclose();
    }else{
        pid.style.display='block';
        kc.focus();
        kc.select();
        showPid=true;
    }
}

function pidmenuclose(){
    pid.style.display='none';
    showPid=false;
}



function measmenu(){
    if (showMeasDev){
        measmenuclose();
    }else{
        meas.style.display='block';
        showMeasDev=true;
    }
}

function measmenuclose(){
    meas.style.display='none';
    showMeasDev=false;
}

function fcemenu(){
    if (showFce){
        fcemenuclose();
    }else{
        fce.style.display='block';        
        showFce=true;        
    }
}

function fcemenuclose(){
    fce.style.display='none';
    showFce=false;
}

function toggleFX(){
    document.getElementById("infoimg").src="../images/info-fx1.png";
}

function toggleNoFX(){
    document.getElementById("infoimg").src="../images/info.png";
}