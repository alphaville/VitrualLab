<?php
include('../global.php');
include("../database.php");
require_once("./Status.php");
if (!authorize_user($_COOKIE["id"], $_COOKIE["token"])) {
    header('Location: ' . $__BASE_URI . '/login/index.php');
    echo("You are being redirect to another page...");
}
session_start();
if (empty($_SESSION['count'])) {
    $_SESSION['count'] = 1;
} else {
    $_SESSION['count']++;
}
$message_id = isset($_GET['id'])?$_GET['id']:null;
$un = isset($_COOKIE['id'])?$_COOKIE['id']:null;

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

$search_type = (isset($_GET["t"])&&($_GET["t"] == "sent")) ? "sent" : "received";
$rowsPerPage = isset($_GET["offset"])?$_GET["offset"]:20;
$page = isset($_GET["page"])? $_GET["page"] : 1;
$page--;
$offset = $page * $rowsPerPage;

$dodelete = isset($_GET['delete'])?$_GET['delete']:null;
$urlid = isset($_GET['id'])?$_GET['id']:null;
if (!is_null($dodelete) && !is_null($urlid) & strcmp($dodelete, "true")==0){
    deleteExerciseById($urlid);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>My Exercises</title>
        <meta name="robots" content="noindex,nofollow">
        <meta name="keywords" content="Automatic Control Lab, Virtual Lab, Automatic Control Playground" >
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="../tooltip/style.css" >    
        <link rel="stylesheet" type="text/css" href="../style.css" > 
        <link rel="stylesheet" type="text/css" href="../fancy_table.css" > 
        <script type='text/javascript' src='../chung.js' ></script>
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
                    <div id="language" style="float:right">
                        <a href="?lang=en">English</a> | <a href="?lang=el">Ελληνικά</a>
                    </div>
                    <?include("../loginHeader.php");?>
                </div>
               
                <div id="centercolumn">
                    <h3>My Exercises</h3>                     
                    <div align="center" style="margin-left: 20px;">
                        <table class="fancy">
                            <?
                            $con = connect();
                            echo '<tr><th>ID</th><th>Status</th><th>Created</th><th>Last Update</th><th>Action</th></tr>';
                            $query = "SELECT `id`,`status`,`creation_date`,`last_update_time`
                                FROM `exercise` WHERE `user_id`='$un'
                                ORDER BY `creation_date` DESC LIMIT " . mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($rowsPerPage);
                            $result = mysql_query($query, $con);
                            while ($row = mysql_fetch_array($result)) {
                                $status = new Status();
                                $status->setStatus($row['status']);
                                echo "<tr>
                                        <td><a href=\"/exercises/inspect.php?id=".$row['id']."\">" . $row['id'] . "</a></td>
                                        <td>" . $status->getStatusText() . "</td>
                                        <td>" . $row['creation_date'] ."</td>
                                        <td>" . $row['last_update_time'] ."</td>
                                        <td>
                                            <img src=\"../images/comment.png\" style=\"height: 20px\">
                                            <a href=\"?delete=true&id=".$row['id']."\"><img src=\"../images/document_delete.png\" style=\"height: 20px\"></a>
                                        </td>
                                      </tr>";
                            }
                            mysql_close($con);
                            ?>
                        </table>
                    </div>
                    <div align="right">
                        <?
                        $con = connect();
                        $query = "SELECT COUNT(*) as `count` from `exercise`";
                        $result = mysql_query($query);
                        $row = mysql_fetch_array($result);
                        $count = $row['count'];
                        $npages = ceil($count / $rowsPerPage);
                        $page++;
                        if ($page > 1) {
                            echo '<a href="?&page=' . ($page - 1) . '&offset='.$rowsPerPage.'">Previous</a>';
                        }
                        echo ' Page ' . $page . ' ';
                        if ($page < $npages) {
                            echo '<a href="?page=' . ($page + 1) . '&offset='.$rowsPerPage.'">Next</a>';
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