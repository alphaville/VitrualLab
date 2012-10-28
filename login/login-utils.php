<?php

include('User.php');

function authOpenID() {
    $authtype = $_GET["authtype"];
    if ($authtype == "google") {
        $fn = $_GET["openid_ext1_value_firstname"];
        $ln = $_GET["openid_ext1_value_lastname"];
        $email = $_GET["openid_ext1_value_email"];
        $id = $_GET["openid_identity"];
        $auth_uri = "http://www.google.com";
    } else if ($authtype == "yahoo") {
        $auth_uri = $id;
        $fn = $_GET["openid_ax_value_fullname"];
        $ln = "";
        $email = $_GET["openid_ax_value_email"];
        $id = $_GET["openid_identity"];
        $auth_uri = $id;
    }
    if (isset($email)) {
        $hash = md5(strtolower(trim($email)));
    }
    if (isset($fn)) {
        setcookie("id", $id, time() + 36000, "/");
        setcookie("auth", $authtype, time() + 36000, "/");
        setcookie("fn", $fn, time() + 36000, "/");
        setcookie("ln", $ln, time() + 36000, "/");
        setcookie("email", $email, time() + 36000, "/");
        setcookie("hash", $hash, time() + 36000, "/");
        // Are you new to the neighborhood???
        // Create user -- if not already a member
        $con = connect();
        if (!$con) {
            die('Could not connect: ' . mysql_error());
        } else {
            $insert_query = "INSERT IGNORE INTO people (`id`,`fn`,`ln`,`email`,`login_method`) VALUES ('" . $id . "', '" .
                    $fn . "', '" . $ln . "', '" . $email . "', '" . $authtype . "' );";
            mysql_query($insert_query, $con);
        }
        mysql_close($con);
    }
    $token = createTokenForUser($id);
    setcookie("token", $token, time() + 36000, "/");
    $myUser = new User();
    $myUser->un = $id;
    $myUser->fn = $fn;
    $myUser->ln = $ln;
    $myUser->email = $email;
    $myUser->hash = $hash;
    $myUser->authType = $authtype;
    $myUser->token = $token;   
    return $myUser;
}

function createTokenForUser($user_id) {
    // Create and store new authentication token for this user
    $con = connect(); //OPEN CONNECTION : X001
    $randomToken = genRandomString(20) . "----";
    $create_token = "INSERT INTO `token` (`token_id`,`people_id`) VALUES ('$randomToken','$user_id')";
    mysql_query($create_token);
    mysql_close($con); //CLOSE CONNECTION : X001
    setcookie("token", $token, time() + 36000, "/");
    mysql_close($con);
    return $randomToken;
}

function authMember() {
    $un = $_POST['un'];
    $pwd = $_POST['pwd'];

    $con = connect();
    mysql_select_db("vlab", $con);
    if (!$con) {
        die('Could not connect: ' . mysql_error());
    } else {
        $result = mysql_query("SELECT `fn`,`ln`,`email`,`pwd_hash_md5`,`authorization_key` 
            FROM people WHERE id='" . $un . "'");
        $row = mysql_fetch_array($result);
        $pwd_in_sql = $row['pwd_hash_md5'];
        if ((is_null($row)) || (md5($pwd) != $pwd_in_sql)) {
            // Invalid Login
            $unauthorized = true;
        } else {
            // Correct login
            $email = $row["email"];
            $fn = $row["fn"];
            $ln = $row["ln"];
            $authtype = "VLAB";
            $auth_uri = $_SERVER['HTTP_HOST'];
            $hash = md5(strtolower(trim($email)));
            //TODO: [IMPT] Update Token!!! Security Leak!!!
            $authorization_key = $row["authorization_key"];
            setcookie("id", $un, time() + 36000, "/");
            setcookie("auth", $authtype, time() + 36000, "/");
            setcookie("fn", $fn, time() + 36000, "/");
            setcookie("ln", $ln, time() + 36000, "/");
            setcookie("email", $email, time() + 36000, "/");
            setcookie("hash", $hash, time() + 36000, "/");
        }
    }
    $token = createTokenForUser($un);
    setcookie("token", $token, time() + 36000, "/");
    $myUser = new User();
    $myUser->un = $un;
    $myUser->fn = $fn;
    $myUser->ln = $ln;
    $myUser->email = $email;
    $myUser->hash = $hash;
    $myUser->authType = $authtype;
    $myUser->token = $token;
    return $myUser;
}

?>
