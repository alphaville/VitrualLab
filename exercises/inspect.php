<?php
include("../global.php");
require_once("../database.php");
require_once("./Exercise.php");
require_once("./Status.php");

doStartSession();

$lang = isset($_GET['lang'])?$_GET['lang']:null;
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

$xrc = Exercise::fetchExerciseByID($exercise_id);
if (strcmp($un,$xrc->getUser_id())!=0){
    die('<!DOCTYPE html><html><body><span style="color:red"><h1>Hahaha!</h1></span>
        <p><em>Wow! What a hacker! Is this all you can do?</em></p></body></html>');
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd" 
    >    
<html lang="<?= $lang; ?>"> 
    <head>
        <title>VLab - Ex. <?=$exercise_id?></title>
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
                        include("../loginHeader.php");
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
                                        <colgroup>
                                            <col width="100">
                                            <col>
                                        </colgroup>
                                        <tr>
                                            <td>Exercise ID</td><td><?="<a href=\"\">$exercise_id</a>"; ?></td>
                                        </tr>
                                        <tr>
                                            <td>JSON Format</td><td><?="<a href=\"item.php?id=$exercise_id&user_id=$un\">Download</a>"; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Author</td><td><?="<a href=\"/login/profile.php\">$fn $ln</a>"; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Type</td><td><?="<a href=\"/tuning\">Tuning Exercise</a>"; ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>   
                    </div>
                    <div class="cl"></div>
                    <div style="font-size: smaller">
                        <b>Submission Information</b>
                        <table>
                            <colgroup>
                                <col width="100">
                                <col>
                            </colgroup>
                            <tr>
                                <td>Status</td><td><?= $xrc->getStatus()->getStatusText(); ?></td>
                            </tr>
                            <tr>
                                <td>Created</td><td><?= $xrc->getCreation_date(); ?></td>
                            </tr>
                            <tr>
                                <td>Last Updated</td><td><?= $xrc->getLast_update_time(); ?></td>
                            </tr>
                            <tr>
                                <td>Submitted</td><td><?= $xrc->getSumbission_time(); ?></td>
                            </tr>
                        </table>                                
                    </div>
                    <div style="font-size: smaller;margin-top: 20px">
                        <b>Evaluation Information</b>
                        <table>
                            <colgroup>
                                <col width="100">
                                <col>
                            </colgroup>
                            <tr>
                                <td>Mark</td><td><? echo $xrc->getMark(); ?></td>
                            </tr>
                            <tr>
                                <td>Comments</td><td><? echo $xrc->getComments(); ?></td>
                            </tr>
                        </table>                                
                    </div>
                </div>
            </div>
            <div class="footer" id="footer">
                <? include('/footer.php') ?>
            </div>
        </div>
    </body>
</html>
