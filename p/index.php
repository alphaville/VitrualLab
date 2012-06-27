<?php
session_start();
if (empty($_SESSION['count'])) {
    $_SESSION['count'] = 1;
} else {
    $_SESSION['count']++;
}
include("../global.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd" 
    >
<html>
    <head>
        <title>Virtual Lab - Step Response of a P-controller</title>
        <meta name="keywords" content="Automatic Control Lab, Virtual Lab, Automatic Control Playground" >
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="../tooltip/style.css" />    
        <link rel="stylesheet" type="text/css" href="./style-p.css" >
        <link rel="stylesheet" type="text/css" href="../style.css" /> 
        <script type='text/javascript' src='../chung.js' ></script>
        <script type='text/javascript'></script>
        <link rel="shortcut icon" href="/vlab/favicon.ico" type="image/x-icon" >
        <link href="<?echo $FEED_RSS;?>" rel="alternate" type="application/rss+xml" title="RSS 2.0" >
        <link href="<?echo $FEED_ATOM;?>" rel="alternate" type="application/atom+xml" title="Atom 1.0" >
    </head>
    <body id="body" onload="loadMe();">    
        <?include('../global.php');?>
        <div id="wrap">
            <div id="background">
                <img src="../images/background.jpg" class="stretch" alt="" >
            </div>
            <div id="leftcolumn">
                <!-- LEFT COLUMN -->
                <? include('../sidebar.php');
                ?>
                <div class="left-text">
                    <div class="news">
                        <h3>Shortcomings of the P-controller</h3>
                        <p id="left_paragraph1" align="justify">
                            P-controllers are pretty simple and easy to design/implement.
                            However they come with serious shortcomings: they create a
                            nonzero deviation from the set-point at equilibrium.
                        </p>
                        <p id="left_paragraph2" align="justify">
                            Change the controller's gain and observe the time-response
                            curve. Would you choose a 
                            very high value for the gain for an application?
                        </p>
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
                <!-- RIGHT COLUMN -->	
            </div>
            <div id="container">
                <div id="nav">
                    <a href=".." style="text-decoration:none"><span class="navLink" onmouseover="highlight(this);" onmouseout="dehighlight(this);">Back to Main</span></a>
                </div>
                <div id="centercolumn">
                    <h1>
                        Virtual Lab 
                    </h1>
                    <h3>
                        System with P Controller 
                    </h3>
                    <div id="scopeMessage" class="smallTip">
                        <a href="javascript:newPopup('./help.html');" id="scopeLink">Read First: Scope of the exercise</a>
                    </div>
                    <div id="flowImg">
                        <a href="PC.jpg" target="_blank" id="flowcharthref"><span class="hotspot" 
        onmouseover="tooltip.show('Click to open in new tab.');" onmouseout="tooltip.hide();" style="border-bottom:0px">
                                <img src="PC.png" alt="Flowchart is missing" id="flowchart" name="flowchart">
                            </span></a>
                    </div>
                    <p id="message">
                        Modify the values of the following parameters and hit 
                        <a href="#sb" onmouseover="highlightButton();" onmouseout="dehighlightButton();">Run</a> 
                        to start the simulation. Place the mouse over each parameter to read a relevant explanation. 
                    </p>


                    <?
                    if ($_POST == NULL) {
                        $kpval = 300;
                    } else {
                        $kpval = $_POST["Kp"];
                    }
                    ?>


                    <form action="#response" method="POST">        
                        <input type="text" value="<? echo $kpval; ?>" name="Kp" id="Kp" onkeyup="return check(this.value);" />
                        <input type="hidden" value="<? echo htmlspecialchars(session_id()); ?>" name="session_id"/>
                        <input type="submit" value="Run" id="sb"/>
                    </form>
                    <?
// Check whether there has been something POSTed...
                    if ($_POST != NULL) {
                        $sid = $_POST["session_id"];
                        $command = "./runController " . escapeshellcmd($_POST["Kp"]) . " ./images/" . $sid;
                        $ret = exec($command, $retval);
                        $img_jpg = "./images/" . $sid . ".jpg";
                        $img_svg = "./images/" . $sid . ".svg";
                        echo '<div id="response">';
                        // echo '<embed src="'.$img_svg.'" type="image/svg+xml" height="350px"/>';
                        echo '<div class="nyqBox">
                               <img id="img" src="' . $img_jpg . '" class="nyq"/>
                              </div>';
                        $ultStateExplanation = '<strong>Ultimate State</strong> is the limit of the state at infinity upon excitation of the system with a step pulse.';
                        $ultimateState = '<span class="hotspot"
   onmouseover="tooltip.show(\'' . $ultStateExplanation . '\');" onmouseout="tooltip.hide();">Ultimate State</span>';
                        echo '<p>' . $ultimateState . ' : <a id="ustate">' . $ret . "</a></p>";
                        echo '<p id="imgformatsParagraph">The image is available in <a href="' . $img_svg . '" target="_blank">SVG</a> and ';
                        echo '<a href="' . $img_jpg . '" target="_blank">JPG</a> formats.</p>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
            <div class="footer" id="footer">
                <? include('../footer.php')
                ?>
            </div>
        </div>
    </body>
</html>
