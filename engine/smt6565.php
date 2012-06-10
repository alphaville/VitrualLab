<?php
// Example:
// curl "http://alphaville/engine/smt6565.php?id=example&P=1&Q=%5B1%201%5D&sim_log_range=%5B-1%205%5D&sim_points=1000"
header('Content-type: application/json');
header('Cache-Control: no-cache, must-revalidate');
// Note: P and Q are exported from smt9901 when a 
$P = escapeshellarg(urldecode($_GET["P"]));
$Q = escapeshellarg($_GET["Q"]);
$sim_points = escapeshellarg($_GET["sim_points"]);
$delay = escapeshellarg($_GET["delay"]);
$sim_points= escapeshellarg($_GET["sim_points"]);
$sim_log_range = escapeshellarg($_GET["sim_log_range"]);
$identifier = escapeshellarg($_GET["id"]);
$command = "./simulator_bode -P ". $P . " -Q  ".$Q." -id ".$identifier.
        " -delay ".$delay." -sim_points ".$sim_points." -sim_log_range ".$sim_log_range;
$returned = exec($command,$ret);
foreach($ret as $val){
    echo $val."\n";
}
?>
