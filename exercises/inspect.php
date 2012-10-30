<?php
include("../global.php");
include("../database.php");

doStartSession();

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
$exercise_id = $_GET['id'];

$un = $_COOKIE['id'];
$fn = $_COOKIE['fn'];
$ln = $_COOKIE['ln'];
$token = $_COOKIE['token'];
authoriseUser($un, $token, false, -1, 'login/composer.php');
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
        <script type='text/javascript' src="/ga.js"></script>
        <script type='text/javascript' src="/jquery.js"></script>
        <link rel="stylesheet" type="text/css" href="/style.css" >
        <link rel="shortcut icon" href="/vlab/favicon.ico" type="image/x-icon" />
        <link href="<? echo $FEED_RSS; ?>" rel="alternate" type="application/rss+xml" title="RSS 2.0" >
        <link href="<? echo $FEED_ATOM; ?>" rel="alternate" type="application/atom+xml" title="Atom 1.0" >
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
                <div id="login">
                    <div id="language" style="float:right">
                        <a href="?lang=en">English</a> | <a href="?lang=el">Ελληνικά</a>
                    </div>
                    <?
                    $first = $_COOKIE["fn"];
                    if (isset($first)) {
                        echo "Dear <a href=\"/login/profile.php\" style=\"text-decoration:none\">$first</a>, 
                        you are logged in. <a href=\"./login/logout.php\" style=\"text-decoration:none\">Logout</a>.<br/>
                        <a href=\"/login/profile.php\" style=\"text-decoration:none\" title=\"My Profile\"><img src=\"/images/im-user.png\"></img></a>
                        <a href=\"/exercises/list.php\" style=\"text-decoration:none\" title=\"My Exercises\"><img src=\"/images/folder-txt.png\"></img></a>
                        <a href=\"/login/my_messages.php\" style=\"text-decoration:none\" title=\"Incoming Messages\"><img src=\"/images/mail-mark-read.png\"></img></a>
                        <a href=\"/login/composer.php\" style=\"text-decoration:none\" title=\"Compose Message\"><img src=\"/images/mail-message-new.png\"></img></a>";
                    } else {
                        echo $welcome . ' <a href="/login/profile.php" style="text-decoration:none">Guest</a>.
                        ' . $youmay . ' <a href="/login" style="text-decoration:none">Login</a>.';
                    }
                    ?>
                </div>
                <div id="centercolumn" lang="<? echo $lang; ?>">
                    <div style="font-size: smaller"> 
                        <table>
                            <tr>
                                <td><img src="/images/notebook.png"  alt="" ></td>
                                <td><b>General Information</b><br/><br/>
                                    <table>
                                        <tr>
                                            <td>Exercise ID</td><td><? echo "<a href=\"\">$exercise_id</a>"; ?></td>
                                        </tr>
                                        <tr>
                                            <td>JSON Format</td><td><? echo "<a href=\"item.php?id=$exercise_id&user_id=$un\">Download</a>"; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Author</td><td><? echo "<a href=\"/login/profile.php\">$fn $ln</a>"; ?></td>
                                        </tr>
                                    </table>                                
                                </td>
                            </tr>
                        </table>   
                    </div>
                    <div class="cl"></div>
                    <div style="font-size: smaller">
                        <b>Submission Information</b>
                    </div>
                </div>
            </div>
            <div class="footer" id="footer">
                <? include('/footer.php') ?>
            </div>
        </div>
    </body>
</html>
