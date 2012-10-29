<?php

class Exercise {

    private $id; //ID of the exercise (integer)
    private $content;
    private $creation_date;
    private $mark;
    private $user_id;
    private $status;
    private $comments;
    private $sumbission_time;
    private $type;
    private $last_update_time;

    public function __construct() {
        
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getCreation_date() {
        return $this->creation_date;
    }

    public function setCreation_date($creation_date) {
        $this->creation_date = $creation_date;
    }

    public function getMark() {
        return $this->mark;
    }

    public function setMark($mark) {
        $this->mark = $mark;
    }

    public function getUser_id() {
        return $this->user_id;
    }

    public function setUser_id($user_id) {
        $this->user_id = $user_id;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getComments() {
        return $this->comments;
    }

    public function setComments($comments) {
        $this->comments = $comments;
    }

    public function getSumbission_time() {
        return $this->sumbission_time;
    }

    public function setSumbission_time($sumbission_time) {
        $this->sumbission_time = $sumbission_time;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getLast_update_time() {
        return $this->last_update_time;
    }

    public function setLast_update_time($last_update_time) {
        $this->last_update_time = $last_update_time;
    }

}

?>
