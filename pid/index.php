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
    <head>
        <title>Virtual Lab - PID Control</title>
        <meta name="keywords" content="Automatic Control Lab, Virtual Lab, Automatic Control Playground" >
        <meta name="description" content="Online automatic control lab." >
        <meta name="author" content="Pantelis Sopasakis">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
        <link rel="stylesheet" type="text/css" href="../tooltip/style.css" >
        <link rel="stylesheet" type="text/css" href="../style.css" >
        <link rel="stylesheet" type="text/css" href="./style-pid.css" >
        <script type="text/javascript" src="../tooltip/script.js"></script>
        <script type='text/javascript' src="../chung.js"></script>
        <script type='text/javascript' src="../ga.js"></script>   
        <script type='text/javascript' src="/flot/jquery.min.js"></script>
        <script type='text/javascript' src="/flot/jquery.flot.min.js"></script>
        <script type='text/javascript' src="/flot/jquery.flot.selection.min.js"></script>
        <link rel="shortcut icon" href="/vlab/favicon.ico" type="image/x-icon" >   
        <link href="/rss/feed.php" rel="alternate" type="application/rss+xml" title="RSS 2.0" />
        <link href="/rss/feed.php" rel="alternate" type="application/atom+xml" title="Atom 1.0" />
    </head>

    <body id="body" onload="loadMe();">        
        <?
        include('../global.php');
        include('./constants.php');
        if ($_POST == NULL) {
            $open = 0;
            $kcval = 1;
            $tival = 'infty';
            $tdval = 0;
            $psval = "[1]";
            $qsval = "[2   7   9   5   1]";
            $delayval = 0.0;
            $amplitude = 1;
            $selectInputSignal = "1";
            $freq = 100;
            $bode = "1";
            $simpoints = "auto";
            $horizon = "auto";
            $axes = "auto";
        }
        $image = $open == "1" ? 'PIDS2.png' : 'PIDS.png';
        ?>
        <div id="wrap">
            <div id="background">
                <img src="../images/background.jpg" class="stretch" alt="" >
            </div>
            <div id="leftcolumn">
                <!-- LEFT COLUMN -->
                <? include('../sidebar.php'); ?>
                <div class="cl"></div>
                <div class="news">
                    <div id="leftsb_exrecise_pid" style="margin-left: 3px">
                        <p align="justify">This virtual experiment allows the user to tailor
                            their own closed-loop system by using customizable components
                            and get the time response of the systems following an impulse,
                            a step or a harmonic excitation. </p>
                    </div>
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
            <div id="rightcolumn">
                <!-- RIGHT COLUMN -->	
            </div>
            <div id="container">
                <div id="nav">
                    <a href=".." style="text-decoration:none">
                        <span class="navLink" onmouseover="highlight(this);" onmouseout="dehighlight(this);">Back to Main</span></a>
                </div>
                <div id="centercolumn">
                    <h1>
                        Virtual Lab 
                    </h1>
                    <h3>
                        System with PID Controller 
                    </h3>
                    <div id="scopeMessage" class="smallTip">
                        <a href="javascript:newPopup('./help.html');" id="scopeLink">Read First: Scope of the exercise</a>
                    </div>
                    <div id="flowImg">
                        <a href="<? echo $image; ?>" target="_blank" id="flowcharthref"><span class="hotspot" 
                                                                                              onmouseover="tooltip.show('Click to open in new tab.');" onmouseout="tooltip.hide();" style="border-bottom:0px">
                                <img src="<? echo $image; ?>" alt="Flowchart is missing" id="flowchart" name="flowchart">
                            </span></a>
                    </div>
                    <p id="message">
                        Modify the values of the following parameters and hit <a href="#sb" onmouseover="highlightButton();" onmouseout="dehighlightButton();">Run</a> to start the simulation. Place the mouse over each parameter to read a relevant explanation. 
                    </p>
                    <form method="POST" action="#simulations">
                        <input type="hidden" value="<? echo htmlspecialchars(session_id()); ?>" name="session_id">
                        <? include('main_table.php'); ?>
                        <div class="smallTip">
                            <a style="color:blue;cursor:pointer" onclick="showAdvanced();">
                                <span id="advancedOptionsText">Show Advanced Options</span></a>
                        </div>
                        <? include('advanced_options.php')
                        ?>
                        <div class="cl">
                        </div>
                        <table style="vertical-align: middle">
                            <TR>
                                <TD>                                    
                                    <input type="button" value="Simulate" id="sb" onclick="run_engine();">
                                </TD>
                                <td>
                                    <img src="../images/arrow.png" id="exclamation" alt="<-- Click Here">
                                </td>
                                <td>
                                    <span id="pleasewait">
                                        <!-- Credit goes to http://ajaxload.info/ -->
                                        <img src="../images/loading.gif"  alt="Please Wait!" title="loading..."> 
                                        <em><br>Loading, please wait...</em>                                        
                                    </span>
                                </td>
                            </TR>
                        </table>
                    </form>
                    <div id="response_results" style="display:none">
                        <div id="placeholder" style="width:95%;height:300px;margin-left:20px;margin-top:20px"></div>
                        <p id="hoverdata" style="font-size: smaller;font-style: italic">Position of the mouse: 
                            (
                            <span id="x">0</span>, 
                            <span id="y">0</span>).
                        </p>                        
                        <div id="bode_mag" style="width:95%;height:300px;margin-left:20px;margin-top:20px"></div>
                    </div>
                </div>
                <div class="footer" id="footer">
                    <? include('../footer.php') ?>
                </div>
            </div>
        </div>
        <!-- Piwik -->
        <script type="text/javascript">
            var pkBaseURL = (("https:" == document.location.protocol) ? "https://vlab.mooo.info/adm1n/piwik/" : "http://vlab.mooo.info/adm1n/piwik/");
            document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
        </script>
        <script type="text/javascript">
            try {
                var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
                piwikTracker.trackPageView();
                piwikTracker.enableLinkTracking();
            } catch( err ) {}
        </script>
        <noscript>
        <p><img src="http://vlab.mooo.info/adm1n/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p>
        </noscript>
        <!-- End Piwik Tracking Code -->
    </body>
</html>