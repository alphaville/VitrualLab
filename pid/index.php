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
    <!--
	STYLE 
--><style type="text/css">
A:LINK    {Text-Decoration: none}
A:VISITED {Text-Decoration: none; color:blue}
a:hover {
 COLOR: #FF0000;
}
    </style>
    <!--
	SCRIPT
--><script type="text/javascript" language="javascript" src="../tooltip/script.js"></script><script type='text/javascript' src="../chung.js"></script>
  </head>
  <body id="body" onload="loadMe();">
    <h2>
       Virtual Lab 
    </h2>
    <div>
      <small><em><a href="javascript:newPopup('./help.html');">Read First: Scope of the exercise</a></em></small>
    </div>
    <img src="PIDS.jpg" alt="Flowchart is missing" id="flowchart" name="flowchart"/>
    <tr action="" method="POST">
      <p id="message1" style="width:500" align="justify">
         Modify the values of the following parameters and hit "Run" to start the simulation. Place the mouse over each parameter to read a relevant explanation. 
      </p>
      <?
if ($_POST==NULL){
 $kpval=300;
 $tival=0.01;
 $tdval=1;
 $psval="[1]";
 $qsval="[1 1 1]";
 $delayval=0;
}else{
 $kpval=$_POST["Kp"];
 $tival=$_POST["ti"];
 $tdval=$_POST["td"];
 $psval=$_POST["ps"];
 $qsval=$_POST["qs"];
 $delayval=$_POST["delay"];
 $bode=$_POST["bode"];
 $nyquist=$_POST["nyquist"];
 $amplitude=$_POST["amplitude"];
 $selectInputSignal=$_POST["selectInputSignal"];
 $freq=$_POST["freq"];
}
include('./constants.php'); 
      ?>
      <form method="POST" action="#simulations">
        <input type="hidden" value="<?echo htmlspecialchars(session_id()); ?>" name="session_id"/>

<!-- TABLE: START -->
        <table>
          <tr>
            <td>
              <input type="checkbox" name="openLoop" onClick="openLoopAction(this);">
            </td>
            <td>
              <span id="openLoopHint"><?echo $__OPENLOOP_HTML;?></span>
            </td>
          </tr>
          <tr>
            <td>
               &nbsp; 
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <small><em>PID Controller Tuning</em></small>
            </td>
          </tr>
          <tr>
            <td>
              <?echo $__KP_HTML;
              ?>
            </td>
            <td>
              <input type="text" value="<?echo $kpval;?>" name="Kp" id="Kp" onkeyup="return check(this.value);" />
            </td>
          </tr>
          <tr>
            <td>
              <?echo $__TI_HTML;
              ?>
            </td>
            <td>
              <input type="text" value="<?echo $tival;?>" name="ti" id="ti" onkeyup="return check(this.value);" />
            </td>
          </tr>
          <tr>
            <td>
              <?echo $__TD_HTML;
              ?>
            </td>
            <td>
              <input type="text" value="<?echo $tdval;?>" name="td" id="td" onkeyup="return check(this.value);" />
            </td>
          </tr>
          <tr>
            <td>
               &nbsp; 
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <small><em>System Parameters Configuration</em></small>
            </td>
          </tr>
          <tr>
            <td>
              <?echo $__P_HTML;
              ?>
            </td>
            <td>
              <input type="text" value="<?echo $psval?>" name="ps" id="ps"  />
            </td>
          </tr>
          <tr>
            <td>
              <?echo $__Q_HTML;
              ?>
            </td>
            <td>
              <input type="text" value="<?echo $qsval?>" name="qs" id="qs" />
            </td>
          </tr>
          <tr>
            <td>
              <?echo $__DELAY;
              ?>
            </td>
            <td>
              <input type="text" value="<?echo $delayval?>" name="delay" id="delay" />
            </td>
          </tr>
          <tr>
            <td>
               &nbsp; 
            </td>
          </tr>
        </table>
        <!-- TABLE: END -->

        <small><em><a style="color:blue;cursor:pointer" onclick="showAdvanced();"><span id="advancedOptionsText">Show Advanced Options</span></a></em></small>
        <table id="advOptions" style="display:none">
          <tr>
            <td colspan="2">
              <small>Generated Diagrams...</small>
            </td>
          </tr>
          <tr>
            <td>
               Bode Diagram 
            </td>
            <td>
              <input type="checkbox" name="bode" id="bode" onClick="openLoopAction(this);">
            </td>
          </tr>
          <tr>
            <td>
               Nyquist Diagram 
            </td>
            <td>
              <input type="checkbox" name="nyquist" id="nyquist" onClick="openLoopAction(this);">
            </td>
          </tr>
          <tr>
            <td>
               &nbsp; 
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <small>Excitation...</small>
            </td>
          </tr>
          <tr>
            <td>
               Input Signal 
            </td>
            <td>
              <select name="selectInputSignal" id="selectInputSignal" onchange="signalParameters(this);">
              <option value="1">
                Step
              </option><option value="2">
                Impulse
              </option><option value="3">
                Harmonic
              </option>
              </select>
            </td>
          </tr>
        </table>
        <table id="step" style="display:none;">
          <tr>
            <td>
               Amplitute 
            </td>
            <td>
              <input type="text" name="amplitute" id="amplitute" value="1"/>
            </td>
          </tr>
        </table>
        <table id="harmonic" style="display:none;">
          <tr>
            <td>
               Amplitute 
            </td>
            <td>
              <input type="text" name="amplitute" id="amplitute" value="1"/>
            </td>
          </tr>
          <tr>
            <td>
               Frequency 
            </td>
            <td>
              <input type="text" name="freq" id="freq" value="100"/>
            </td>
          </tr>
        </table>
        <div class="clear">
          <br/>
        </div>
        <input type="submit" value="Run" id="sb"/>
      </form>
  
    <label id="simulations"/>

<?
 echo $freq;
?>

      <p>
         &nbsp; 
      </p>
      <p>
         &nbsp; 
      </p>
      <p>
         &nbsp; 
      </p>
      <p>
         &nbsp; 
      </p>
      <p>
         &nbsp; 
      </p>
      <p>
         &nbsp; 
      </p>
      <p>
         &nbsp; 
      </p>
      <p>
         &nbsp; 
      </p>

      <p align="center">
        <small>
<span class="hotspot" onmouseover="tooltip.show('National Technical University of Athens, Unit of Automatic Control and Informatics');" onmouseout="tooltip.hide();">
<a href="http://www.chemeng.ntua.gr/labs/control_lab/">Automatic Control Lab, NTUA</a>
</span> | <span class="hotspot" onmouseover="tooltip.show('Designed by Pantelis Sopasakis');" onmouseout="tooltip.hide();">
<a href="http://gr.linkedin.com/in/sopasakis">Design by Pantelis Sopasakis</a> 
</span>| <span class="hotspot" onmouseover="tooltip.show('Source Code Hosted on Github');" onmouseout="tooltip.hide();">
<a href="">Source Code</a> 
</span>| <span class="hotspot" onmouseover="tooltip.show('GNU GPN v3 - Attribution, Non-Commercial Use, Free distribution');" onmouseout="tooltip.hide();">
<a href="http://www.gnu.org/copyleft/gpl.html">License</a>
</span>
</small>
      </p>
      </body>
      </html>
