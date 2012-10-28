<?php
/**
 * TUNING :: /tuning
 */
session_start();
if (empty($_SESSION['count'])) {
    $_SESSION['count'] = 1;
} else {
    $_SESSION['count']++;
}
include("../global.php");
include("../database.php");


/*
 * Check if the user is authenticated. If not redirect
 * to the login page and back here.
 */
if (!authorize_user($_COOKIE["id"], $_COOKIE["token"])) {
    header('Location: ' . $__BASE_URI . '/login/index.php?redirect=tuning');
    die("You are being redirected...");
}
$un = $_COOKIE['id'];

$lang = $_GET['lang'];
// Get the language 
if ($lang == NULL) {
    include('./en.php');
} else {
    $includename = './' . $lang . '.php';
    if (!@include('./' . $lang . '.php')) {
        include('./en.php');
        $lang = "en";
    }
}
/* Initialize parameters for this exercise and set them as cookies...
 * Check if there are cookies with the parameters. If yes, retrieve the
 * values from these cookies.
 */
$P1 = $_COOKIE["P1"];
$Q1 = $_COOKIE["Q1"];
$Q2 = $_COOKIE["Q2"];
$delay = $_COOKIE["delay"];

if (!isset($P1) || !isset($Q1) || !isset($Q2) || !isset($delay)) {
    $P1 = randomFloat(0.01, 0.2); //coefficient of s in P
    $Q3 = randomFloat(1.8, 2.2); //coefficient of s^3 in Q
    $Q2 = randomFloat(4.7, 5.4); //coefficient of s^2 in Q
    $Q1 = randomFloat(3.8, 4.3); //coefficient of s in Q
    $Q0 = randomFloat(0.9, 10); //constant term in Q
    /*
     * i.e. Q = Q0 + Q1 s + Q2 s^2 + Q3 s^3 
     */
    $delay = randomFloat(0.01, 1); //random delay
    // SET COOKIES...
    setcookie("P1", $P1, time() + 36000, "/tuning");
    setcookie("Q0", $Q0, time() + 36000, "/tuning");
    setcookie("Q1", $Q1, time() + 36000, "/tuning");
    setcookie("Q2", $Q2, time() + 36000, "/tuning");
    setcookie("Q3", $Q3, time() + 36000, "/tuning");
    setcookie("delay", $delay, time() + 36000, "/tuning");
}

function randomFloat($min, $max) {
    $range = $max - $min;
    $num = $min + $range * mt_rand(0, 32767) / 32767;
    $num = round($num, 4);
    return ((float) $num);
}
?>
<!DOCTYPE html>    
<html lang="<? echo $lang; ?>"> 
    <head>
        <title><? echo $page_title ?></title>
        <meta name="keywords" content="Automatic Control Lab, Virtual Lab, Automatic Control Playground" >
        <meta name="description" content="Online automatic control lab." >
        <meta name="author" content="Pantelis Sopasakis">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
        <script type='text/javascript' src="/chung.js"></script>   
        <script type='text/javascript' src="../ga.js"></script>   
        <script type='text/javascript' src="/flot/jquery.min.js"></script>
        <script type='text/javascript' src="/flot/jquery.flot.min.js"></script>
        <script type='text/javascript' src="/flot/jquery.flot.selection.min.js"></script>
        <script type='text/javascript' src="/flot/jquery.flot.crosshair.min.js"></script>
        <link rel="stylesheet" type="text/css" href="/style.css" >
        <link rel="shortcut icon" href="/vlab/favicon.ico" type="image/x-icon" />
        <link href="<? echo $FEED_RSS; ?>" rel="alternate" type="application/rss+xml" title="RSS 2.0" />
        <link href="<? echo $FEED_ATOM; ?>" rel="alternate" type="application/atom+xml" title="Atom 1.0" />
        <script type="text/javascript" src="../tooltip/script.js"></script>
        <link rel="stylesheet" type="text/css" href="../tooltip/style.css" >
    </head>
    <body id="body" onload="loadMe();">
        <div id="wrap">
            <div id="background">
                <img src="/images/background.jpg" class="stretch" alt="" >
            </div>
            <div id="leftcolumn">                
                <? include('../sidebar.php'); ?>
                <div class="left-text">
                    <div class="news"  lang="<? echo $lang; ?>">
                        <span style="font: bolder small times"><? echo $about_title; ?></span>
                        <p style="margin-top:5px;" id="left_paragraph" align="justify">
                            <? echo $about_vlab_text; ?>                            
                        </p>
                        <div id="elearning">
                            <div align="center">                            
                                <img src="/images/books.png" alt="octave.png" width="130">
                            </div>
                            <p align="center"><em>VLAB</em>: E-learning of Automatic Control!</p>
                        </div>
                    </div>

                </div>
            </div>
            <div id="rightcolumn">
                <!-- LEFT COLUMN -->
                <div id="banner">
                    <img src="/images/banner.gif" alt="" id="didi">
                </div>
            </div>
            <div id="container">                
                <div id="nav">
                    <a href=".." style="text-decoration:none">
                        <span class="navLink" onmouseover="highlight(this);" onmouseout="dehighlight(this);">Back to Main</span></a>
                </div>
                <div id="centercolumn" lang="<? echo $lang; ?>">
                    <h1 lang="<? echo $lang; ?>"><? echo $header; ?></h1>
                    <p lang="<? echo $lang; ?>" style="font-size: smaller;font-style: italic"><? echo $subheader; ?></p>
                    <div id="flowImg">
                        <a href="PIDS.png" target="_blank" id="flowcharthref">
                            <span class="hotspot" 
                                  onmouseover="tooltip.show('Click to open in new tab.');" 
                                  onmouseout="tooltip.hide();" style="border-bottom:0px">
                                <img src="PIDS.png" alt="Flowchart is missing" id="flowchart" name="flowchart">
                            </span>
                        </a>
                    </div>
                    <p lang="<? echo $lang; ?>" style="font-size: smaller;font-style: italic">
                        The following data are given for the above system: The numerator of the transfer function
                        of the plant is P(s)=1<? echo ($P1 < 0 ? "-" : "+") . "" . abs($P1); ?>s and the denominator is
                        Q(s)=1<? echo ($Q1 < 0 ? "-" : "+") . "" . abs($Q1); ?>s<? echo ($Q2 < 0 ? "-" : "+") . "" . abs($Q2); ?>s<sup>2</sup>.
                        The delay is t<sub>d</sub>=<? echo $delay; ?>. The measuring element does not affect the dynamics and
                        it can be considered to have G<sub>f</sub>(s)=1.
                        You may use the <a href="/pid?kc=1&ti=infty&td=0&p=[<? echo $P1; ?> 1]&q=[<? echo $Q2; ?> <? echo $Q1; ?> 1]
                                           &delay=<? echo $delay; ?>" target="_blank" >PID workbench</a> of VLAB to tune a PID controller for this system.
                        Once you have completed the tuning, enter your result in the form below and click the "Simulate" button:
                    </p>
                    <div class="cl"></div>
                    <div>
                        <table>
                            <colgroup>
                                <col style="width:40px">
                                <col  style="width:170px">
                                <col>	
                            <tr>
                                <td>
                                    <span class="hotspot" onmouseover="tooltip.show('<strong>K<sub>c</sub></strong> is the static gain of the PID controller.');" onmouseout="tooltip.hide();">K<sub>c</sub></span>
                                </td>
                                <td><input class="normal" type="text"  value="1" name="Kc" id="Kc" onkeyup="return checkNumeric(this);" ></td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="hotspot" 
                                          onmouseover="tooltip.show('<strong>T<sub>i</sub></strong> is the intergral time of the PID controller.');" 
                                          onmouseout="tooltip.hide();">T<sub>i</sub></span>
                                </td>
                                <td><input class="normal" type="text" name="ti" value="1" id="ti" onkeyup="return checkNumeric(this);" ></td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="hotspot" 
                                          onmouseover="tooltip.show('<strong>T<sub>d</sub></strong> is the differential time of the PID controller.');" 
                                          onmouseout="tooltip.hide();">T<sub>d</sub></span>
                                </td>
                                <td><input class="normal" type="text" value="0"  name="td" id="td" onkeyup="return checkNumeric(this);" ></td>
                            </tr>
                        </table>
                    </div>
                    <div class="cl"></div>
                    <p lang="<? echo $lang; ?>" style="font-size: smaller;font-style: italic">
                        Perform a simulation of the step-response of the closed-loop system.
                    </p>
                    <input type="submit" value="Simulate" onclick="simulate(<? echo $P1 . "," . $Q1 . "," . $Q2 . "," . $delay; ?>);">                    
                    <div id="response_results" style="display:none">
                        <p lang="<? echo $lang; ?>" style="font-size: smaller;font-style: italic">
                            This is the closed-loop step response of the system with the PID controller
                            with the parameters you specified above.
                        </p>
                        <p style="font-weight: bold;text-align: center">Response Curve</p>
                        <div id="placeholder" style="width:95%;height:300px;margin-left:20px;margin-top:20px"></div>
                        <p lang="<? echo $lang; ?>" style="font-size: smaller;font-style: italic">
                            Here is some evaluation of the closed loop system:</p>
                        <table style="font-size: smaller;font-style: italic">
                            <tr>
                                <td><span class="hotspot" 
                                          onmouseover="tooltip.show('Whether the closed-loop system\n\
                                          appears to be stable.');" onmouseout="tooltip.hide();">Stability</span>
                                </td><td><span id="isStable"></span></td>                                                               
                            </tr>
                            <tr>
                                <td><span class="hotspot" 
                                          onmouseover="tooltip.show('The ultimate value of the closed-loop system \n\
                                          response according to the simulation.');" onmouseout="tooltip.hide();">Ultimate Value</span>
                                </td><td><span id="ultimateValue"></span></td>
                            </tr>
                            <tr>
                                <td><span class="hotspot" 
                                          onmouseover="tooltip.show('Ultimate deviation from the set-point.');" 
                                          onmouseout="tooltip.hide();">Regulation Deviation</span>&nbsp;&nbsp;&nbsp;
                                </td><td><span id="regDev"></span></td>
                            </tr>
                            <tr>
                                <td><span class="hotspot" 
                                          onmouseover="tooltip.show('Integral over time of the quadratic deviation from \n\
                                          the set-point.');" onmouseout="tooltip.hide();">IQE</span>
                                </td><td><span id="integral"></span></td>
                            </tr>
                            <tr>
                                <td><span class="hotspot" 
                                          onmouseover="tooltip.show('The maximum value of the response');" 
                                          onmouseout="tooltip.hide();">Maximum Value</span>
                                </td><td><span id="max"></span></td>
                            </tr>
                        </table>
                        <div id="doSubmit" style="display:none;" >
                            <p lang="<? echo $lang; ?>" style="font-size: smaller;font-style: italic">
                                You may save your results and submit them later. You will be able to edit your
                                submitted exercise any time before you finalise it.
                            </p>
                            <!-- This span holds the whole data. -->
                            <span style="display:none" id="data"></span>
                            <input type="submit" value="Save Results" onclick="submit();">                        
                        </div><!-- END OF doSubmit -->

                        <div id="submitReceipt" style="display:none;" >
                            <p lang="<? echo $lang; ?>" style="font-size: smaller;font-style: italic">
                                <span id="savedMsg"></span>
                            </p>
                        </div><!-- END OF submitReceipt -->
                    </div><!-- END OF response_results -->                   
                </div><!-- END OF centercolumn -->

                <div class="footer" id="footer">
                    <? include('../footer.php') ?>
                </div>
            </div>            
        </div>
    </body>
</html>
