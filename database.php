<?php


function connect() {
    require("global.php");
    $con = mysql_connect($__DATABASE_URL__,$__DATABASE_USER__,$__DATABASE_PWD__);
    if (!$con) {
        echo 'XXX ';
        $error = mysql_error();
    }
    mysql_query("use " . $__DATABASE_NAME__);
    return $con;
}

?>
