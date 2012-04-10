<?php
session_start();
if (empty($_SESSION['count'])) {
    $_SESSION['count'] = 1;
} else {
    $_SESSION['count']++;
}
include('../global.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login Page</title>
        <meta name="robots" content="noindex,nofollow">
        <meta name="keywords" content="<? echo $__KEYWORDS__; ?>" >
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
                </div>
                <div id="centercolumn">
                    <h1>
                        Login Page
                    </h1>
                    <?
                    $firstName = $_COOKIE["fn"];
                    $lastName = $_COOKIE["ln"];
                    $mail = $_COOKIE["email"];
                    $hash = $_COOKIE["hash"];
                    if (isset($firstName)) {
                        echo '<div><img src="http://www.gravatar.com/avatar/' . $hash . '" ></div>';
                        echo '<p>' . $firstName . ', you are already logged in...</p>';
                    }
                    ?>
                    <div style="text-align: justify;">
                        VLAB supports authentication by <a href="http://openid.net/">OpenID</a>. 
                        This practically means
                        that if you have an account on a web site that supports OpenID, VLAB
                        delegates your authentication to that site. Therefore, you don't need to
                        have a separate account for VLAB. Your Google/YouTube, Yahoo or Twitter account
                        will do just as fine.
                    </div>
                    <br>
                    <div id="login-forms" align="center">
                        <table cellpadding="10">
                            <tr>
                                <td><form action="./do-login.php?login=google" method="post">
                                        <input type="image" src="/images/google.png" style="height: 40px" name="google">
                                    </form></td>
                                <td>
                                    <form action="./do-login.php?login=yahoo" method="post">
                                        <input type="image" src="/images/yahoo.png" style="height: 40px" name="yahoo">
                                    </form>    
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div style="text-align: justify;">
                        <p>
                            Already have a <b>VLAB account</b>?
                        </p>

                        <div id="credential"  
                             style="width: 420px;margin-left: 100px;border:yellowgreen;
                             padding-top: 12px;padding-left:12px;padding-right:12px;
                             padding-bottom: 5px;border: 1px dashed #666;">
                            <form method="POST" action="profile.php?what=member" >
                                <table >
                                    <tr>
                                        <td><em>Username</em></td><td><input type="text" name="un"></td>
                                    </tr>
                                    <tr>
                                        <td><em>Password</em></td><td><input type="password" name="pwd"></td>
                                    </tr>
                                </table>
                                <div class="button-holder" align="center" style="padding-top: 25px; padding-bottom: 15px">
                                    <div class="button" style="padding:10px">
                                        <input type="image" src="../images/logiin.png" value="Login!">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>                    
                    <div style="text-align: justify;">
                        <p>
                            <b>You don't have any account?</b> No problem! You can still 
                            login on VLAB. You just have to 
                            <b><a href="/login/account.php">create an account</a></b>:
                        </p>
                    </div>            
                    <div id="register-holder" style="padding:15px">
                        <div style="padding-left: 10px;text-align: center">
                            <a href="/login/account.php">
                                <img alt="Register" src="/images/padlock-md.png" 
                                     style="height: 80px;border-style: hidden">
                                <br/>Click here to register
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer" id="footer">
                <? include('../footer.php')
                ?>
            </div>
        </div>
    </body>
</html>
