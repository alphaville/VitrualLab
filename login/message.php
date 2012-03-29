<?php
include('../global.php');
include("../database.php");
if (!authorize_user($_COOKIE["id"], $_COOKIE["token"])) {
    header('Location: ' . $__BASE_URI . '/login/index.php');
}
session_start();
if (empty($_SESSION['count'])) {
    $_SESSION['count'] = 1;
} else {
    $_SESSION['count']++;
}
$message_id = $_GET['id'];
$un = $_COOKIE['id'];

function getUser() {
    $fn = $_COOKIE["fn"];
    $ln = $_COOKIE["ln"];
    $full_name = $fn . " " . $ln;
    echo '<span id="username"><a href="/login/profile.php">' . $full_name . '</a></span>';
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>Message Composer</title>
        <meta name="keywords" content="Automatic Control Lab, Virtual Lab, Automatic Control Playground" >
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="../tooltip/style.css" >    
        <link rel="stylesheet" type="text/css" href="../style.css" > 
        <script type='text/javascript' src='../chung.js' ></script>
        <script type='text/javascript'></script>
        <script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
        <link rel="shortcut icon" href="/vlab/favicon.ico" type="image/x-icon" >
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
                    <a href="composer.php" style="text-decoration:none"><span class="navLink" onmouseover="highlight(this);" onmouseout="dehighlight(this);">Send Message</span></a>
                    <a href="profile.php" style="text-decoration:none"><span class="navLink" onmouseover="highlight(this);" onmouseout="dehighlight(this);">Your Profile</span></a>
                    <a href="logout.php" style="text-decoration:none"><span class="navLink" onmouseover="highlight(this);" onmouseout="dehighlight(this);">Logout</span></a>
                </div>
                <div id="centercolumn">                                                               
                    <h3>Message ID <? echo $message_id != null ? $message_id : 'undefined' ?></h3>
                    <?
                    if ($message_id != null) {
                        $query = "SELECT `from`, `rcpt_to`, `subject`, `body`, `creation_date` FROM 
                            `message` WHERE (`from`='" . $un . "' OR `rcpt_to`='".$un."') AND `id`=" . $message_id;
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
                            }
                        }
                        mysql_close($con);
                        if ($row) {
                            ?>
                            <div id="message-details">
                                <table cellpadding="5">
                                    <tbody>
                                        <tr>
                                            <td>
                                                Message ID   
                                            </td>
                                            <td>
                                                <a href=""><? echo $message_id; ?></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>From</td>
                                            <td><? echo getNameForId($from); ?></td>
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