<?php
include('../global.php');
include('../database.php');
session_destroy();

$logging_out_user = $_COOKIE['id'];
clearToken($logging_out_user);

setcookie("fn", "", time() - 3600, "/");
setcookie("ln", "", time() - 3600, "/");
setcookie("email", "", time() - 3600, "/");
setcookie("auth", "", time() - 3600, "/");
setcookie("hash", "", time() - 3600, "/");
setcookie("id", "", time() - 3600, "/");
setcookie("token", "", time() - 3600, "/");

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Logout Page</title>
        <meta name="keywords" content="<? echo $__KEYWORDS__; ?>" >
        <meta name="robots" content="noindex,nofollow">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="../tooltip/style.css" >    
        <link rel="stylesheet" type="text/css" href="./style-p.css" >
        <link rel="stylesheet" type="text/css" href="../style.css" > 
        <script type='text/javascript' src='../chung.js' ></script>
        <script type='text/javascript'></script>
        <link rel="shortcut icon" href="/vlab/favicon.ico" type="image/x-icon" >
        <link href="<? echo $FEED_RSS; ?>" rel="alternate" type="application/rss+xml" title="RSS 2.0" >
        <link href="<? echo $FEED_ATOM; ?>" rel="alternate" type="application/atom+xml" title="Atom 1.0" >
    </head>
    <body id="body" onload="loadMe();">    
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
                    <a href="/login/index.php" style="text-decoration:none"><span class="navLink" onmouseover="highlight(this);" onmouseout="dehighlight(this);">Login</span></a>
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