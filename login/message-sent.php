<?php
include("../database.php");
if ($_SERVER['REQUEST_METHOD']!="POST"){
    header( 'Location: '.$__BASE_URI.'/index.php' ) ;
    echo '<html><head></head><body>Method not allowed! You are being redirected.</body></html>';    
    die();
}
session_start();
if (empty($_SESSION['count'])) {
    $_SESSION['count'] = 1;
} else {
    $_SESSION['count']++;
}

function getUser() {
    $fn = $_COOKIE["fn"];
    $ln = $_COOKIE["ln"];
    $full_name = $fn . " " . $ln;
    echo '<span id="username"><a href="/login/profile.php">' . $full_name . '</a></span>';
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd" 
    >
<html>
    <head>
        <title>Message Composer</title>
        <meta name="robots" content="noindex,nofollow">
        <meta name="keywords" content="Automatic Control Lab, Virtual Lab, Automatic Control Playground" >
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="../tooltip/style.css" >    
        <link rel="stylesheet" type="text/css" href="./style-p.css" >
        <link rel="stylesheet" type="text/css" href="../style.css" > 
        <script type='text/javascript' src='../chung.js' ></script>
        <script type='text/javascript'></script>
        <script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
        <link rel="shortcut icon" href="/vlab/favicon.ico" type="image/x-icon" >
        <link href="/rss/feed?type=rss" rel="alternate" type="application/rss+xml" title="RSS 2.0" >
        <link href="/rss/feed?type=atom" rel="alternate" type="application/atom+xml" title="Atom 1.0" >
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
                    <a href="my_messages.php" style="text-decoration:none"><span class="navLink" onmouseover="highlight(this);" onmouseout="dehighlight(this);">My Messages</span></a>
                    <a href="profile.php" style="text-decoration:none"><span class="navLink" onmouseover="highlight(this);" onmouseout="dehighlight(this);">My Profile</span></a>
                </div>
                <div id="centercolumn">                                       
                    <div>                        
                        <?
                        $con = connect();
                        if (!$con) {
                            die('MySQL Error : ' . mysql_error());
                        } else {
                            $from = $_POST["un"];
                            $rcpt_to = $_POST["receiver"];
                            $subject = $_POST["subject"];
                            $body = $_POST["editor1"];
                            $inreplyto = $_POST["inreplyto"];
                            if (!$inreplyto){
                                $inreplyto="NULL";
                            }
                            $query = "INSERT INTO `message` (`from`,`rcpt_to`,`subject`,`body`,`inreplyto`) VALUES 
                                ('" . mysql_real_escape_string($from) . "','" . 
                                    mysql_real_escape_string ($rcpt_to) . "','" . 
                                    mysql_real_escape_string ($subject) . "','" . 
                                    mysql_real_escape_string ($body) . "', $inreplyto)";                            
                            if (!mysql_query($query)) {
                                echo '<h3>Message could not be sent</h3>';
                                $errno = mysql_errno();
                                if ($errno==1452){
                                    $explanation = "You are not logged in. Click <a href=\"./index.php\">here</a> to login." ;
                                }else{
                                    $explanation = "Unknown reason. Please check again all fields.";
                                }
                                echo '<p>Reason for failure: ' . $explanation . '</p>Your message is available in the textbox below:';
                            }else{
                                $acquired_id=mysql_insert_id();
                                echo '<h3>Message Sent</h3><p>Your message has been sent and was assigned the ID number : 
                                    <a href="message.php?id='.$acquired_id.'">'.  $acquired_id.'</a></p>';                                
                            }
                            mysql_close($con);
                        }
                        ?>
                    </div>
                </div>     
            </div>
            <div class="footer" id="footer">
                <? include('../footer.php') ?>
            </div>
        </div>
    </body>
</html>