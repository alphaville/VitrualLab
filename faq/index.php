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
                    <span class="menuoption"><a href="/?lang=<?echo $lang;?>"><? echo $home_page; ?></a></span> | 
                    <span class="menuoption"><a href=""><? echo $experiments; ?></a></span> | 
                    <span class="menuoption"><a href="https://github.com/alphaville/VitrualLab/issues"><? echo $report_bug; ?></a></span> | 
                    <span class="menuoption"><a href="/faq/index.php?lang=<?echo $lang;?>" title="Frequently Asked Questions"><? echo $faq; ?></a></span>
                </div>
                <div id="centercolumn" lang="<? echo $lang; ?>">
                    <h1 lang="<? echo $lang; ?>"><? echo $header; ?></h1>
                    <h3  lang="<? echo $lang; ?>"><? echo $subheader; ?></h3>
                    <div>
                        <p align="justify" lang="<? echo $lang; ?>"><? echo $p1_1; ?></p>
                        <p align="justify" lang="<? echo $lang; ?>"><? echo $p1_2; ?></p>
                        <div align="center">
                            <img src="/images/2tanks_ss.png" height="250" alt="screenshot - 1">
                        </div>
                        <p align="justify" lang="<? echo $lang; ?>"><? echo $p1_3; ?></p>
                        <div align="center">
                            <img src="/images/ss_menu.png" height="100" alt="screenshot - 1">
                        </div>
                    </div>

                    <div class="cl"></div>
                    <div class="cl"></div>

                    <div>
                        <h3>Αξιολόγηση των αποτελεσμάτων</h3>
                        <p align="justify">
                            Κάθε φοιτητής μπορεί <a href="./login/">να συνδεθεί στο VLAB</a> 
                            με σκοπό να έχει πρόσβαση
                            στη διαδικασία αξιολόγησης των αποτελεσμάτων του. Μπορείτε να συνδεθείτε
                            είτε χρησιμοποιώντας ένα λογαριασμό που ήδη έχετε στο Google ή το Yahoo ή
                            να δημιουργήσετε ένα λογαριασμό VLAB. Κατόπιν, αφού ολοκληρώσετε μια άσκηση
                            μπορείτε να αποθηκεύσετε προσωρινά τα αποτελέσματα και όταν αποφασίσετε να
                            ολοκληρώσετε την υποβολή των αποτελεσμάτων στο σύστημα. Οι ασκήσεις 
                            βαθμολογούνται κατ'ευθείαν ηλεκτρονικά και ο βαθμός ανακοινώνεται στο χρήστη.
                        </p>
                    </div>

                    <div class="cl"></div>
                    <div class="cl"></div>


                    <div>
                        <h3>Σχετικά με την Εφαρμογή</h3>
                        <p align="justify">
                            Η παρούσα εφαρμογή αναπτύχθηκε στο εργαστήριο Αυτόματης Ρύθμισης και 
                            Πληροφορικής της Σχολή Χημικών Μηχανικών του Ε.Μ.Π. Βασίζεται σε λογισμικό 
                            ανοιχτού κώδικα και διανέμεται επίσης με βάση την άδεια χρήσης και διανομής
                            <a href="http://www.gnu.org/copyleft/gpl.html">GNU GPL v.3</a> (CLeft). 
                            Ο κώδικας της εφαρμογής περιλαμβάνει <a href="http://www.php.net/">PHP</a>, 
                            <a href="http://www.w3.org/TR/html401/">HTML4.01</a>, 
                            <a href="http://www.w3.org/Style/CSS/">CSS3</a>, 
                            <a href="http://www.w3schools.com/js/">JavaScript</a>, 
                            <a href="http://www.gnu.org/software/octave/">Octave</a> και 
                            <a href="http://www.mysql.com/">MySQL</a>. Επίσης χρησιμοποιεί την 
                            τεχνολογία <a href="http://http://openid.net/">OpenID</a> και τα API των Twitter και Facebook.
                        </p>
                        <div align="center">
                            <img src="/images/ss_design.png" height="250" alt="screenshot - 1">
                        </div>
                        <p align="justify">
                            Καταβάλλουμε προσπάθεια ώστε το VLAB να είναι συμβατό με όλους
                            τους σύγχρονους φυλλομετρητές όπως για παράδειγμα ο Mozilla Firefox,
                            o Google Chrome και ο Opera. Απαιτείται ωστόσο να έχετε ενεργοποιήσει
                            την <b>αποδοχή cookies</b>.
                        </p>                                                
                        <p align="justify">
                            Ο πηγαίος κώδικας της εφαρμογής φιλοξενείται στο 
                            <a href="https://github.com/alphaville/VitrualLab">github</a>.                            
                        </p>                                                
                    </div>

                    <div class="cl"></div>
                    <div class="cl"></div>

                    <div>
                        <h3>
                            Λίστα Πειραμάτων
                        </h3>
                        <div id="scopeMessage" >
                            <ol>
                                <li>
                                    <a href="./p">Σύστημα κλειστού βρόγχου με ρυθμιστή P</a> :

                                </li>
                                <li>
                                    <a href="./pid">Σύστημα κλειστού βρόγχου με ρυθμιστή PID</a>
                                </li>
                                <li>
                                    <a href="./tanks">Σύστημα συζευγμένων δεξαμενών με ρυθμιστή PID</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer" id="footer">
                <? include('/footer.php') ?>
            </div>
        </div>
    </body>
</html>
