<?php
// Example:
// curl "http://localhost/vlab/engine/smt9901.php?id=example&P=1&Q=%5B1%201%5D&Pm=1&Qm=1&Pc=1&Qc=1"
header('Content-type: text/json');
header('Cache-Control: no-cache, must-revalidate');
$P = escapeshellarg(urldecode($_GET["P"]));
$Q = escapeshellarg($_GET["Q"]);
$Pf = escapeshellarg($_GET["Pf"]);
$Qf = escapeshellarg($_GET["Qf"]);
$Pc = escapeshellarg($_GET["Pc"]);
$Qc = escapeshellarg($_GET["Qc"]);
$Pm = escapeshellarg($_GET["Pm"]);
$Qm = escapeshellarg($_GET["Qm"]);
$delay = escapeshellarg($_GET["delay"]);
$sim_horizon= escapeshellarg($_GET["sim_horizon"]);
$sim_points= escapeshellarg($_GET["sim_points"]);
$excitation = escapeshellarg($_GET["excitation"]);
$frequency = escapeshellarg($_GET["frequency"]);
$closed_loop = escapeshellarg($_GET["closed_loop"]);
$identifier = escapeshellarg($_GET["id"]);
$write_to_file = escapeshellarg($_GET["write_to_file"]);
$command = "./simulator -P ". $P . " -Q  ". $Q . " -Pf  ". $Pf . 
        " -Qf "  . $Qf . " -Pm " . $Pm . 
        " -Qm " . $Qm . " -Pc ".$Pc." -Qc ".$Qc." -id ".$identifier." -closed_loop ".$closed_loop.
        " -delay ".$delay." -excitation ".$excitation;
if ($write_to_file){
    $command = $command." -write_to_file ".$write_to_file;
}
if ($sim_horizon){
    $command = $command." -sim_horizon ".$sim_horizon;
}
if ($sim_points){
    $command = $command." -sim_points ".$sim_points;
}
if ($frequency){
    $command = $command." -frequency ".$frequency;
}
$returned = exec($command,$ret);
foreach($ret as $val){
    echo $val."\n";
}
?>
