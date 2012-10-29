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
        $query = "SELECT COUNT(*) AS `check` FROM `token` WHERE `people_id`='$id' AND `token_id`='$token'";
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
        $query = "SELECT COUNT(*) AS `check` FROM `people` WHERE `id`='$id' AND `pwd_hash_md5`='md5(trim($password))'";
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
        $query = "SELECT `fn`,`ln` FROM `people` WHERE `id`='$id'";
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
        $insert_exercise_statement = "INSERT INTO `exercise` (`content`,`user_id`,`type`) VALUES (\"" . $exerciseData .
                "\", \"" . $user_id . "\", \"" . $exercise_type . "\")";
        mysql_query($insert_exercise_statement, $con);
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
        $update_exercise_statement = "UPDATE `exercise` SET `content`=\"" .
                $exerciseData . "\", last_update_time=CURRENT_TIMESTAMP WHERE `id`=" . $exercise_id;
        mysql_query($update_exercise_statement, $con);
    }
    mysql_close($con);
}

function fetchExerciseContent($exercise_id, $user_id) {
    $con = connect();
    $query = "SELECT `content` FROM `exercise` WHERE user_id=\"$user_id\" AND `id`=$exercise_id";
    $result = mysql_query($query);
    $row = mysql_fetch_array($result);
    if ($row) {
        $answer = $row['content'];
        mysql_close($con);
        return $answer;
    } else {
        mysql_close($con);
        return false;
    }
}

/**
 *
 * @param type $user_name Username
 * @param type $token Authentication Token
 * @param type $requireAuthorisation Whether the resource required administrative 
 * privileges or other advanced access rights. If set to false the parameter 
 * minimumPrivileges is inactive and may be set to any arbitrary integer value or
 * even null.
 * @param type $minimumPrivileges Minimum role
 * @return isAdmin whether the user is an administrator
 */
function authoriseUser($user_name, $token, $requireAuthorisation, $minimumPrivileges, $redirect) {
    $redirectUrlParameter = "?noredirect=true";
    if (!authorize_user($user_name, $token)) {
        if ($redirect != null) {
            $redirectUrlParameter = "?redirect=" . $redirect;
            header('Location: ' . $__BASE_URI . '/login/index.php' . $redirectUrlParameter);
            die("You are being redirect to another page...");
        } else {
            header("HTTP/1.0 401 Unauthorized");
            die("Authentication Failure!");
        }
    }
    // Check if the user is indeed an administrator - if not
    // and administrative privileges are required, 
    $user_role = getRole($_COOKIE["id"]);
    if ($requireAuthorisation && $user_role < $minimumPrivileges) {
        header('Location: ' . $__BASE_URI . '/login/index.php' . $redirectUrlParameter);
        die("You are being redirected to another page...");
    }
    if ($user_role >= 10) {
        return true;
    }
}

function doStartSession() {
    header("X-Powered-By: VLAB");
    session_start();
    if (empty($_SESSION['count'])) {
        $_SESSION['count'] = 1;
    } else {
        $_SESSION['count']++;
    }
}

function genRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';
    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters))];
    }
    return $string;
}

function clearToken($user_id) {
    $con = connect() or die('Could not connect to the database!');
    $clear_query = "DELETE FROM `token` WHERE `people_id`='$user_id'";
    mysql_query($clear_query);
    mysql_close();
}

?>
