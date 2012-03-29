<?php
session_start();
if (empty($_SESSION['count'])) {
    $_SESSION['count'] = 1;
} else {
    $_SESSION['count']++;
}
setcookie("fn", "", time() - 3600, "/");
setcookie("ln", "", time() - 3600, "/");
setcookie("email", "", time() - 3600, "/");
setcookie("auth", "", time() - 3600, "/");
setcookie("hash", "", time() - 3600, "/");
setcookie("id", "", time() - 3600, "/");
setcookie("token", "", time() - 3600, "/");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd" 
    >
<html>
    <head>
        <title>Logout Page</title>
        <meta name="keywords" content="Automatic Control Lab, Virtual Lab, Automatic Control Playground" >
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="../tooltip/style.css" />    
        <link rel="stylesheet" type="text/css" href="./style-p.css" >
        <link rel="stylesheet" type="text/css" href="../style.css" /> 
        <script type='text/javascript' src='../chung.js' ></script>
        <script type='text/javascript'></script>
        <link rel="shortcut icon" href="/vlab/favicon.ico" type="image/x-icon" >
    </head>
    <body id="body" onload="loadMe();">    
        <? include('../global.php'); ?>
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
                <!-- RIGHT COLUMN -->	
            </div>
            <div id="container">
                <div id="nav">
                    <a href=".." style="text-decoration:none"><span class="navLink" onmouseover="highlight(this);" onmouseout="dehighlight(this);">Back to Main</span></a>
                </div>
                <div id="centercolumn">
                    <h1>
                        Logout Page
                    </h1>
                    <h3>
                        Your Profile
                    </h3>
                    <div>You are now logged out! Thanks for using vlab.mooo.info.</div>
                </div>
            </div>
            <div class="footer" id="footer">
                <? include('../footer.php') ?>
            </div>
        </div>
    </body>
</html>