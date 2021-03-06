<?php
include('../global.php');
include("../database.php");

doStartSession();

$un = $_COOKIE['id'];
$token = $_COOKIE['token'];
authoriseUser($un, $token, false, -1, 'login/composer.php');

$message_id = $_GET['id'];

IHaveReadThisMessage($message_id, $un);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Message Composer</title>
        <meta name="robots" content="noindex,nofollow">
        <meta name="keywords" content="Automatic Control Lab, Virtual Lab, Automatic Control Playground" >
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="../tooltip/style.css" >    
        <link rel="stylesheet" type="text/css" href="../style.css" > 
        <script type='text/javascript' src='../chung.js' ></script>
        <script type='text/javascript'></script>
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
                <div id="login">
                    <?include("../loginHeader.php");?>
                </div>
                <div id="centercolumn">                                                               
                    <h3>Message ID <? echo $message_id != null ? $message_id : 'undefined' ?></h3>
                    <?
                    if ($message_id != null) {
                        $query = "SELECT `from`, `rcpt_to`, `subject`, `body`, `creation_date`, `inreplyto` FROM 
                            `message` WHERE (`from`='" . $un . "' OR `rcpt_to`='" . 
                                $un . "' OR `rcpt_to`='everybody') AND `id`=" . $message_id;
                        $con = connect();
                        if (!$con) {
                            die("MySQL Connctivity Error : " . mysql_error());
                        }
                        $result = mysql_query($query, $con);
                        if ($result) {
                            $row = mysql_fetch_array($result);
                            if ($row) {
                                $from = $row['from'];
                                $rcpt_to = $row['rcpt_to'];
                                $subject = $row['subject'];
                                $body = $row['body'];
                                $creation_date = $row['creation_date'];
                                $inreplyto = $row['inreplyto'];
                            }
                        }
                        mysql_close($con);
                        if ($row) {
                        ?>
                            <div id="message-details">
                                <table cellpadding="5">
                                    <colgroup>
                                        <col width="130">
                                        <col>
                                    </colgroup>
                                    <tbody>
                                        <tr>
                                            <td>
                                                Message ID   
                                            </td>
                                            <td>
                                                <a href="">#<? echo $message_id; ?></a>
                                                <? if ($inreplyto) {
                                                    echo "(In reply to message <a href=\"message.php?id=$inreplyto\">#$inreplyto)</a>";
                                                } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>From</td>
                                            <td><? $fromName = getNameForId($from);
                                                echo $fromName; ?></td>
                                        </tr>
                                        <tr>
                                            <td>To</td>
                                            <td><? echo getNameForId($rcpt_to); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Subject</td>
                                            <td><? echo $subject ? $subject : "No subject"; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Date</td>
                                            <td><? echo $creation_date; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="cl"></div>

                                <div   
                                    style="width: 550px;margin-left: 40px;border:yellowgreen;
                                    padding-top: 12px;padding-left:12px;padding-right:12px;
                                    padding-bottom: 5px;border: 1px dashed #666;">
                                    <label for="msg-body"><strong>Message</strong></label>
                                    <hr>
                                    <span id="msg-body"><? echo $body; ?></span>
                                    <br>
                                    <? $reply_link = "composer.php?what=reply&message_id=" . $message_id . "&inreplyto=" . urlencode($fromName) . "&from=" . $from; ?>
                                        <? if (($un != $from) | $rcpt_to == "everybody") { ?>
                                        <a href="<? echo $reply_link; ?>"><strong>Reply to this message</strong></a>
                                        <? } ?>
                                </div>
                                <div class="cl"></div>
                                <div>
                                    <a href="composer.php">Click here to send another message.</a>
                                </div>
                            </div>
                            <?
                        } else {
                            echo "<p align=\"justify\">Message &#35;" . $message_id . " not found or you are not authorized to access it.</p>";
                        }
                    } else {
                        echo 'Error: Undefined message ID!';
                    }
                    ?>
                </div>     
            </div>
            <div class="footer" id="footer">
                <? include('../footer.php') ?>
            </div>
        </div>
    </body>
</html>