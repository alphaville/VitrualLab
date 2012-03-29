<?php

function connect() {
    require("global.php");
    $con = mysql_connect($__DATABASE_URL__,$__DATABASE_USER__,$__DATABASE_PWD__);
    if (!$con) {
        return null;
    }
    mysql_query("use " . $__DATABASE_NAME__);
    return $con;
}

function authorize_user($id,$token){
    $con = connect();
    if (!$con){
        die("MySQL connectivity error : ".mysql_error());
    }else{
        $query = "select count(*) as `check` from people where `id`='".$id."' AND `authorization_key`='".$token."'";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);
        if ($row){
            $answer = ($row["check"]==1);
            mysql_close($con);
            return $answer;
        }else{
            mysql_close($con);
            return false;
        }
    }
}

?>
