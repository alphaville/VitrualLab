<?php
session_start();
if (empty($_SESSION['count'])) {
    $_SESSION['count'] = 1;
} else {
    $_SESSION['count']++;
}
include("../global.php");
include("../database.php");
header("X-Powered-By: VLAB");
header('Content-type: text/plain');

$userid=$_COOKIE["id"];
if (!authorize_user($userid, $_COOKIE["token"])) {
    header("HTTP/1.0 401 Unauthorized");
    die('Authentication Failure!');
}

$exercise_id = $_GET['id'];
$user_id = $_GET['user_id'];

//TODO: Check parameters, authenticate etc...

$content = fetchExerciseContent($exercise_id, $user_id);
if (!$content){
    header("HTTP/1.0 404 Not Found");
    die('Not found');
}
$header ="Content-Disposition: attachment; filename=\"$exercise_id.txt\""; 
header($header);
echo $content;
?>
