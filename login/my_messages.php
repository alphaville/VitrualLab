<?php
include('../global.php');
include("../database.php");
if (!authorize_user($_COOKIE["id"], $_COOKIE["token"])) {
    header('Location: ' . $__BASE_URI . '/login/index.php');
    die("You are being redirected...");
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

function utf8_substr($str, $start) {
    preg_match_all("/./u", $str, $ar);

    if (func_num_args() >= 3) {
        $end = func_get_arg(2);
        return join("", array_slice($ar[0], $start, $end));
    } else {
        return join("", array_slice($ar[0], $start));
    }
}

$search_type = $_GET["t"] == "sent" ? "sent" : "received";
$rowsPerPage = 20;
$page = $_GET["page"] != null ? $_GET["page"] : 1;
$page--;
$offset = $page * $rowsPerPage;
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
        <link rel="stylesheet" type="text/css" href="./fancy_table.css" > 
        <script type='text/javascript' src='../chung.js' ></script>
        <script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
        <link rel="shortcut icon" href="/vlab/favicon.ico" type="image/x-icon" >
        <link href="/rss/feed?type=rss" rel="alternate" type="application/rss+xml" title="RSS 2.0" >
        <link href="/rss/feed?type=atom" rel="alternate" type="application/atom+xml" title="Atom 1.0" >
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
                    <a href="profile.php" style="text-decoration:none"><span class="navLink" onmouseover="highlight(this);" onmouseout="dehighlight(this);">My Profile</span></a>                    
                    <? if ($search_type == "received") { ?>
                        <a href="my_messages.php?t=sent" style="text-decoration:none"><span class="navLink" onmouseover="highlight(this);" onmouseout="dehighlight(this);">Sent</span></a>
                    <? } else { ?>
                        <a href="my_messages.php?t=received" style="text-decoration:none"><span class="navLink" onmouseover="highlight(this);" onmouseout="dehighlight(this);">Received</span></a>
                    <? } ?>
                    <a href="logout.php" style="text-decoration:none"><span class="navLink" onmouseover="highlight(this);" onmouseout="dehighlight(this);">Logout</span></a>
                </div>
                <div id="centercolumn">
                    <?
                    if ($search_type == "received") {
                        echo '<h3>My Received Messages</h3>';
                    } else {
                        echo '<h3>My Sent Messages</h3>';
                    }
                    ?>
                    <div align="center" style="margin-left: 20px;">
                        <table class="fancy">
                            <?
                            $con = connect();
                            if ($search_type == "received") {
                                echo '<tr><th>ID</th><th>Subject</th><th>From</th><th>Date</th></tr>';
                                $query = "SELECT `id`,`from` as `peer`, `subject`, `creation_date` 
                                from `message` where `rcpt_to`='" . mysql_real_escape_string($un) . "' or `rcpt_to`='everybody' 
                                order by `creation_date` desc limit " . mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($rowsPerPage);
                            } else {
                                echo '<tr><th>ID</th><th>Subject</th><th>To</th><th>Date</th></tr>';
                                $query = "SELECT `id`, `rcpt_to` as `peer`,`subject`, `creation_date` 
                                from `message` where `from`='" . mysql_real_escape_string($un) . "' order by `creation_date` desc  limit " .
                                        mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($rowsPerPage);
                            }
                            $result = mysql_query($query, $con);
                            while ($row = mysql_fetch_array($result)) {
                                echo "<tr><td><a href=\"./message.php?id=" . $row['id'] . "\">#" .
                                $row['id'] . "</a></td><td>" . utf8_substr($row['subject'], 0, 25) . (strlen($row['subject']) > 25 ? "..." : "") . "</td><td>" . getNameForId($row['peer']) . "</td><td>" . $row['creation_date'] . "</td></tr>";
                            }
                            mysql_close($con);
                            ?>
                        </table>
                    </div>
                    <div align="right">

                        <?
                        $con = connect();
                        if ($search_type == "received") {
                            $query = "SELECT COUNT(*) as `count` from `message` where `rcpt_to`='$un' or rcpt_to='everybody'";
                        } else {
                            $query = "SELECT COUNT(*) as `count` from `message` where `from`='$un'";
                        }
                        $result = mysql_query($query);
                        $row = mysql_fetch_array($result);
                        $count = $row['count'];
                        $npages = ceil($count / $rowsPerPage);
                        $page++;
                        if ($page > 1) {
                            echo '<a href="?t=' . $search_type . '&page=' . ($page - 1) . '">Previous</a>';
                        }
                        echo ' Page ' . $page . ' ';
                        if ($page < $npages) {
                            echo '<a href="?t=' . $search_type . '&page=' . ($page + 1) . '">Next</a>';
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