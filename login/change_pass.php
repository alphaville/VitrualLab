<?php
include('../global.php');
include("../database.php");
if (!authorize_user($_COOKIE["id"], $_COOKIE["token"])) {
    header('Location: ' . $__BASE_URI . '/login/index.php');
    die("You are being redirected...");
}
$un = $_COOKIE['id'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Change your Password</title>
        <meta name="keywords" content="<? echo $__KEYWORDS__; ?>" >
        <meta name="robots" content="noindex,nofollow">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="../tooltip/style.css" >    
        <link rel="stylesheet" type="text/css" href="./style-p.css" >
        <link rel="stylesheet" type="text/css" href="../style.css" > 
        <script type='text/javascript' src='../chung.js' ></script>
        <script type='text/javascript'></script>
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
                <? include('../sidebar.php');
                ?>
            </div>
            <div id="rightcolumn">
                <!-- RIGHT COLUMN -->	
            </div>
            <div id="container">
                <div id="nav">
                    <a href=".." style="text-decoration:none"><span class="navLink" onmouseover="highlight(this);" onmouseout="dehighlight(this);">Back to Main</span></a>
                    <a href="/login/logout.php" style="text-decoration:none"><span class="navLink" onmouseover="highlight(this);" onmouseout="dehighlight(this);">Logout</span></a>
                </div>
                <div id="centercolumn">
                    <h1>
                        Change your password
                    </h1>            
                    <?php
                    $do = $_GET["do"];
                    if (strcmp($do, "changeit") == 0) {
                        $old_pass = $_POST["old_pwd"];
                        $new_pass = $_POST["new_pass"];
                        $new_pass2 = $_POST["new_pass2"];
                        if (strcmp($new_pass, $new_pass2) != 0) {
                            echo "<b>ERROR:</b> Password Confirmation Failed. Please, 
                                type the same password twice in order to update it. 
                                Go <a href=\"change_pass.php\">back</a>.";
                        } else if (strlen(trim($new_pass)) < 5) {
                            echo "<b>ERROR:</b> Too small password";
                        } else {
                            if (!authorize_user_passwrd($un, $old_pass)) {
                                echo "<b>ERROR:</b> Wrong password!";
                            } else {
                                $pwd_hashed = md5(trim($new_pass));
                                $old_pwd_hashed = md5(trim($old_pass));
                                $query = "UPDATE `people` SET `pwd_hash_md5`='" . $pwd_hashed . "' WHERE 
                                    `pwd_hash_md5`='" . $old_pwd_hashed . "' AND id='" . $un . "'";
                                $con = connect();
                                if (!$con) {
                                    die('Could not connect: ' . mysql_error());
                                } else {
                                    mysql_query($query, $con);
                                    mysql_close($con);
                                }
                                echo "Congratulations - You have successfully changed your password!";
                            }                            
                        }
                    } else {
                        ?>
                        <div id="change_password">
                            <form action="change_pass.php?do=changeit" method="post">
                                <table>
                                    <colgroup>
                                        <col style="width:230px">
                                        <col>
                                    </colgroup>
                                    <tr>
                                        <td>Current Password</td>
                                        <td><input type="password" name="old_pwd"/></td>
                                    </tr>
                                    <tr>
                                        <td>New Password</td>
                                        <td><input type="password" name="new_pass"/></td>
                                    </tr>
                                    <tr>
                                        <td>Retype New Password</td>
                                        <td><input type="password" name="new_pass2"/></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><input type="submit" value="Submit"></td>                                    
                                    </tr>
                                </table>                        
                            </form>
                        </div><!-- end of change_password -->
                    <? } ?>
                </div><!-- end of centercolumn -->
            </div><!-- end of container -->
            <div class="footer" id="footer">
                <? include('../footer.php') ?>
            </div><!-- end of footer -->
        </div><!-- end of wrap -->
    </body>
</html>