<?php
session_start();
if (empty($_SESSION['count'])) {
 $_SESSION['count'] = 1;
} else {
 $_SESSION['count']++;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd" 
>
<html>
  <head>
    <title>2 Tanks</title>
    <meta name="keywords" content="Automatic Control Lab, Virtual Lab, Automatic Control Playground" >
    <meta name="description" content="Online automatic control lab." >
    <meta name="author" content="Pantelis Sopasakis">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" type="text/css" href="../tooltip/style.css" >
    <link rel="stylesheet" type="text/css" href="../style.css" >
    <script type="text/javascript" src="../tooltip/script.js"></script>
    <script type='text/javascript' src="../chung.js"></script>
    <script type='text/javascript' src="../ga.js"></script>
    <script type='text/javascript' src="./tanks.js"></script>
    <link rel="shortcut icon" href="/vlab/favicon.ico" type="image/x-icon" >
  </head>
  <body id="body" onload="loadMe();">
    <?
	include('../global.php');		
    ?>
    <div id="wrap">
      <div id="background">
        <img src="../images/background.jpg" class="stretch" alt="" >
      </div>
      <div id="leftcolumn">
        <!-- LEFT COLUMN -->
      <?include('../sidebar.php'); 
        ?>
      </div>
      <div id="rightcolumn">
        <!-- RIGHT COLUMN -->	
      </div>
      <div id="container">
        <div id="nav">
          <a href=".." style="text-decoration:none"><span class="navLink" onmouseover="highlight(this);" onmouseout="dehighlight(this);">Back to Main</span></a>
        </div>
        <div id="centercolumn">
          <h1>
             Virtual Lab 
          </h1>
          <h3>
             Coupled Tanks &amp; PID Controller
          </h3>
          <div id="scopeMessage" class="smallTip">
            <a href="javascript:newPopup('./help.html');" id="scopeLink">Read First: Scope of the exercise</a>
          </div>
        <div id="level1"></div>
        <div id="level2"></div>
	<div id="flowImg">
            <a href="javascript:setLevel('level2',50+20*Math.random());setLevel('level1',40+23*Math.random());" id="flowcharthref"><span class="hotspot" 
            onmouseover="tooltip.show('Click to open in new tab.');" onmouseout="tooltip.hide();" style="border-bottom:0px">
       <img src="../images/ct.png" alt="Flowchart is missing" id="tanksimg" name="flowchart">
    </span></a>
          </div>
          
        </div>
      </div>
      <div class="footer" id="footer">
        <? include('../footer.php') 
        ?>
      </div>
    </div>
  </body>
</html>
