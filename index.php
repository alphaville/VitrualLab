<?php
session_start();
if (empty($_SESSION['count'])) {
    $_SESSION['count'] = 1;
} else {
    $_SESSION['count']++;
}
include("./global.php");
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
        <script type='text/javascript' src="./chung.js"></script>
        <script type='text/javascript' src="./ga.js"></script>
        <script type='text/javascript' src="./jquery.js"></script>
        <link rel="stylesheet" type="text/css" href="./style.css" >
        <link rel="shortcut icon" href="/vlab/favicon.ico" type="image/x-icon" />
    </head>
    <body id="body" onload="loadMe();">
        <div id="wrap">
            <div id="background">
                <img src="./images/background.jpg" class="stretch" alt="" >
            </div>
            <div id="leftcolumn">                
                <? include('./sidebar.php'); ?>
                <div class="left-text">
                    <div class="news"  lang="<? echo $lang; ?>">
                        <span style="font: bolder small times"><? echo $about_title; ?></span>
                        <p style="margin-top:5px;" id="left_paragraph" align="justify">
                            <? echo $about_vlab_text; ?>                            
                        </p>
                        <div id="elearning">
                            <div align="center">                            
                                <img src="./images/books.png" alt="octave.png" width="130">
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
                        echo'Dear <a href="./login/profile.php" style="text-decoration:none">' . $first . '</a>, 
                        you are logged in. <a href="./login/logout.php" style="text-decoration:none">Logout</a>.';
                    } else {
                        echo $welcome . ' <a href="./login/profile.php" style="text-decoration:none">Guest</a>.
                        ' . $youmay . ' <a href="./login" style="text-decoration:none">Login</a>.';
                    }
                    ?>
                </div>
                <div id="menubar" align="center">
                    <span class="menuoption"><a href="/?lang=<? echo $lang; ?>"><? echo $home_page; ?></a></span> | 
                    <span class="menuoption"><a href=""><? echo $experiments; ?></a></span> | 
                    <span class="menuoption"><a href="https://github.com/alphaville/VitrualLab/issues"><? echo $report_bug; ?></a></span> | 
                    <span class="menuoption"><a href="/faq?lang=<? echo $lang; ?>" title="Frequently Asked Questions"><? echo $faq; ?></a></span>
                </div>
                <div id="centercolumn" lang="<? echo $lang; ?>">
                    <h1 lang="<? echo $lang; ?>"><? echo $header; ?></h1>
                    <h3  lang="<? echo $lang; ?>"><? echo $subheader; ?></h3>
                    <div>
                        <p align="justify" lang="<? echo $lang; ?>"><? echo $p1_1; ?></p>
                        <p align="justify" lang="<? echo $lang; ?>"><? echo $p1_2; ?></p>
                        <div align="center">
                            <img src="./images/2tanks_ss.png" height="250" alt="screenshot - 1">
                        </div>
                        <p align="justify" lang="<? echo $lang; ?>"><? echo $p1_3; ?></p>
                        <div align="center">
                            <img src="./images/ss_menu.png" height="100" alt="screenshot - 1">
                        </div>
                    </div>
                    <div class="cl"></div>
                    <div class="cl"></div>
                    <div>
                        <h3><? echo $evaluation_title; ?></h3>
                        <p align="justify">
                            <? echo $evaluation_p; ?>
                        </p>
                    </div>
                    <div class="cl"></div>
                    <div class="cl"></div>
                    <div>
                        <h3><?echo $about_header;?></h3>
                        <p align="justify">
                            <? echo $about_p1;?>
                        </p>
                        <div align="center">
                            <img src="./images/ss_design.png" height="250" alt="screenshot - 1">
                        </div>
                        <p align="justify">
                            <?echo $about_p2;?>
                        </p>                                                
                        <p align="justify">
                            <?echo $about_p3;?>
                        </p>                                                
                    </div>

                    <div class="cl"></div>
                    <div class="cl"></div>

                    <div>
                        <h3>
                            <?echo $list_experiments_header;?>
                        </h3>
                        <div id="scopeMessage" >
                            <ol>
                                <li>
                                    <a href="./p"><?echo $experiment_1_title;?></a>: <?echo $experiment_1;?>

                                </li>
                                <li>
                                    <a href="./pid"><?echo $experiment_2_title;?></a>: <?echo $experiment_2;?>
                                </li>
                                <li>
                                    <a href="./tanks"><?echo $experiment_3_title;?></a>: <?echo $experiment_3;?>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer" id="footer">
                <? include('./footer.php') ?>
            </div>
        </div>
    </body>
</html>
