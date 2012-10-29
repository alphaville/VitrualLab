<?php

class User {

    private $un;
    private $fn;
    private $ln;
    private $email;
    private $token;
    private $hash;
    private $authType;

    public function __construct() {
        
    }

    /**
     * Get the <b>username</b> of the current User object.
     */
    public function getUn() {
        return $this->un;
    }

    public function setUn($un) {
        $this->un = $un;
    }

    /**
     * Get the <b>first name</b> of the current User object.
     */
    public function getFn() {
        return $this->fn;
    }

    public function setFn($fn) {
        $this->fn = $fn;
    }

    /**
     * Get the <b>last name</b> of the current User object.
     */
    public function getLn() {
        return $this->ln;
    }

    public function setLn($ln) {
        $this->ln = $ln;
    }

    /**
     * Get the <b>email address</b> of the current User object.
     */
    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * Get the <b>authentication token</b> of the current User object.
     */
    public function getToken() {
        return $this->token;
    }

    public function setToken($token) {
        $this->token = $token;
    }

    /**
     * Get the <b>hashed password</b> of the current User object.
     */
    public function getHash() {
        return $this->hash;
    }

    public function setHash($hash) {
        $this->hash = $hash;
    }

    /**
     * Get the <b>authentication type</b> of the current User object (vlab, google,
     * yahoo).
     */
    public function getAuthType() {
        return $this->authType;
    }

    public function setAuthType($authType) {
        $this->authType = $authType;
    }

    /**
     * Logout the currect user. Unset the user-related cookies, delete
     * the user's cookies from the database.
     */
    public function logout() {
        
    }

}

?>
