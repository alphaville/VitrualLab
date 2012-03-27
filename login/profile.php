<?php
include("../database.php");
session_start();
if (empty($_SESSION['count'])) {
    $_SESSION['count'] = 1;
} else {
    $_SESSION['count']++;
}
$what = $_GET["what"];
if (isset($what) & $what == "return") {
    $authtype = $_GET["authtype"];
    if ($authtype == "google") {
        $fn = $_GET["openid_ext1_value_firstname"];
        $ln = $_GET["openid_ext1_value_lastname"];
        $email = $_GET["openid_ext1_value_email"];
        $hash = md5(strtolower(trim($email)));
        $id = $_GET["openid_identity"];
    } else if ($authtype == "yahoo") {
        $fn = $_GET["openid_ax_value_fullname"];
        $ln = "";
        $email = $_GET["openid_ax_value_email"];
        $id = $_GET["openid_identity"];
    }
    if (isset($fn)) {
        setcookie("id", $id, time() + 36000, "/");
        setcookie("auth", $authtype, time() + 36000, "/");
        setcookie("fn", $fn, time() + 36000, "/");
        setcookie("ln", $ln, time() + 36000, "/");
        setcookie("email", $email, time() + 36000, "/");
        setcookie("hash", $hash, time() + 36000, "/");
        // Are you new to the neighborhood???
        $con = connect();
        if (!$con) {
            die('Could not connect: ' . mysql_error());
        } else {
            mysql_query("USE vlab", $con);
            mysql_query("INSERT IGNORE INTO people (id,fn,ln,email) VALUES ('" . $id . "', '" .
                    $fn . "', '" . $ln . "', '" . $email . "');", $con);
        }
        mysql_close($con);
    }
} elseif (isset($what) & $what == "member") {
    /**
     * TODO: Find user in the database...
     */
    $un = $_POST['un'];
    $pwd = $_POST['pwd'];
    $con = connect();
    mysql_select_db("vlab", $con);
    if (!$con) {
        die('Could not connect: ' . mysql_error());
    } else {
        $result = mysql_query("SELECT fn,ln,email,pwd_hash_md5 FROM people WHERE id='" . $un . "'");
        $row = mysql_fetch_array($result);
        $pwd_in_sql = $row['pwd_hash_md5'];
        if ((is_null($row)) | (md5($pwd) != $pwd_in_sql)) {
            // Invalid Login
        } else {
            // Correct login
            $email = $row["email"];
            $fn = $row["fn"];
            $ln = $row["ln"];
            $authtype = "VLAB";
            setcookie("id", $un, time() + 36000, "/");
            setcookie("auth", $authtype, time() + 36000, "/");
            setcookie("fn", $fn, time() + 36000, "/");
            setcookie("ln", $ln, time() + 36000, "/");
            setcookie("email", $email, time() + 36000, "/");
        }
    }
    mysql_close($con);
} else {
    $fn = $_COOKIE["fn"];
    $ln = $_COOKIE["ln"];
    $email = $_COOKIE["email"];
    $hash = $_COOKIE["hash"];
    $authtype = $_COOKIE["auth"];
    if (!isset($fn)) {
        $fn = "Anonymous";
    };
    if (!isset($email)) {
        $email = "guest@vlab.mooo.info";
    };
    if (!isset($authtype)) {
        $authtype = "vlab";
    };
}
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
        <script type='text/javascript' src='../chung.js' ></script>
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
                    <h1>
                        Profile Page
                    </h1>
                    <h3>
                        Your Profile
                    </h3>

                    <?
                    echo '<div><img src="http://www.gravatar.com/avatar/' . $hash . '" ></div>';
                    echo '<p>' . $fn . ' ' . $ln . ' &lt;' . $email . '&gt;</p>';
                    echo '<p>You have logged in by ' . $authtype . '.</p>';
                    ?>
                </div>
            </div>
            <div class="footer" id="footer">
                <? include('../footer.php') ?>
            </div>
        </div>
    </body>
</html>