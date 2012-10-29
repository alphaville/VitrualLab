<?php
include('../global.php');
include("../database.php");

doStartSession();

$un = $_COOKIE['id'];
$token = $_COOKIE['token'];
authoriseUser($un, $token, true, 10, 'rss');



?>
<!DOCTYPE html>
<html>
    <head>
        <title>News Page</title>
        <meta name="robots" content="noindex,nofollow">
        <meta name="keywords" content="Automatic Control Lab, Virtual Lab, Automatic Control Playground" >
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="../tooltip/style.css" >    
        <link rel="stylesheet" type="text/css" href="../style.css" > 
        <link rel="stylesheet" type="text/css" href="./style-account.css" > 
        <script type='text/javascript' src='../chung.js' ></script>
        <script type='text/javascript' src='./account_utils.js' ></script>
        <script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
        <link rel="shortcut icon" href="/vlab/favicon.ico" type="image/x-icon" >
        <link href="<?echo $FEED_RSS;?>" rel="alternate" type="application/rss+xml" title="RSS 2.0" >
        <link href="<?echo $FEED_ATOM;?>" rel="alternate" type="application/atom+xml" title="Atom 1.0" >
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
                <div id="nav">
                    <a href=".." style="text-decoration:none"><span class="navLink" onmouseover="highlight(this);" onmouseout="dehighlight(this);">Back to Main</span></a>
                </div>
                <div id="centercolumn">

                    <?
                    if ($_POST) {
                        $con = connect() or die('Could not connect to the database!');
                        if ($con) {
                            $rsslink = $_POST['rsslink'];
                            if (!$rsslink | $rsslink == "") {
                                $rsslink = $__URL__;
                            }
                            $lang = $_POST['rsslang'];
                            $rsslink = mysql_real_escape_string($rsslink);
                            $query = "INSERT INTO `rss` (`title`,`link`, 
                                `guid`, `author`, `description`, `lang`, `user_id`) VALUES 
                                ('" . mysql_real_escape_string($_POST["rsstitle"]) . "', 
                                    '" . $rsslink . "', 
                                    '" . mysql_real_escape_string($_POST['rssguid']) . "',
                                        '" . mysql_real_escape_string($_POST['rssauthor']) . "', 
                                        '" . $_POST['rssdescription'] . "', '" .
                                    mysql_real_escape_string($lang) . "', '$un')";
                            mysql_query($query);
                        }
                        mysql_close($con);
                        echo '<h1>News Added!</h1>';
                    } else {
                        ?>

                        <h1>
                            Add News
                        </h1>                    
                        <div id="account-creation-form" onsubmit="return checkAllAccountFields();">
                            <form action="" method="POST">
                                <div id="login-forms" style="font-style: italic" >
                                    <input name="rssguid" id="rssguid" type="hidden" value="<? echo genRandomString(32); ?>">
                                    <input name="rssauthor" id="rssauthor" type="hidden" value="<? echo $_COOKIE["fn"] . " " . $_COOKIE["ln"]; ?>">
                                    <table cellpadding="3">
                                        <colgroup>
                                            <col>
                                            <col>
                                        </colgroup>
                                        <tr>
                                            <td>Title</td>
                                            <td><input type="text" name="rsstitle" id="rsstitle" style="width: 250px"> <sup><small><span style="color: deeppink">*</span></small></sup></td>
                                        </tr>
                                        <tr>
                                            <td>Link</td>
                                            <td><input name="rsslink" type="text" id="rsslink"  style="width: 250px"> <sup><small><span style="color: deeppink">*</span></small></sup></td>
                                        </tr>
                                        <tr>
                                            <td>Language</td>
                                            <td><select name="rsslang" id="rsslang">
                                                    <option value="en">English </option>
                                                    <option value="el">Ελληνικά </option>
                                                </select></td>                                           
                                        </tr>                                
                                    </table>                                                                            
                                </div>
                                <div class="cl"></div>
                                <div id="composer" style="margin-top:15px;margin-left:10px;margin-right:10px">
                                    <textarea cols="80" id="editor1" name="rssdescription" rows="10"><? echo htmlentities("<p>Type your <b>news</b> right here.</p>"); ?></textarea>
                                </div>                        
                                <script type="text/javascript">
                                    CKEDITOR.replace( 'editor1');
                                </script>
                                <div class="cl"></div>
                                <input type="submit" value="Submit">
                            </form>
                        </div>
                    <? } ?>
                </div>
            </div>
            <div class="footer" id="footer">
                <? include('../footer.php') ?>
            </div>
        </div>
    </body>
</html>