<?php
$first = $_COOKIE["fn"];
if (isset($first)) {
    echo "Dear <a href=\"/login/profile.php\" style=\"text-decoration:none\">$first</a>, 
                        you are logged in. <a href=\"./login/logout.php\" style=\"text-decoration:none\">Logout</a>.<br/>
                        <a href=\"/\" style=\"text-decoration:none\" title=\"Home\"><img src=\"/images/home.png\"></img></a>
                        <a href=\"/login/profile.php\" style=\"text-decoration:none\" title=\"My Profile\"><img src=\"/images/im-user.png\"></img></a>
                        <a href=\"/exercises/list.php\" style=\"text-decoration:none\" title=\"My Exercises\"><img src=\"/images/folder-txt.png\"></img></a>
                        <a href=\"/login/my_messages.php\" style=\"text-decoration:none\" title=\"Incoming Messages\"><img src=\"/images/mail-mark-read.png\"></img></a>
                        <a href=\"/login/composer.php\" style=\"text-decoration:none\" title=\"Compose Message\"><img src=\"/images/mail-message-new.png\"></img></a>";
} else {
    echo $welcome . ' <a href="/login/profile.php" style="text-decoration:none">Guest</a>.
                        ' . $youmay . ' <a href="/login" style="text-decoration:none">Login</a>.';
}
?>
