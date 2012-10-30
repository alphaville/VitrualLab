<?php
include('../global.php');
include("../database.php");

doStartSession();

// Authorise User...
$un = $_COOKIE["id"];
$token = $_COOKIE["token"];
authoriseUser($un, $token, false, -1);// do not require admin rights
?>
<!DOCTYPE html>
<html>
    <head>
        <title>My Exercises</title>
        <meta name="robots" content="noindex,nofollow">
        <meta name="keywords" content="Automatic Control Lab, Virtual Lab, Automatic Control Playground" >
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="../tooltip/style.css" >    
        <link rel="stylesheet" type="text/css" href="../style.css" > 
        <link rel="stylesheet" type="text/css" href="../fancy_table.css" > 
        <script type='text/javascript' src='../chung.js' ></script>
        <script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
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
                <? include('../sidebar.php'); ?>
            </div>
            <div id="rightcolumn">
                <!-- RIGHT COLUMN -->	
            </div>
            <div id="container">
                <div id="login">
                    <div id="language" style="float:right">
                        <a href="?lang=en">English</a> | <a href="?lang=el">Ελληνικά</a>
                    </div>
                    <?include("../loginHeader.php");?>
                </div>
                <div id="centercolumn">
                    <h3>Profile Parameters</h3>                     
                    <div><img src="../images/editprofile.png" alt="my profile"></div>
                    <table cellspacing="3" style="font-size: small">
                        <tr>
                            <td><b>Username</b></td><td><?echo $un;?></td>
                        </tr>
                        <tr>
                            <?$fn = $_COOKIE['fn'];?>
                            <td><b>First Name</b></td><td><?echo "<input type=\"text\" name=\"fn\" value=\"$fn\"></input>";?></td>
                        </tr>
                        <tr>
                            <?$ln = $_COOKIE['ln'];?>
                            <td><b>Last Name</b></td><td><?echo "<input type=\"text\" name=\"ln\" value=\"$ln\"></input>";?></td>
                        </tr>
                    </table>
                </div>     
            </div>
            <div class="footer" id="footer">
                <? include('../footer.php') ?>
            </div>
        </div>
    </body>
</html>