<?php
session_start();
if (empty($_SESSION['count'])) {
    $_SESSION['count'] = 1;
} else {
    $_SESSION['count']++;
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/securimage/securimage.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/database.php';
$securimage = new Securimage();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd" 
    >
<html>
    <head>
        <title>Login Page</title>
        <meta name="keywords" content="Automatic Control Lab, Virtual Lab, Automatic Control Playground" >
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="../tooltip/style.css" >    
        <link rel="stylesheet" type="text/css" href="../style.css" > 
        <link rel="stylesheet" type="text/css" href="./style-account.css" > 
        <script type='text/javascript' src='../chung.js' ></script>
        <script type='text/javascript' src='./account_utils.js' ></script>
        <script type='text/javascript'></script>
        <link rel="shortcut icon" href="/vlab/favicon.ico" type="image/x-icon" >
    </head>
    <body id="body" onload="loadMe();">    
        <? include('../global.php'); ?>
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
                </div>
                <div id="centercolumn">
                    <h1>
                        Create Account
                    </h1>


                    <?
                    $post = $_POST;
                    if ($post) {
                        if ($securimage->check($_POST['captcha_code']) == false) {
                            echo "<p>The security code entered was incorrect. ";
                            echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.</p>";
                            exit;
                        } else {
                            $un = $post["un"];
                            $fn = $post["fn"];
                            $ln = $post["ln"];
                            $email = $post["email"];
                            $pwd = md5(strtolower(trim($post["pwd"])));
                            $pwd2 = md5(strtolower(trim($post["pwd2"])));                                                        
                            ?>
                            <h3>Account Overview</h3>
                            <div id="account-details">
                                <table>
                                    <tr>
                                        <td><b>Username</b></td><td><? echo $un; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Name</b></td><td><? echo $fn . ' ' . $ln; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Email</b></td><td><? echo $email; ?></td>
                                    </tr>
                                </table>
                            </div>
                            <?
                            $con = connect();
                            if (!$con) {
                                die('Could not connect: ' . mysql_error());
                            } else {
                                mysql_query("USE vlab", $con);
                                $ins = "INSERT IGNORE INTO people (id,fn,ln,email,pwd_hash_md5) 
                                    VALUES ('" . $un . "', '" .
                                        $fn . "', '" . $ln . "', '" . $email . "', '" . $pwd . "');";
                                mysql_query($ins, $con);
                            }
                            mysql_close($con);
                            setcookie("id", $un, time() + 36000, "/");
                            setcookie("auth", "vlab", time() + 36000, "/");
                            setcookie("fn", $fn, time() + 36000, "/");
                            setcookie("ln", $ln, time() + 36000, "/");
                            setcookie("email", $email, time() + 36000, "/");
                            setcookie("hash", md5(strtolower(trim($email))), time() + 36000, "/");
                        }
                    } else {
                        include("./account-creation-form.php");
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
