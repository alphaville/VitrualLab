<?php
include("../global.php");
include("../database.php");

doStartSession();

header('Content-type: application/json');

$un = $_COOKIE["id"];
$token = $_COOKIE["token"];
authoriseUser($un, $token, false, -1, null); // do not require admin rights

$exercise_id = $_GET['id'];
$user_id = $_GET['user_id'];
if ($user_id != $un) {
    header("HTTP/1.0 403 Forbidden");
    die('Invalid request - forbidden!');
}

//TODO: Check parameters, authenticate etc...

$content = fetchExerciseContent($exercise_id, $user_id);
if (!$content) {
    header("HTTP/1.0 404 Not Found");
    die('Not found');
}
$header = "Content-Disposition: attachment; filename=\"$exercise_id.json\"";
header($header);
echo $content;
?>
