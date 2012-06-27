<?php
session_start();
if (empty($_SESSION['count'])) {
    $_SESSION['count'] = 1;
} else {
    $_SESSION['count']++;
}
include("../global.php");
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
// Initialize parameters for this exercise and set them as cookies...
$P1 = rand(-1000, 1000) / 100; //coefficient of s in P
$Q1 = rand(-2000, 2000) / 1000; //coefficient of s in Q
$Q2 = rand(-100, 100) / 1000; //coefficient of s2 in Q
$delay = rand(0, 1000) / 4000;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd" 
    >    
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
        <link href="<?echo $FEED_RSS;?>" rel="alternate" type="application/rss+xml" title="RSS 2.0" />
        <link href="<?echo $FEED_ATOM;?>" rel="alternate" type="application/atom+xml" title="Atom 1.0" />
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
                        Once you have completed the tuning, enter your result in the form below and click next:
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
                                <td><input class="normal" type="text"  name="Kc" id="Kc" onkeyup="return checkNumeric(this);" ></td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="hotspot" 
                                          onmouseover="tooltip.show('<strong>T<sub>i</sub></strong> is the intergral time of the PID controller.');" 
                                          onmouseout="tooltip.hide();">T<sub>i</sub></span>
                                </td>
                                <td><input class="normal" type="text" name="ti" id="ti" onkeyup="return checkNumeric(this);" ></td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="hotspot" 
                                          onmouseover="tooltip.show('<strong>T<sub>d</sub></strong> is the differential time of the PID controller.');" 
                                          onmouseout="tooltip.hide();">T<sub>d</sub></span>
                                </td>
                                <td><input class="normal" type="text"  name="td" id="td" onkeyup="return checkNumeric(this);" ></td>
                            </tr>
                        </table>
                    </div>
                    <div class="cl"></div>
                    <p lang="<? echo $lang; ?>" style="font-size: smaller;font-style: italic">
                        Perform a simulation of the step-response of the closed-loop system.
                    </p>
                    <input type="submit" value="Simulate" onclick="simulate(<?echo $P1.",".$Q1.",".$Q2.",".$delay;?>);">                    
                    <div id="response_results" style="display:none">
                        <p style="font-weight: bold;text-align: center">Response Curve</p>
                        <div id="placeholder" style="width:95%;height:300px;margin-left:20px;margin-top:20px"></div>
                    </div>
                </div>
                <div class="footer" id="footer">
                    <? include('../footer.php') ?>
                </div>
            </div>            
        </div>
    </body>
</html>
