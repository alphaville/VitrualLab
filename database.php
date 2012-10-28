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

function registerExercise($exerciseData, $user_id, $exercise_type) {    
    $con = connect();
    if (!$con) {
        die('Could not connect: ' . mysql_error());
    } else {
        $insert_exercise_statement = "INSERT INTO `exercise` (`content`,`user_id`,`type`) VALUES (\"".$exerciseData.
                "\", \"". $user_id."\", \"".$exercise_type."\")";
        mysql_query($insert_exercise_statement , $con);
        $update_exercise_id = mysql_insert_id();
        //NOTE: The method mysql_insert_id(), according to the documentation
        // will return the last created ID on the *current connection*, so it
        // is fail safe provided that the connection is not shared between 
        // different threads.
    }
    mysql_close($con);
    return $update_exercise_id;
}


function updateExercise($exerciseData, $exercise_id) {    
    $con = connect();
    if (!$con) {
        die('Could not connect: ' . mysql_error());
    } else {
        $update_exercise_statement = "UPDATE `exercise` SET `content`=\"".
            $exerciseData."\" WHERE `id`=".$exercise_id;
        mysql_query($update_exercise_statement , $con);
    }
    mysql_close($con);
}
?>
