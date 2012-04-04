<?php
session_start();
session_start();
if (empty($_SESSION['count'])) {
    $_SESSION['count'] = 1;
} else {
    $_SESSION['count']++;
}
include('../global.php');
include("../database.php");
$what = $_GET["what"];
if (isset($what) & $what == "return") {
    $authtype = $_GET["authtype"];
    if ($authtype == "google") {
        $fn = $_GET["openid_ext1_value_firstname"];
        $ln = $_GET["openid_ext1_value_lastname"];
        $email = $_GET["openid_ext1_value_email"];
        $id = $_GET["openid_identity"];
        $auth_uri = "http://www.google.com";
    } else if ($authtype == "yahoo") {
        $auth_uri = $id;
        $fn = $_GET["openid_ax_value_fullname"];
        $ln = "";
        $email = $_GET["openid_ax_value_email"];
        $id = $_GET["openid_identity"];
        $auth_uri = $id;
    }
    if (isset($email)) {
        $hash = md5(strtolower(trim($email)));
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
            $insert_query = "INSERT IGNORE INTO people (`id`,`fn`,`ln`,`email`,`login_method`,`authorization_key`) VALUES ('" . $id . "', '" .
                    $fn . "', '" . $ln . "', '" . $email . "', '" . $authtype . "', md5(rand()) );";
            mysql_query($insert_query, $con);
        }
        mysql_close($con);
        //TODO: Find authorization_key! It should be in the database
        $con = connect();
        $query_auth_key = "SELECT `authorization_key` as `token` from `people` where id='" . $id . "'";
        $result = mysql_query($query_auth_key);
        $row = mysql_fetch_array($result);
        if ($row) {
            $token = $row["token"];
        }
        mysql_close($con);
        setcookie("token", $token, time() + 36000, "/");
    }
} elseif (isset($what) & $what == "member") {
    /**
     * Find user in the database...
     */
    $un = $_POST['un'];
    $pwd = $_POST['pwd'];
    $con = connect();
    mysql_select_db("vlab", $con);
    if (!$con) {
        die('Could not connect: ' . mysql_error());
    } else {
        $result = mysql_query("SELECT `fn`,`ln`,`email`,`pwd_hash_md5`,`authorization_key` 
            FROM people WHERE id='" . $un . "'");
        $row = mysql_fetch_array($result);
        $pwd_in_sql = $row['pwd_hash_md5'];
        if ((is_null($row)) || (md5($pwd) != $pwd_in_sql)) {
            // Invalid Login
            $unauthorized = true;
        } else {
            // Correct login
            $email = $row["email"];
            $fn = $row["fn"];
            $ln = $row["ln"];
            $authtype = "VLAB";
            $auth_uri = $_SERVER['HTTP_HOST'];
            $hash = md5(strtolower(trim($email)));
            $authorization_key = $row["authorization_key"];
            setcookie("id", $un, time() + 36000, "/");
            setcookie("auth", $authtype, time() + 36000, "/");
            setcookie("fn", $fn, time() + 36000, "/");
            setcookie("ln", $ln, time() + 36000, "/");
            setcookie("email", $email, time() + 36000, "/");
            setcookie("hash", $hash, time() + 36000, "/");
            setcookie("token", $authorization_key, time() + 36000, "/");
        }
    }
    mysql_close($con);
} else {
    $un=$_COOKIE["id"];
    $fn = $_COOKIE["fn"];
    $ln = $_COOKIE["ln"];
    $email = $_COOKIE["email"];
    $hash = $_COOKIE["hash"];
    $authtype = $_COOKIE["auth"];
    $token = $_COOKIE["token"];
    if (!isset($fn)) {
        $fn = "Anonymous";
    };
    if (!isset($email)) {
        $email = "guest@" . $_SERVER['HTTP_HOST'];
    };
    if (!isset($authtype)) {
        $authtype = "vlab";
    };
}
if (isset($unauthorized) & $unauthorized) {
    header('HTTP/1.1 401 Unauthorized');
}
$user_role = getRole($un);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login Page</title>
        <meta name="robots" content="noindex,nofollow">
        <meta name="keywords" content="Automatic Control Lab, Virtual Lab, Automatic Control Playground" >
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="../tooltip/style.css" >    
        <link rel="stylesheet" type="text/css" href="../style.css" > 
        <link href="/rss/feed.php" rel="alternate" type="application/rss+xml" title="RSS 2.0" />
        <link href="/rss/feed.php" rel="alternate" type="application/atom+xml" title="Atom 1.0" />
        <script type='text/javascript' src='../chung.js' ></script>
        <script type='text/javascript'></script>
        <link rel="shortcut icon" href="/vlab/favicon.ico" type="image/x-icon" >
        <link href="/rss/feed.php" rel="alternate" type="application/rss+xml" title="RSS 2.0" />
        <link href="/rss/feed.php" rel="alternate" type="application/atom+xml" title="Atom 1.0" />
    </head>
    <body id="body" onload="loadMe();">    
        <div id="wrap">
            <div id="background">
                <img src="../images/background.jpg" class="stretch" alt="" >
            </div>
            <div id="leftcolumn">
<? include('../sidebar.php'); ?>
            </div>
            <div id="rightcolumn">
            </div>
            <div id="container">
                <div id="nav">
                    <a href=".." style="text-decoration:none"><span class="navLink" onmouseover="highlight(this);" onmouseout="dehighlight(this);">Back to Main</span></a>
                    <a href="logout.php" style="text-decoration:none"><span class="navLink" onmouseover="highlight(this);" onmouseout="dehighlight(this);">Logout</span></a>
                </div>
                <div id="centercolumn">
                    <h1>
                        Profile Page
                    </h1>

                    <?
                    if (isset($email)) {
                        echo '<h3>Your Profile</h3><div><img src="http://www.gravatar.com/avatar/' . $hash . '" ></div>';
                        echo '<p>' . $fn . ' ' . $ln . ' &lt;<a href="mailto:' . $email . '">' . $email . '</a>&gt;</p>';
                        echo '<div id="text1"><p align="justify">You are logged in by <a href="' . $auth_uri . '">' . $authtype . '</a>';
                        $anonymous_email = "guest@" . $_SERVER['HTTP_HOST'];
                        if ($email == $anonymous_email) {
                            echo ' as guest. Check the <a href="/login">login page</a> on how 
                                you can connect to <b>VLAB</b>. You can either register and create an account on VLAB or use an existing Google or Yahoo account';
                        }
                        echo '.</p>';
                        if ($email == $anonymous_email) {
                            ?>
                            <div id="login-button" align="center">
                                <a href="."><img src="../images/logiin.png" alt="Login here"></a>
                            </div>
                            <?
                        }
                        echo '</div>';
                    } else {
                        echo '<p><a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.2">Error 401 : Unauthorized!</a> You have entered wrong credentials (username/password).</p>';
                    }
                    if ($email != $anonymous_email) {
                        ?>
                        <div id="profile-menu">
                            <a href="./composer.php"><img src="../images/new_message.png" alt="new message" title="Compose Message"></a>
                            <a href="./my_messages.php"><img src="../images/my_messages.png" alt="my messages" title="My Messages"> </a>
                            <a href=""><img src="../images/my_documents.png" alt="my messages" title="My Exercises"> </a>
                            <? if ($user_role >= 10) { ?>
                                <a href="./users.php"><img src="../images/people.png" alt="users" title="VLAB Users"> </a>
                                <a href="../rss"><img src="../images/rss.png" width="70" alt="RSS Feeds" title="RSS"> </a>
                        <? } ?>
                        </div>
                        <?
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