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
$data = $_POST['exercise'];
$type = $_POST['type'];
$userid=$_COOKIE["id"];
if (!authorize_user($userid, $_COOKIE["token"])) {
    //TODO: Handle Auth Failure!!!  
    //TODO: header 401
    die('Authentication Failure!');
}
$created_id = registerExercise(addslashes($data), $userid, $type);
echo $created_id;
?>
