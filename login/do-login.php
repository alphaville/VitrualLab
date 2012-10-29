<?php
require '../global.php';
require '../lightopenid-lightopenid/openid.php';
$openid = new LightOpenID($__DOMAIN_NAME__);
$logintype = $_GET['login'];
if (isset($logintype)) {
    /*
     * GOOGLE LOGIN
     */
    if ($logintype == 'google') {
        $openid->identity = 'https://www.google.com/accounts/o8/id';
        $openid->returnUrl = $__URL__."/login/profile.php?what=return&authtype=google";
        $endpoint = $openid->discover('https://www.google.com/accounts/o8/id');
        $fields =
                '?openid.ns=' . urlencode('http://specs.openid.net/auth/2.0') .
                '&openid.realm=' . urlencode($__URL__) .
                '&openid.return_to=' . urlencode($openid->returnUrl) .
                '&openid.claimed_id=' . urlencode('http://specs.openid.net/auth/2.0/identifier_select') .
                '&openid.identity=' . urlencode('http://specs.openid.net/auth/2.0/identifier_select') .
                '&openid.mode=' . urlencode('checkid_setup') .
                '&openid.ns.ax=' . urlencode('http://openid.net/srv/ax/1.0') .
                '&openid.ax.mode=' . urlencode('fetch_request') .
                '&openid.ax.required=' . urlencode('email,firstname,lastname') .
                '&openid.ax.type.firstname=' . urlencode('http://axschema.org/namePerson/first') .
                '&openid.ax.type.lastname=' . urlencode('http://axschema.org/namePerson/last') .
                '&openid.ax.type.email=' . urlencode('http://axschema.org/contact/email');
        header('Location: ' . $endpoint . $fields); //step 5
    }
    /*
     * YAHOO LOGIN
     */ else if ($logintype == 'yahoo') {                 
        try {
            $openid->required = array('contact/email');
            $openid->optional = array('namePerson', 'namePerson/friendly', 'birthDate', 'person/gender'); //
            $openid->returnUrl = $__URL__."/login/profile.php?what=return&authtype=yahoo";
            if (!$openid->mode) {
                $openid->identity = 'me.yahoo.com';
                header('Location: ' . $openid->authUrl() );
            } elseif ($openid->mode == 'cancel') {
                echo 'User has canceled authentication!';
            } else {
                echo 'User ' . ($openid->validate() ? $openid->identity . ' has ' : 'has not ') . 'logged in.';
                print_r($openid->getAttributes());
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
}
?>

