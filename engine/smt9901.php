<?php

header('Cache-Control: no-cache, must-revalidate');
header('Content-type: application/json');
$P = escapeshellarg(urldecode($_GET["P"]));
$Q = escapeshellarg($_GET["Q"]);
$Pf = escapeshellarg($_GET["Pf"]);
$Qf = escapeshellarg($_GET["Qf"]);
$Pc = escapeshellarg($_GET["Pc"]);
$Qc = escapeshellarg($_GET["Qc"]);
$Pm = escapeshellarg($_GET["Pm"]);
$Qm = escapeshellarg($_GET["Qm"]);
$sp = escapeshellarg($_GET["sp"]);
$identifier = escapeshellarg($_GET["id"]);
$command = "./simulator -P ". $P . " -Q  ". $Q . " -Pf  ". $Pf . 
        " -Qf "  . $Qf . " -Pm " . $Pm . 
        " -Qm " . $Qm . " -Pc ".$Pc." -Qc ".$Qc." -setpoint ".$sp." -id ".$identifier;
$returned = exec($command,$ret);
foreach($ret as $val){
    echo $val."\n";
}
?>
