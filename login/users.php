<?php
include('../global.php');
include("../database.php");
doStartSession();

$un = $_COOKIE['id'];
$token = $_COOKIE['token'];
$isadmin = authoriseUser($un, $token, true, 10, 'login/users.php');// Requires role>=10 to access this resource

$message_id = $_GET['id'];


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
$rowsPerPage = $_GET["offset"]?$_GET["offset"]:20;
$page = $_GET["page"] != null ? $_GET["page"] : 1;
$page--;
$offset = $page * $rowsPerPage;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>VLAB Users</title>
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
                <div id="nav">
                    <a href=".." style="text-decoration:none"><span class="navLink" onmouseover="highlight(this);" onmouseout="dehighlight(this);">Back to Main</span></a>
                    <a href="composer.php" style="text-decoration:none"><span class="navLink" onmouseover="highlight(this);" onmouseout="dehighlight(this);">Send Message</span></a>                    
                    <a href="my_messages.php" style="text-decoration:none"><span class="navLink" onmouseover="highlight(this);" onmouseout="dehighlight(this);">My Inbox</span></a>
                    <a href="profile.php" style="text-decoration:none"><span class="navLink" onmouseover="highlight(this);" onmouseout="dehighlight(this);">My Profile</span></a>
                    <a href="logout.php" style="text-decoration:none"><span class="navLink" onmouseover="highlight(this);" onmouseout="dehighlight(this);">Logout</span></a>
                </div>
                <div id="centercolumn">
                    <h3>VLAB Users</h3>  
                    <?
                    if ($isadmin) {//only admins may apply these methods                        
                        $method = $_GET['method'];
                        $user_id = $_GET['user_id'];
                        if ($user_id != "admin" && $method == "delete") {// you cannot delete the admin
                            $con = connect() or die("MySQL Error: Could not connect to the database");
                            if ($con) {
                                $query = "DELETE FROM `people` WHERE `id`='" . urldecode($user_id) . "'";
                                mysql_query($query);
                            }
                            mysql_close($son);
                        }
                        // CREATE AN ADMINISTRATOR
                        if ($method=="update_admin"){
                            $con = connect() or die("MySQL Error: Could not connect to the database");
                            if ($con) {
                                $query = "UPDATE `people` SET role=10 WHERE `id`='" . urldecode($user_id) . "'";
                                mysql_query($query);
                            }
                            mysql_close($son);
                        }
                        // REVOKE AN ADMINISTRATOR
                        if ($method=="undo_admin"){
                            $con = connect() or die("MySQL Error: Could not connect to the database");
                            if ($con) {
                                $query = "UPDATE `people` SET role=0 WHERE `id`='" . urldecode($user_id) . "'";
                                mysql_query($query);
                            }
                            mysql_close($son);
                        }
                    }
                    ?>
                    <div align="center" style="margin-left: 20px;">
                        <table class="fancy">
                            <?
                            $con = connect();
                            echo '<tr><th>Last Name</th><th>First Name</th><th>Email</th><th>Sem.</th><th>Role</th><th>Action</th></tr>';
                            $query = "SELECT `id`,`fn`,`ln`, `email`, `semester`, `class`, `role` 
                                from `people` 
                                order by `ln` desc limit " . mysql_real_escape_string($offset) . ", " . mysql_real_escape_string($rowsPerPage);
                            $result = mysql_query($query, $con);
                            while ($row = mysql_fetch_array($result)) {
                                echo "<tr>
                                    <td>" . $row['ln'] . "</td>
                                    <td>" . $row['fn'] . "</td>
                                    <td><a href=\"mailto:" . $row['email'] . "?subject=Mail From VLAB\">" . $row['email'] . "</a></td>
                                    <td>" . $row['semester'] . ($row['class'] != "" ? ("/" . $row['class']) : "") . "</td>
                                    <td>" . $row['role'] . "</td>
                                        <td><a title=\"Send Message\" 
                                        href=\"composer.php?force_rcpt=true&rcpt_to=" . urlencode($row['id']) . "&to=" . urlencode($row['fn'] . " " . $row['ln']) . "\">
                                            <img src=\"../images/new_message.png\" style=\"width: 20px\"></a>";
                                if ($row['role'] < 10 && $row['role'] >=0){
                                    echo "<a title=\"Make Admin\" href=\"?method=update_admin&user_id=" . urlencode($row['id']) . "\"><img src=\"../images/meeting-chair.png\" style=\"width: 20px\"></a>";
                                }
                                if ($row['role'] >=1 && $row['role'] <= 10){
                                    echo "<a title=\"Revoke Admin\" href=\"?method=undo_admin&user_id=" . urlencode($row['id']) . "\"><img src=\"../images/undo-admin.png\" style=\"width: 20px\"></a>";
                                }
                                if ($row['role'] <= 1 && $row['role'] >=0) {
                                    echo "<a title=\"Delete\" href=\"?method=delete&user_id=" . urlencode($row['id']) . "\"><img src=\"../images/user-delete.png\" style=\"width: 20px\"></a>";
                                }
                                echo "</td></tr>";
                            }
                            mysql_close($con);
                            ?>
                        </table>
                    </div>
                    <div align="right">
                        <?
                        $con = connect();
                        $query = "SELECT COUNT(*) as `count` from `people`";
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