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
            $kpval = 5;
            $tival = 0.6;
            $tdval = 0.3;
            $psval = "[1]";
            $qsval = "[1 1 1]";
            $delayval = 0;
            $amplitude = 1;
            $selectInputSignal = "1";
            $freq = 100;
            $bode = "1";
            $simpoints = "auto";
            $horizon = "auto";
            $axes = "auto";
        } else {
            $open = $_POST["open"] == "on" ? 1 : 0;
            $kpval = $_POST["Kp"];
            $tival = $_POST["ti"];
            $tdval = $_POST["td"];
            $psval = $_POST["ps"];
            $qsval = $_POST["qs"];
            $delayval = $_POST["delay"];
            $bode = $_POST["bode"] == "on" ? 1 : 0;
            $nyquist = $_POST["nyquist"] == "on" ? 1 : 0;
            $amplitude = $_POST["amplitude"];
            $selectInputSignal = $_POST["selectInputSignal"];
            $freq = $_POST["freq"];
            $simpoints = $_POST["simpoints"];
            $horizon = $_POST["horizon"];
            $axes = $_POST["axes"];
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
                                    <input type="submit" value="Run" id="sb" onclick="holdit();">
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
                    <?
                    if ($_POST != null) {
                        $sid = $_POST["session_id"];
                        $command = './runPIDCtrl ' . escapeshellarg($kpval) .
                                " " . escapeshellarg($tival) .
                                " " . escapeshellarg($tdval) .
                                " " . escapeshellarg($psval) .
                                " " . escapeshellarg($qsval) .
                                ' ' . escapeshellarg($delayval) .
                                ' ' . escapeshellarg($open) .
                                ' ' . escapeshellarg($bode) .
                                ' ' . escapeshellarg($nyquist) .
                                ' ' . escapeshellarg($selectInputSignal) .
                                ' ' . escapeshellarg($amplitude) .
                                ' ' . escapeshellarg($freq) .
                                ' "./images/' . $sid . '"' .
                                ' ' . escapeshellarg($simpoints) .
                                ' ' . escapeshellarg($horizon) . ' 2> /dev/stdout';

                        $retval = exec($command, $ret);
                        $everythingOK = 0;

                        echo '<div class="results" id="simulation-results">
		<label id="simulations" for="results">
		<h3>Results</h3>
		</label>
		';
                        $error = '';
                        for ($i = 0; $i < count($ret) - 1; $i++) {
                            $errorTag = substr($ret[$i], 0, 5);
                            $flag1 = strcmp(substr($ret[$i], 0, 5), "error") == 0;
                            $flag2 = strpos($ret[$i], 'ion') === false;
                            if ($flag1 && $flag2) {
                                $everythingOK++;
                                $error = $error . '<span class="error">' . $ret[$i] . '</span><br/>';
                            }
                        }

                        if ($everythingOK > 0) {
                            echo ($everythingOK) . ' errors occured';
                            echo '<div id="errors">' . $error . '</div>';
                        }

                        if ($everythingOK == 0) {
                            $bode_jpg = "./images/" . $sid . "bode.jpg";
                            $nyq_jpg = "./images/" . $sid . "nyq.jpg";
                            $resp_jpg = "./images/" . $sid . "resp.jpg";

                            $i = 1;
                            // Always output the response plot (default)!
                            echo '<div class="nyqBox"><img class="nyq" src="' . $resp_jpg . '" id="respplot"><label id="response_plot">Figure ' . ($i++) . ' : Response Plot</label></div>';
                            if ($bode) {
                                echo '<div class="bodeBox"><img class="bode" src="' . $bode_jpg . '" id="bodeplot"><label id="bode_plot" for="bodeplot">Figure ' . ($i++) . ' : Bode Plot</label></div>';
                            }
                            if ($nyquist) {
                                echo '<div class="nyqBox"><img class="nyq" src="' . $nyq_jpg . '" id="nyqplot"><label id="nyquist_plot" for="nyqplot">Figure ' . ($i++) . ' : Nyquist Plot</label></div>';
                            }
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
            <div class="footer" id="footer">
                <? include('../footer.php') ?>
            </div>
        </div>
        <!-- Piwik -->
        <script type="text/javascript">
            var pkBaseURL = (("https:" == document.location.protocol) ? "https://vlab.mooo.info/adm1n/piwik/" : "http://vlab.mooo.info/adm1n/piwik/");
            document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
        </script><script type="text/javascript">
            try {
                var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
                piwikTracker.trackPageView();
                piwikTracker.enableLinkTracking();
            } catch( err ) {}
        </script><noscript><p><img src="http://vlab.mooo.info/adm1n/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>
        <!-- End Piwik Tracking Code -->
    </body>
</html>