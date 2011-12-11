<?php
session_start();
if (empty($_SESSION['count'])) {
 $_SESSION['count'] = 1;
} else {
 $_SESSION['count']++;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
  <head>
    <title>Virtual Lab - Step Response of a P-controller</title>
     <meta name="keywords" content="Automatic Control Lab, Virtual Lab, Automatic Control Playground" >
     <meta name="description" content="Online automatic control lab." >
     <meta name="author" content="Pantelis Sopasakis">
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
     <link rel="stylesheet" type="text/css" href="../tooltip/style.css" >
     <link rel="stylesheet" type="text/css" href="style.css" >
     <script type="text/javascript" src="../tooltip/script.js"></script>
     <script type='text/javascript' src="../chung.js"></script>
  </head>
  <body id="body" onload="loadMe();">

<?
	if ($_POST==NULL){
		$open=0;
		$kpval=300; $tival=0.01; $tdval=1; $psval="[1]"; $qsval="[1 1 1]"; $delayval=0;
		$amplitude=1;$selectInputSignal="1";$freq=100;
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

<div id="nav">
<a href=".." style="color:grey;"><span class="navLink">Back to Main Page</span></a>
</div>
<div id="background">
    <img src="../images/background.jpg" class="stretch" alt="" >
</div>

    <h2>Virtual Lab</h2>
    <h3>System with PID Controller</h3>
    <div id="scopeMessage" class="smallTip">
      <a href="javascript:newPopup('./help.html');" id="scopeLink">Read First: Scope of the exercise</a>
    </div>
    
    <a href="<?echo $image;?>" target="_blank"><span class="hotspot" 
    onmouseover="tooltip.show('Click to open in new tab.');" onmouseout="tooltip.hide();" style="border-bottom:0px">
     <img src="<?echo $image;?>" alt="Flowchart is missing" id="flowchart" name="flowchart" border="0">
    </span></a>

      <p id="message">
         Modify the values of the following parameters and hit "Run" to start the simulation. Place the mouse over each parameter to read a relevant explanation. 
      </p>      

      <form method="POST" action="#simulations">
        <input type="hidden" value="<?echo htmlspecialchars(session_id()); ?>" name="session_id">
	<?include('main_table.php');?>
        <div class="smallTip">
	<a style="color:blue;cursor:pointer" onclick="showAdvanced();">
        <span id="advancedOptionsText">Show Advanced Options</span></a>
	</div>
        <?include('advanced_options.php')?>
        <div class="cl"></div>
        <input type="submit" value="Run" id="sb">
      </form>
      
		
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
		$retval=exec($command,$ret);	
		$bode_jpg="./images/".$sid."bode.jpg";
		$nyq_jpg="./images/".$sid."nyq.jpg";		
		$resp_jpg="./images/".$sid."resp.jpg";
		echo '<div class="results">
		<label id="simulations"></label>
		<h3>Results</h3>';
		
		$i=1;
		if ($open=="1"){
		if ($selectInputSignal="1"){
			echo '<div class="nyqBox"><img class="nyq" src="'.$resp_jpg.'" >Figure '.($i++).' : Response Plot</div>';
		}
		if ($bode){		
			echo '<div class="bodeBox"><img class="bode" src="'.$bode_jpg.'" >Figure '.($i++).' : Bode Plot</div>'; 
		}
  		if ($nyquist){
			echo '<div class="nyqBox"><img class="nyq" src="'.$nyq_jpg.'" >Figure '.($i++).' : Nyquist Plot</div>';
		}
		}else{echo 'Try Open Loop Simulations - Closed Loop not supported yet!';}
		echo '</div>';
	}	
	?>
</div>
      <div class="footer" id="footer">
        <? include('footer.php')?>
      </div>
      </body>
      </html>
