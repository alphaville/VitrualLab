<?php

function connect() {
    require("global.php");
    $con = mysql_connect($__DATABASE_URL__, $__DATABASE_USER__, $__DATABASE_PWD__);
    if (!$con) {
        return null;
    }
    mysql_query("use " . $__DATABASE_NAME__);
    return $con;
}

function authorize_user($id, $token) {
    $con = connect();
    if (!$con) {
        die("MySQL connectivity error : " . mysql_error());
    } else {
        $query = "select count(*) as `check` from people where `id`='" . $id . "' AND `authorization_key`='" . $token . "'";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);
        if ($row) {
            $answer = ($row["check"] == 1);
            mysql_close($con);
            return $answer;
        } else {
            mysql_close($con);
            return false;
        }
    }
}


function authorize_user_passwrd($id, $password) {
    $con = connect();
    if (!$con) {
        die("MySQL connectivity error : " . mysql_error());
    } else {
        $query = "select count(*) as `check` from people where `id`='" . $id . "' AND `pwd_hash_md5`='" . md5(trim($password)) . "'";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);
        if ($row) {
            $answer = ($row["check"] == 1);
            mysql_close($con);
            return $answer;
        } else {
            mysql_close($con);
            return false;
        }
    }
}

function getNameForId($id) {
    $con = connect();
    if (!$con) {
        die("MySQL connectivity error : " . mysql_error());
    } else {
        $query = "select `fn`,`ln` from people where `id`='" . $id . "'";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);
        if ($row) {
            $answer = $row['fn'] . ' ' . $row['ln'];
            mysql_close($con);
            return $answer;
        } else {
            mysql_close($con);
            return false;
        }
    }
}

function getRole($id) {
    $con = connect();
    if (!$con) {
        die("MySQL connectivity error : " . mysql_error());
    } else {
        $query = "select `role` from people where `id`='" . $id . "'";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);
        if ($row) {
            $answer = $row["role"];
            mysql_close($con);
            return $answer;
        } else {
            mysql_close($con);
            return -1;
        }
    }
}

?>
