<?php
include('../global.php');
include("../database.php");
if (!$_COOKIE["id"]) {//unauthorized user!    
    header('Location: ' . $__BASE_URI . '/login/index.php');
}
if (!authorize_user($_COOKIE["id"], $_COOKIE["token"])){
    header('Location: ' . $__BASE_URI . '/login/index.php');
}
session_start();
if (empty($_SESSION['count'])) {
    $_SESSION['count'] = 1;
} else {
    $_SESSION['count']++;
}

function getUser() {
    $fn = $_COOKIE["fn"];
    $ln = $_COOKIE["ln"];
    $full_name = $fn . " " . $ln;
    echo '<span id="username"><a href="/login/profile.php">' . $full_name . '</a></span>';
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd" 
    >
<html>
    <head>
        <title>Message Composer</title>
        <meta name="keywords" content="Automatic Control Lab, Virtual Lab, Automatic Control Playground" >
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="../tooltip/style.css" >    
        <link rel="stylesheet" type="text/css" href="./style-p.css" >
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
                </div>
                <div id="centercolumn">
                    <h1>
                        Compose Message
                    </h1>
                    <div>
                        <form method="POST" action="message-sent.php">
                            <input type="hidden" name="un" id="un" value="<? echo $_COOKIE["id"]; ?>">
                            <table cellpadding="5">
                                <tbody>
                                    <tr>
                                        <td><label for="username">Message from:</label></td>
                                        <td>
                                            <? getUser(); ?>
                                        </td>
                                    </tr>
                                    <tr>                                    
                                        <td><label for="admin">Receipt to:</label></td>
                                        <td>
                                            <select name="admin" id="admin" style="background-color: transparent;">
                                                <?
                                                $con = connect();
                                                mysql_select_db("vlab", $con);
                                                if (!$con) {
                                                    die('Could not connect: ' . mysql_error());
                                                } else {
                                                    $result = mysql_query("SELECT id,fn,ln FROM people WHERE role>=10");
                                                    while ($row = mysql_fetch_array($result)) {
                                                        echo '<option value="' . $row['id'] . '">' . $row['fn'] . ' ' . $row['ln'] . '</option>';
                                                    }
                                                }
                                                mysql_close($con);
                                                ?></select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label for="subject">Subject</label></td>
                                        <td><input type="text" name="subject" id="subject" style="width:300px"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="cl"></div>
                            <div id="composer-holder">
                                <label for="editor1">
                                    Type your message here:
                                </label>
                                <div id="composer" style="margin-top:15px;margin-left:10px;margin-right:10px">
                                    <textarea cols="80" id="editor1" name="editor1" rows="10"><? echo htmlentities("<p>Type your message right here.</p>"); ?></textarea>
                                </div>                        
                                <script type="text/javascript">
                                    CKEDITOR.replace( 'editor1');
                                </script>
                            </div>
                            <div class="cl"></div>
                            <input type="submit" value="Send">
                        </form>
                    </div>
                </div>     
            </div>
            <div class="footer" id="footer">
                <? include('../footer.php') ?>
            </div>
        </div>
    </body>
</html>
