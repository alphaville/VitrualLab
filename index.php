<?php
session_start();
if (empty($_SESSION['count'])) {
    $_SESSION['count'] = 1;
} else {
    $_SESSION['count']++;
}
include("./global.php");
$lang = (isset($_GET)&& isset($_GET['lang']))?$_GET['lang']:null;
// Get the language 
if (is_null($lang)) {
    include('./en.php');
} else {
    $includename = './' . $lang . '.php';
    if (!@include('./' . $lang . '.php')) {
        include('./en.php');
        $lang = "en";
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $lang; ?>">
    <head>
        <title><?= $page_title ?></title>
        <meta name="keywords" content="<?= $__KEYWORDS__; ?>" >
        <meta name="description" content="Online automatic control lab." >
        <meta name="author" content="Pantelis Sopasakis">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
        <script type='text/javascript' src="./chung.js"></script>
        <script type='text/javascript' src="./ga.js"></script>
        <script type='text/javascript' src="./jquery.js"></script>
        <meta name="rights" content="GNU GPL version 3" />
        <link rel="stylesheet" type="text/css" href="./style.css" >
        <link rel="shortcut icon" href="/vlab/favicon.ico" type="image/x-icon" />
        <link href="<?= $FEED_RSS;?>" rel="alternate" type="application/rss+xml" title="RSS 2.0" />
        <link href="<?= $FEED_ATOM;?>" rel="alternate" type="application/atom+xml" title="Atom 1.0" />
    </head>
    <body id="body" onload="loadMe();">        
        <div id="wrap">
            <div id="background">
                <img src="./images/background.jpg" class="stretch" alt="" >
            </div>
            <div id="leftcolumn">                
                <? include('./sidebar.php'); ?>
                <div class="left-text">
                    <div class="news"  lang="<?= $lang; ?>">
                        <span style="font: bolder small times"><? echo $about_title; ?></span>
                        <p style="margin-top:5px;" id="left_paragraph" align="justify">
                            <?= $about_vlab_text; ?>                            
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
                    <?include("./loginHeader.php");?>
                </div>
                <div id="menubar" align="center">
                    <span class="menuoption"><a href="/?lang=<? echo $lang; ?>"><? echo $home_page; ?></a></span> | 
                    <span class="menuoption"><a href="/experiments"><? echo $experiments; ?></a></span> | 
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
                        <h3><? echo $about_header; ?></h3>
                        <p align="justify">
                            <? echo $about_p1; ?>
                        </p>
                        <div align="center">
                            <img src="./images/ss_design.png" height="250" alt="screenshot - 1">
                        </div>
                        <p align="justify">
                            <? echo $about_p2; ?>
                        </p>                                                
                        <p align="justify">
                            <? echo $about_p3; ?>
                        </p>                                                
                    </div>

                    <div class="cl"></div>
                    <div class="cl"></div>

                    <div>
                        <h3>
                            <? echo $list_experiments_header; ?>
                        </h3>
                        <div id="scopeMessage" >
                            <ol>
                                <li>
                                    <a href="./p"><? echo $experiment_1_title; ?></a>: <? echo $experiment_1; ?>

                                </li>
                                <li>
                                    <a href="./pid"><? echo $experiment_2_title; ?></a>: <? echo $experiment_2; ?>
                                </li>
                                <li>
                                    <a href="./tanks"><? echo $experiment_3_title; ?></a>: <? echo $experiment_3; ?>
                                </li>
                                <li>
                                    <a href="./tuning"><? echo $experiment_4_title; ?></a>: <? echo $experiment_4; ?>
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
