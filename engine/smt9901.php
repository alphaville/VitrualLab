<?php
header('Cache-Control: no-cache, must-revalidate');
header('Content-type: application/json');

$arr = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
echo json_encode($arr);
?>
