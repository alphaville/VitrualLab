<?php
function connect() {
    require("/var/www/vlab/global.php");
    $con = mysql_connect($__DATABASE_URL__, $__DATABASE_USER__, $__DATABASE_PWD__);
    if (!$con) {
        return null;
    }
    mysql_query("use " . $__DATABASE_NAME__);    
    return $con;
}

function connectAsMySQLi(){
    require("/var/www/vlab/global.php");
    return new mysqli($__DATABASE_URL__, $__DATABASE_USER__, $__DATABASE_PWD__, $__DATABASE_NAME__);
}

function authorize_user($id, $token) {
    $con = connect();
    if (!$con) {
        die("66::MySQL connectivity error : " . mysql_error());
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
        die("70::MySQL connectivity error : " . mysql_error());
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
        die("80::MySQL connectivity error : " . mysql_error());
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
        die("332::MySQL connectivity error : " . mysql_error());
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
        die('87::Could not connect: ' . mysql_error());
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
        die('88::Could not connect: ' . mysql_error());
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
            die("111::You are being redirect to another page...");
        } else {
            header("HTTP/1.0 401 Unauthorized");
            die("112::Authentication Failure!");
        }
    }
    // Check if the user is indeed an administrator - if not
    // and administrative privileges are required, 
    $user_role = getRole($_COOKIE["id"]);
    if ($requireAuthorisation && $user_role < $minimumPrivileges) {
        header('Location: ' . $__BASE_URI . '/login/index.php' . $redirectUrlParameter);
        die("155::You are being redirected to another page...");
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
    $con = connect() or die('143::Could not connect to the database!');
    $clear_query = "DELETE FROM `token` WHERE `people_id`='$user_id'";
    mysql_query($clear_query);
    mysql_close();
}

function deleteExerciseById($exercise_id_delete){
    $con = connect() or die('144::Could not connect to the database!');
    $delete_exercise_query = "DELETE FROM `exercise` WHERE `id`='$exercise_id_delete'";
    mysql_query($delete_exercise_query );
    mysql_close();
}

/**
 * Returns true if the user with id user_id has read the
 * message with id message_id
 * 
 * @param type $message_id 
 * @param type $user_id
 */
function haveIReadThisMessage($message_id, $user_id){
    if (is_null($message_id) || is_null($user_id)) die('145::Bad parametrisation');
    // Get the recipient of the message - is it me or everybody?
    $con = connect() or die('199::Could not connect to the database!');
    $query = "SELECT `rcpt_to`, `isRead` FROM `message` WHERE id=$message_id";
    $result = mysql_query($query);
    if (!$result) return false;
    $row = mysql_fetch_array($result);    
    $recipient = $row['rcpt_to'];
    mysql_close();
    if (strcmp($recipient,$user_id)==0){
        return $row['isRead'];
    }else if (strcmp($recipient,"everybody")==0){
        $con = connect() or die('200::Could not connect to the database!');
        $query = "SELECT COUNT(*) FROM `haveReadAnnouncement` WHERE people_id='$user_id' AND message_id='$message_id'";
        $result = mysql_query($query);
        $count1 = mysql_result($result,0);
        if ($count1>0) return true;
        mysql_close();
    }
    return false;
}

/**
 * Updates the database 
 * @param type $message_id
 * @param type $user_id 
 */
function IHaveReadThisMessage($message_id, $user_id){
    if (is_null($message_id) || is_null($user_id)) die('858::Bad parametrisation');
    $con = connect() or die('899::Could not connect to the database!');
    $query = "SELECT `rcpt_to`, `isRead` FROM `message` WHERE id=$message_id";
    $result = mysql_query($query);
    if (!$result) return false;
    $row = mysql_fetch_array($result);    
    $recipient = $row['rcpt_to'];
    $is_read_by_me = $row['isRead'];
    mysql_close();
    
    if (strcmp($recipient,$user_id)==0){
        if ($is_read_by_me){
            return;
        }
        $con = connect() or die('760::Could not connect to the database!');
        $query = "UPDATE `message` SET isRead=1 WHERE `id`=$message_id AND `rcpt_to`='$user_id'";
        mysql_query($query );
        mysql_close();
    }else if (strcmp($recipient,"everybody")==0){
        $con = connect() or die('761::Could not connect to the database!');
        $query = "INSERT INTO `haveReadAnnouncement` (`people_id`, `message_id`) VALUES ('$user_id', $message_id);";
        mysql_query($query);
        mysql_close();
    }
}

function countUnread($user_id){
    $mysqli = connectAsMySQLi();
    if (!$mysqli->query("SET @msg = ''") || !$mysqli->query("CALL count_unread(@msg,'$user_id')")) 
        echo "The CALL failed: (" . $mysqli->errno . ") " . $mysqli->error;    
    if (!($res = $mysqli->query("SELECT @msg as _p_out"))) 
        echo "Fetch failed: (" . $mysqli->errno . ") " . $mysqli->error;    
    $row = $res->fetch_assoc();
    $mysqli->close();
    return $row['_p_out'];
}

?>
