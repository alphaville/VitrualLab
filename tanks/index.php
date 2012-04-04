<?php
session_start();
if (empty($_SESSION['count'])) {
    $_SESSION['count'] = 1;
} else {
    $_SESSION['count']++;
}
?>
<!DOCTYPE html>
<html>
    <?
    $lang = $_GET['lang'];
    // Get the language 
    if ($lang == NULL) {
        include('./en.php');
    } elseif (strcmp('el', $lang) == 0) {
        include('./el.php');
    } elseif (strcmp('en', $lang) == 0) {
        include('./en.php');
    }
    include('../global.php');
    ?>
    <head>
        <title><? echo $title; ?></title>        
        <meta name="keywords" content="Automatic Control Lab, Virtual Lab, Automatic Control Playground" >
        <meta name="description" content="Online automatic control lab." >
        <meta name="author" content="Pantelis Sopasakis">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=0">
        <meta http-equiv="Expires" content="0">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
        <meta name="rights" content="GNU GPL version 3" />
        <link rel="stylesheet" type="text/css" href="../style.css" >
        <link rel="stylesheet" type="text/css" href="./style-tanks.css" >
        <script type="text/javascript" src="../tooltip/script.js"></script>
        <script type='text/javascript' src="../chung.js"></script>
        <script type='text/javascript' src="../ga.js"></script>
        <script type='text/javascript' src="./tanks.js"></script>
        <link href="/rss/feed.php" rel="alternate" type="application/rss+xml" title="RSS 2.0" />
        <link href="/rss/feed.php" rel="alternate" type="application/atom+xml" title="Atom 1.0" />
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    </head>
    <body id="body" onload="randomizeInitialLevels();" >    
        <script type='text/javascript' src="../wz_tooltip.js"></script>        
        <div id="wrap">
            <div id="background">
                <img src="../images/background.jpg" class="stretch" alt="" >
            </div>
            <div id="leftcolumn">
                <!-- LEFT COLUMN -->
                <? include('../sidebar.php'); ?>
                <div class="left-text">
                    <div class="news">
                        <div id="leftsb_text">
                            <h3><? echo $left_sidebar_title; ?></h3>
                            <p id="left_paragraph" align="justify">
                                <? echo $left_sidebar_paragraph; ?> 
                            </p>
                        </div>
                        <div class="cl" id="leftsb_divider"></div>                        
                        <div id="octave">
                            <div align="center">
                                <a href="http://www.gnu.org/software/octave/">
                                <img src="../images/octave.png" alt="octave.png" width="200">
                                </a>
                            </div>
                            <p align="center"><em>Octave</em>: open-source computing power!</p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="rightcolumn">
                <div id="rightmenubar">
                    <span class="menuicon" onclick="randomizeInitialLevels();">
                        <img src="../images/refresh.png" alt="Refresh" title="Refresh">
                    </span>
                    <span class="menuicon" onclick="spmenu();">
                        <img src="../images/equalizer.png" alt="Set Point" title="Set Point">
                    </span>
                    <span class="menuicon"  onclick="doMove();">
                        <img src="../images/run.png" alt="Run" title="Run">
                    </span>

                </div>
                <div id="rightmenu">

                    <div id="setpoint" class="rmenu">
                        <div id="close_sp" class="closeimg">
                            <img src="../images/close.png" onclick="spmenuclose()();" alt="close">
                        </div>
                        <u><? echo $setpoint; ?></u>
                        <div style="height:10px">
                        </div>
                        <table>
                            <colgroup>
                                <col width="50">
                                <col>
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td>y<sub>sp</sub></td>
                                    <td><input type="text" id="ysp" name="ysp" class="tinyInput" value="5"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                    <div id="pidmenu" class="rmenu">
                        <div id="close_pid" class="closeimg">
                            <img src="../images/close.png" onclick="pidmenuclose();" alt="close">
                        </div>
                        <em><u><? echo $pidcontroller; ?></u></em>
                        <div style="height:10px">
                        </div>
                        <table>
                            <colgroup>
                                <col width="50">
                                <col>
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td>
                                        K<sub>c</sub>
                                    </td>
                                    <td>
                                        <input type="text" id="Kc" name="Kc" class="tinyInput" value="5">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        T<sub>i</sub>
                                    </td>
                                    <td>
                                        <input type="text" id="Ti" name="Ti" class="tinyInput" value="0.5">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        T<sub>d</sub>
                                    </td>
                                    <td>
                                        <input type="text" id="Td" name="Td" class="tinyInput" value="0.1">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div style="height:17px">
                        </div>
                    </div>
                    <div id="measmenu" class="rmenu">
                        <div id="close_meas" class="closeimg">
                            <img src="../images/close.png"  onclick="measmenuclose();" alt="close">
                        </div>
                        <em><u><? echo $measdev; ?></u></em>
                        <div style="height:10px">
                        </div>
                        <table>
                            <colgroup>
                                <col width="50">
                                <col>
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td>
                                        P<sub>m</sub>
                                    </td>
                                    <td>
                                        <input type="text" id="Pm" name="Pm" class="tinyInput" value="[1]">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Q<sub>m</sub>
                                    </td>
                                    <td>
                                        <input type="text" id="Qm" name="Qm" class="tinyInput" value="[1]">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div style="height:17px">
                        </div>
                    </div>
                    <div id="fcemenu" class="rmenu">
                        <div id="close_fce" class="closeimg">
                            <img src="../images/close.png"  onclick="fcemenuclose();" alt="close">
                        </div>
                        <em><u><? echo $fce; ?></u></em>
                        <div style="height:10px">
                        </div>
                        <table>
                            <colgroup>
                                <col width="50">
                                <col>
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td>
                                        P<sub>f</sub>
                                    </td>
                                    <td>
                                        <input type="text" id="Pf" name="Pf" class="tinyInput" value="[1]">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Q<sub>f</sub>
                                    </td>
                                    <td>
                                        <input type="text" id="Qf" name="Qf" class="tinyInput" value="[1]">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div style="height:17px">
                        </div>
                    </div>
                </div>
                <!-- RIGHT COLUMN -->
            </div>
            <div id="container">                
                <div id="nav">
                    <a href=".." style="text-decoration:none">
                        <span class="navLink" onmouseover="highlight(this);" onmouseout="dehighlight(this);">
                            Back to Main
                        </span>
                    </a>
                </div>

                <div id="langbar" align="right" >                    
                    <table>  
                        <tr>
                            <td><a href="<? echo $ohterlangattribute; ?>">
                                    <? echo $otherlang; ?>
                                </a>
                            </td>
                            <td><a href="<? echo $ohterlangattribute; ?>">
                                    <img src="<? echo $otherlangimg; ?>" alt="">
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>

                <div id="centercolumn">
                    <table>
                        <colgroup>
                            <col style="width:100%">
                            <col>
                        </colgroup>
                        <tr>
                            <td>                                
                                <b style="font-size: xx-large"><? echo $h1title; ?></b>
                            </td>
                            <td>
                                <img id="infoimg" src="../images/info.png" width="45"
                                     onmouseover="toggleFX();" onmouseout="toggleNoFX();"
                                     onclick="newPopup('./help-en.php');" alt="Help">
                            </td>
                        </tr>
                    </table>


                    <h3><? echo $h3title; ?></h3>
                    <!--Experimental Part-->
                    <div id="experiment">
                        <!--Floating Messages-->
                        <div id="l1msg" class="fmsg">
                        </div>
                        <div id="l2msg" class="fmsg">
                        </div>
                        <div id="r1msg" class="fmsg">
                        </div>
                        <div id="r2msg" class="fmsg">
                        </div>
                        <div id="a1msg" class="fmsg">
                        </div>
                        <div id="a2msg" class="fmsg">
                        </div>
                        <!--Floating Components-->
                        <div id="pid" class="component" onclick="pidmenu();" 
                             onmouseover="Tip('Click on the box to configure the PID controller',
                                 WIDTH, ttwidth, TITLE, 'Controller',DURATION, ttduration,
                                 SHADOW, true, FADEIN, 300, FADEOUT, 300, 
                                 STICKY, 0, OFFSETY, -10, DELAY, ttdelay)">
                        </div>
                        <div id="measuringdev" class="component" onclick="measmenu();"
                             onmouseover="Tip('Click on the box to configure the measuring device dynamics.',
                                 WIDTH, ttwidth, TITLE, 'Measuring Device',DURATION, ttduration,
                                 SHADOW, true, FADEIN, 300, FADEOUT, 300, 
                                 STICKY, 0, OFFSETY, -10, DELAY, ttdelay)">
                        </div>
                        <div id="fcebox" class="component" onclick="fcemenu();"
                             onmouseover="Tip('Click on the box to configure the dynamics of the \
                                Final Control Element.',
                                 WIDTH, ttwidth, TITLE, 'Final Control Element',DURATION, ttduration,
                                 SHADOW, true, FADEIN, 300, FADEOUT, ttdelay, 
                                 STICKY, 0, OFFSETY, -10, DELAY, 1200)">
                        </div>
                        <!--Levels (Water)-->
                        <div id="level1">
                        </div>
                        <div id="level2">
                        </div>
                        <!--Image: Tanks and Controller-->
                        <div id="flowImg">
                            <img src="../images/ct.png" alt="Flowchart is missing" id="tanksimg" name="flowchart" >
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer" id="footer">
                <!-- -->  <? include('../footer.php') ?>
            </div>
        </div>
    </body>
</html>
