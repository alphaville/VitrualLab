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
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=0">
        <meta http-equiv="Expires" content="0">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >        
        <link rel="stylesheet" type="text/css" href="../style.css" >
        <link rel="stylesheet" type="text/css" href="./style-tanks.css" >
        <script type="text/javascript" src="../tooltip/script.js"></script>
        <script type='text/javascript' src="../chung.js"></script>
        <script type='text/javascript' src="../ga.js"></script>
        <script type='text/javascript' src="./tanks.js"></script>
        <link rel="shortcut icon" href="/vlab/favicon.ico" type="image/x-icon" >
    </head>
    <body id="body" onload="randomizeInitialLevels();" >
        <script type='text/javascript' src="../wz_tooltip.js"></script>
        <script type='text/javascript' src="../tip_balloon.js"></script>
        <?
        include('../global.php');
        ?>
        <div id="wrap">
            <div id="background">
                <img src="../images/background.jpg" class="stretch" alt="" >
            </div>
            <div id="leftcolumn">
                <!-- LEFT COLUMN -->
                <? include('../sidebar.php');
                ?>
            </div>
            <div id="rightcolumn">
                <div id="rightmenu">
                    <!--  **** PID Menu **** -->
                    <div id="pidmenu" class="rmenu">
                        <div id="close_pid" class="closeimg">
                            <img src="../images/close.png" onclick="pidmenuclose();">
                        </div>
                        <em><u>PID Controller</u></em>
                        <div style="height:10px">
                        </div>
                        <table>
                            <colgroup>
                                <col width="50px">
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
                            <img src="../images/close.png"  onclick="measmenuclose();">
                        </div>
                        <em><u>Measuring Device</u></em>
                        <div style="height:10px">
                        </div>
                        <table>
                            <colgroup>
                                <col width="50px">
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
                            <img src="../images/close.png"  onclick="fcemenuclose();">
                        </div>
                        <em><u>Final Control Element</u></em>
                        <div style="height:10px">
                        </div>
                        <table>
                            <colgroup>
                                <col width="50px">
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
                        <span class="navLink" onmouseover="highlight(this);" onmouseout="dehighlight(this);">Back to Main</span>
                    </a>
                </div>


                <div id="centercolumn">                    
                    <table>
                        <colgroup>
                            <col style="width:100%">
                            <col>
                        </colgroup>
                        <tr>
                            <td>
                                <b style="font-size: xx-large">Virtual Lab</b>
                            </td>
                            <td>
                                <img id="infoimg" src="../images/info.png" width="45px"
                                     onmouseover="toggleFX();" onmouseout="toggleNoFX();"
                                     onclick="newPopup('./help.html');">
                            </td>
                        </tr>
                    </table>


                    <h3>
                        Coupled Tanks &amp; PID Controller 
                    </h3>
                    <!--Floating Messages-->
                    <div id="experiment">
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
                        <div id="pid" class="component hotspot" onclick="pidmenu();" 
                             onmouseover="Tip('Click on the box to configure the PID controller',
                                 WIDTH, ttwidth, TITLE, 'Controller',DURATION, ttduration,
                                 SHADOW, true, FADEIN, 300, FADEOUT, 300, 
                                 STICKY, 0, OFFSETY, -10, DELAY, ttdelay)">
                        </div>
                        <div id="measuringdev" class="component hotspot" onclick="measmenu();"
                             onmouseover="Tip('Click on the box to configure the measuring device dynamics.',
                                 WIDTH, ttwidth, TITLE, 'Measuring Device',DURATION, ttduration,
                                 SHADOW, true, FADEIN, 300, FADEOUT, 300, 
                                 STICKY, 0, OFFSETY, -10, DELAY, ttdelay)">
                        </div>
                        <div id="fcebox" class="component hotspot" onclick="fcemenu();"
                             onmouseover="Tip('Click on the box to configure the dynamics of the \
                                Final Control Element.',
                                 WIDTH, ttwidth, TITLE, 'Final Control Element',DURATION, ttduration,
                                 SHADOW, true, FADEIN, 300, FADEOUT, ttdelay, 
                                 STICKY, 0, OFFSETY, -10, DELAY, 1200)">
                        </div>
                        <!--Levels (Water)-->
                        <div id="level1" onclick="doMove();" style="cursor:pointer;">
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
                <!-- -->  <? include('../footer.php')
                ?>
            </div>
        </div>
    </body>
</html>
