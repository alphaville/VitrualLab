<?php
/*
 * A web service allowing clients to register a new exercise (temporarily save)
 */
include("../global.php");
include("../database.php");

doStartSession();

$userid=$_COOKIE["id"];
$token=$_COOKIE["token"];
authoriseUser($userid, $token, false, -1, null);

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
