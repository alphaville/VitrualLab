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

<?
	if ($_POST==NULL){
		$open=0;
		$kpval=300; $tival=0.01; $tdval=1; $psval="[1]"; $qsval="[1 1 1]"; $delayval=0;
	}else{
		$open=$_POST["open"]=="on"?1:0;
		$kpval=$_POST["Kp"]; $tival=$_POST["ti"]; $tdval=$_POST["td"];$psval=$_POST["ps"];
		$qsval=$_POST["qs"]; $delayval=$_POST["delay"]; $bode=$_POST["bode"]=="on"?1:0;
		$nyquist=$_POST["nyquist"]=="on"?1:0; $amplitude=$_POST["amplitude"];
		$selectInputSignal=$_POST["selectInputSignal"]; $freq=$_POST["freq"];
	}
	include('./constants.php'); 
	$image=$open=="1"?'PIDS2.png':'PIDS.png';
?>


<div class="container">
<div id="background">
    <img src="../background.jpg" class="stretch" alt="" />
</div>

    <h2>Virtual Lab</h2>
    <h3>System with PID Controller</h3>
    <div>
      <small><em><a href="javascript:newPopup('./help.html');">Read First: Scope of the exercise</a></em></small>
    </div>
    
    <a href="<?echo $image;?>" target="_blank"><span class="hotspot" 
    onmouseover="tooltip.show('Click to open in new tab.');" onmouseout="tooltip.hide();" style="border-bottom:0px">
     <img src="<?echo $image;?>" alt="Flowchart is missing" id="flowchart" name="flowchart" border="0"/>
    </span></a>
    <tr action="" method="POST">
      <p id="message">
         Modify the values of the following parameters and hit "Run" to start the simulation. Place the mouse over each parameter to read a relevant explanation. 
      </p>      

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
		
	<?
	if ($_POST!=null){
		$sid=$_POST["session_id"];
		$command = './runPIDCtrl '.escapeshellarg($kpval).
		" ".escapeshellarg($tival).
		" ".escapeshellarg($tdval).
		" ".escapeshellarg($psval).
		" ".escapeshellarg($qsval).
		' '.escapeshellarg($delayval).
		' '.escapeshellarg($open).
		' '.escapeshellarg($bode).
		' '.escapeshellarg($nyquist).
		' '.escapeshellarg($selectInputSignal).
		' '.escapeshellarg($amplitude).
		' '.escapeshellarg($freq).
		' "./images/'.$sid.'"';
		// echo $command;
		$retval=exec($command,$ret);	
		$bode_jpg="./images/".$sid."bode.jpg";
		$nyq_jpg="./images/".$sid."nyq.jpg";		
		echo '<div class="results">
		<h3>Results</h3>';
		$i=1;
		if ($bode){		
		echo '<div class="bodeBox"><img class="bode" src="'.$bode_jpg.'" />Figure '.($i++).' : Bode Plot</div>'; }
  		if ($nyquist){
		echo '<div class="nyqBox"><img class="nyq" src="'.$nyq_jpg.'" />Figure '.($i++).' : Nyquist Plot</div>';}
		echo '</div>';
	}	
	?>

	
          
	


      <div class="footer">
        <? include('footer.php')?>
      </div>
</div>
      </body>
      </html>
