<?php

require_once("../database.php");
require_once("./Status.php");

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
        if (empty($this->mark)) {
            return "Pending";
        }
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
        $s = new Status();
        $s->setStatus($this->status);
        return $s;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getComments() {
         if (empty($this->comments)) {
            return "No comments yet.";
        }
        return $this->comments;
    }

    public function setComments($comments) {
        $this->comments = $comments;
    }

    public function getSumbission_time() {
        if (empty($this->sumbission_time)) {
            return "Not Submitted";
        }
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

    public static function fetchExerciseByID($exercise_id) {
        $xrc = new Exercise();
        $con = connect();
        $query = "SELECT `id`,`content`,`creation_date`,`mark`,`user_id`,`status`,`comments`,`submission_time`,`type`,`last_update_time`
                                from `exercise` 
                                where id='$exercise_id'";
        $result = mysql_query($query, $con);
        $row = mysql_fetch_array($result);
        $xrc->setContent($row['content']);
        $xrc->setComments($row['comments']);
        $xrc->setCreation_date($row['creation_date']);
        $xrc->setId($exercise_id);
        $xrc->setLast_update_time($row['last_update_time']);
        $xrc->setMark($row['mark']);
        $xrc->setStatus($row['status']);
        $xrc->setSumbission_time($row['submission_time']);
        $xrc->setType($row['type']);
        $xrc->setUser_id($row['user_id']);
        mysql_close($con);
        return $xrc;
    }

}

?>
