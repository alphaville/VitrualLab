<?php
session_start();
if (empty($_SESSION['count'])) {
 $_SESSION['count'] = 1;
} else {
 $_SESSION['count']++;
}
?>
<html>
  <head>
    <title>Virtual Lab - Step Response of a P-controller</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="../tooltip/style.css" />
    <link rel="stylesheet" type="text/css" href="style.css" />
    <!--
	SCRIPT
--><script type="text/javascript" language="javascript" src="../tooltip/script.js"></script><script type='text/javascript' src="../chung.js"></script>
  </head>
  <body id="body" onload="loadMe();">

<div class="container">
    <h2>Virtual Lab</h2>
    <h3>System with PID Controller</h3>
    <div>
      <small><em><a href="javascript:newPopup('./help.html');">Read First: Scope of the exercise</a></em></small>
    </div>
    <img src="PIDS.jpg" alt="Flowchart is missing" id="flowchart" name="flowchart"/>
    <tr action="" method="POST">
      <p id="message">
         Modify the values of the following parameters and hit "Run" to start the simulation. Place the mouse over each parameter to read a relevant explanation. 
      </p>
      <?
	if ($_POST==NULL){
		$kpval=300; $tival=0.01; $tdval=1; $psval="[1]"; $qsval="[1 1 1]"; $delayval=0;
	}else{
		$kpval=$_POST["Kp"]; $tival=$_POST["ti"]; $tdval=$_POST["td"];$psval=$_POST["ps"];
		$qsval=$_POST["qs"]; $delayval=$_POST["delay"]; $bode=$_POST["bode"];
		$nyquist=$_POST["nyquist"]; $amplitude=$_POST["amplitude"];
		$selectInputSignal=$_POST["selectInputSignal"]; $freq=$_POST["freq"];
	}
	include('./constants.php'); 
      ?>

      <form method="POST" action="#simulations">
        <input type="hidden" value="<?echo htmlspecialchars(session_id()); ?>" name="session_id"/>
	<?include('main_table.php');?>
        <small><em><a style="color:blue;cursor:pointer" onclick="showAdvanced();">
        <span id="advancedOptionsText">Show Advanced Options</span></a></em></small>
        <?include('advanced_options.php')?>
        <div class="cl"></div>
        <input type="submit" value="Run" id="sb"/>
      </form>
      <label id="simulations"/>
	
	<div class="results">
		
	</div>


      <div class="footer">
        <? include('footer.php')?>
      </div>
</div>
      </body>
      </html>
