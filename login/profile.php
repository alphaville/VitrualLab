<?php
include('../global.php');
include("../database.php");
include("./login-utils.php");

doStartSession();

$what = $_GET["what"];

$myUser = new User();
if (isset($what) & $what == "return") {// Authenticate by OpenID
    $myUser = authOpenID();
} elseif (isset($what) & $what == "member") {// Authenticate by VLAB-AS
    $myUser = authMember();
}
if (isset($what)) {
    $email = $myUser->getEmail();
    $un = $myUser->getUn();
    $fn = $myUser->getFn();
    $ln = $myUser->getLn();
    $hash = $myUser->getHash();
    $authtype = $myUser->getAuthType();
    $token = $myUser->getToken();
} else {
    $email = $_COOKIE['email'];
    $un = $_COOKIE['id'];
    $fn = $_COOKIE['fn'];
    $ln = $_COOKIE['ln'];
    $hash = $_COOKIE['hash'];
    $authtype = $_COOKIE['authType'];
    $token = $_COOKIE['token'];
}

if (!isset($what)) {// Just want to see my profile, dude
    if (!isset($_COOKIE['fn'])) {
        $fn = "Anonymous";
    };
    if (!isset($_COOKIE['email'])) {
        $email = "guest@" . $_SERVER['HTTP_HOST'];
    };
    if (!isset($_COOKIE['auth_type'])) {
        $authtype = "vlab";
    };
}

$user_role = getRole($un);

$redirect=$_GET['redirect'];
if (isset($redirect)){
    header("Location: /$redirect");
    die();
}
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
        <script type='text/javascript' src='../chung.js' ></script>
        <script type='text/javascript'></script>
        <link rel="shortcut icon" href="/vlab/favicon.ico" type="image/x-icon" >
        <link href="<? echo $FEED_RSS; ?>" rel="alternate" type="application/rss+xml" title="RSS 2.0" >
        <link href="<? echo $FEED_ATOM; ?>" rel="alternate" type="application/atom+xml" title="Atom 1.0" >
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
                    <? if (strcmp($authtype, "VLAB") == 0) { ?>
                        <a href="change_pass.php" style="text-decoration:none"><span class="navLink" onmouseover="highlight(this);" onmouseout="dehighlight(this);">Change Password</span></a>
                    <? } ?>
                    <a href="logout.php" style="text-decoration:none"><span class="navLink" onmouseover="highlight(this);" onmouseout="dehighlight(this);">Logout</span></a>
                </div>
                <div id="centercolumn">
                    <h1>
                        Profile Page
                    </h1>

                    <?
                    if (isset($email)) {
                        echo '<h3>Profile Info</h3><div><img src="http://www.gravatar.com/avatar/' . $hash . '" ></div>';
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
                        <div class="cl"></div>
                        <div id="profile-menu">                            
                            <div id="usersOptions">
                                <p><b>Profile Management</b></p>
                                <hr/>
                                <a href="./composer.php" ><img src="../images/new_message.png" alt="new message" title="Compose Message" ></a>
                                <a href="./my_messages.php"><img src="../images/inmail.png" alt="received messages" title="Received"> </a>
                                <a href="./my_messages.php?t=sent"><img src="../images/outmail.png" alt="sent messages" title="Sent"> </a>
                                <a href="../exercises/list.php"><img src="../images/my_documents.png" alt="my messages" title="My Exercises"> </a>
                                <a href="./edit.php"><img src="../images/editprofile.png" alt="my messages" title="Edit my profile"> </a>
                            </div> 
                            <div class="cl"></div>
                            <div class="cl"></div>
                            <? if ($user_role >= 10) { ?>
                                <div id="adminOptions">
                                    <p><b>Administrative Options</b></p>
                                    <hr/>
                                    <a href="./users.php"><img src="../images/people.png" alt="users" title="VLAB Users"> </a>                                        
                                    <a href="../rss"><img src="../images/rss.png" alt="RSS Feeds" title="RSS"> </a>
                                    <a href=""><img src="../images/professor.png" alt="students' work" title="Students' Work"> </a>
                                    <a href=""><img src="../images/chart.png" alt="statistics" title="VLAB Statistics"> </a>
                                </div>
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