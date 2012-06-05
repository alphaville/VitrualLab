<?php
session_start();
if (empty($_SESSION['count'])) {
    $_SESSION['count'] = 1;
} else {
    $_SESSION['count']++;
}
include("../global.php");
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
        <link href="/rss/feed.php" rel="alternate" type="application/rss+xml" title="RSS 2.0" />
        <link href="/rss/feed.php" rel="alternate" type="application/atom+xml" title="Atom 1.0" />
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
                        echo'Dear <a href="/login/profile.php" style="text-decoration:none">' . $first . '</a>, 
                        you are logged in. <a href="/login/logout.php" style="text-decoration:none">Logout</a>.';
                    } else {
                        echo $welcome . ' <a href="/login/profile.php" style="text-decoration:none">Guest</a>.
                        ' . $youmay . ' <a href="/login" style="text-decoration:none">Login</a>.';
                    }
                    ?>
                </div>
                <div id="menubar" align="center">
                    <span class="menuoption"><a href="/?lang=<? echo $lang; ?>"><? echo $home_page; ?></a></span> | 
                    <span class="menuoption"><a href=""><? echo $experiments; ?></a></span> | 
                    <span class="menuoption"><a href="https://github.com/alphaville/VitrualLab/issues"><? echo $report_bug; ?></a></span> | 
                    <span class="menuoption"><a href="/faq/index.php?lang=<? echo $lang; ?>" title="Frequently Asked Questions"><? echo $faq; ?></a></span>
                </div>
                <div id="centercolumn" lang="<? echo $lang; ?>">
                    <h1 lang="<? echo $lang; ?>"><? echo $header; ?></h1>
                    <p lang="<? echo $lang; ?>" style="font-size: smaller;font-style: italic"><? echo $subheader; ?></p>
<!--
TODO: Create exercise: Figure + Input Boxes + Save Result
      The result should appear under MyExercises
      
-->
                    
                    <div class="cl"></div>
                    <div class="cl"></div>
                                        
                </div>
            </div>
            <div class="footer" id="footer">
                <? include('/footer.php') ?>
            </div>
        </div>
    </body>
</html>
