<?php
session_start();
if (empty($_SESSION['count'])) {
 $_SESSION['count'] = 1;
} else {
 $_SESSION['count']++;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>Virtual Lab - Step Response of a P-controller</title>
  <meta name="GENERATOR" content="Quanta Plus">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" type="text/css" href="../tooltip/style.css" />
   
<!--	STYLE -->
<style type="text/css">
A:LINK    {Text-Decoration: none; }
A:VISITED {Text-Decoration: none; }
a:hover {COLOR: #FF0000; }
</style> 

<!--	SCRIPT -->
<script type='text/javascript' src='https://www.google.com/jsapi'></script>      
<script type='text/javascript'>
function check(val){
	if (val.length==0){
		document.getElementById("sb").disabled=true;
	}else{
		if (isNumeric(val)==true){
			document.getElementById("sb").disabled=false;
		}else{document.getElementById("sb").disabled=true;}		
	}
}
function isNumeric(x) {
  return !isNaN(parseFloat(x)) && isFinite(x);
}
</script>


</head>

<body id="body">  

<h2>P-controller simulation</h2>
<img src="PC.jpg" alt="Flowchart is missing"/>

<p id="message1">
Change the value of <span class="hotspot" onmouseover="tooltip.show('<strong>Kp</strong> is the static gain of the proportional controller. Notice that by increasing its value the <strong>ultimate</strong> state approaches 1 asymptotically.');" onmouseout="tooltip.hide();">Kp</span> and click 'Run' to run the simulation...
</p>
<form action="" method="POST">
<?
if ($_POST==NULL){
 $kpval=300;
}else{
 $kpval=$_POST["Kp"];
}
?>
<input type="text" value="<?echo $kpval;?>" name="Kp" id="Kp" onkeyup="return check(this.value);" />
<input type="hidden" value="<?echo htmlspecialchars(session_id()); ?>" name="session_id"/>
<input type="submit" value="Run" id="sb"/>
</form>
<p>&nbsp;</p>

<?
// Check whether there has been something POSTed...
if ($_POST!=NULL){
  $sid=$_POST["session_id"];
  $command="./runController ".escapeshellcmd($_POST["Kp"])." ./images/".$sid;
  $ret=exec($command, $retval);
  $img_jpg="./images/".$sid.".jpg";
  $img_svg="./images/".$sid.".svg";  
    echo '<div id="response">';
    echo '<p><embed id="svgImg" src="'.$img_svg.'" type="image/svg+xml" height="70%"/></p>';
  $ultimateState='<span class="hotspot" onmouseover="tooltip.show(\'<strong>Ultimate State</strong> is the limit of the state at infinity upon excitation of the system with a step pulse.\');" onmouseout="tooltip.hide();">Ultimate State</span>';
    echo '<p>&nbsp;</p><p>'.$ultimateState.' : <a id="ustate">'.$ret."</a></p>";  
    echo '<p id="imgformatsParagraph">The image is available in <a href="'.$img_svg.'" target="_blank">SVG</a> and ';
    echo '<a href="'.$img_jpg.'" target="_blank">JPG</a> formats.</p>';
    echo '</div>';
}
?>

<div id='chart_div' title="chart_div" style="display:none"></div>



<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p align="center">
<small>
<span class="hotspot" onmouseover="tooltip.show('National Technical University of Athens, Unit of Automatic Control and Informatics');" onmouseout="tooltip.hide();">
<a href="http://www.chemeng.ntua.gr/labs/control_lab/">Automatic Control Lab, NTUA</a>
</span> |
<span class="hotspot" onmouseover="tooltip.show('Designed by Pantelis Sopasakis');" onmouseout="tooltip.hide();">
<a href="http://gr.linkedin.com/in/sopasakis">Design by Pantelis Sopasakis</a> 
</span>|
<span class="hotspot" onmouseover="tooltip.show('Source Code Hosted on Github');" onmouseout="tooltip.hide();">
<a href="">Source Code</a> 
</span>|
<span class="hotspot" onmouseover="tooltip.show('GNU GPN v3 - Attribution, Non-Commercial Use, Free distribution');" onmouseout="tooltip.hide();">
<a href="http://www.gnu.org/copyleft/gpl.html">License</a>
</span>
</small>
</p>


<script type="text/javascript" language="javascript" src="../tooltip/script.js"></script>
</body>
</html>



