<?php
/*
 * A web service allowing clients to register a new exercise (temporarily save)
 */
session_start();
if (empty($_SESSION['count'])) {
    $_SESSION['count'] = 1;
} else {
    $_SESSION['count']++;
}
include("../global.php");
include("../database.php");
header("X-Powered-By: VLAB");
$data = $_POST['exercise'];
if (!$data){
    header("HTTP/1.0 400 Bad Request");
    die('You are not allowed to post empty data');
}
$type = $_POST['type'];
if (!$type){
    header("HTTP/1.0 400 Bad Request");
    die('Type not specified');
}
$userid=$_COOKIE["id"];
if (!authorize_user($userid, $_COOKIE["token"])) {
    //TODO: Handle Auth Failure!!!  
    //TODO: header 401
    header("HTTP/1.0 401 Unauthorized");
    die('Authentication Failure!');
}

$overwrite = $_POST['overwrite'];
if (strcmp($overwrite,'false')==0){
    $created_id = registerExercise(addslashes($data), $userid, $type);
}else{
    $exercise_id = $_POST['working_id'];
    updateExercise(addslashes($data), $exercise_id);
    $created_id = $exercise_id;
}
header("Content-type: text/plain; charset=utf-8");
echo $created_id;
?>
