<?php

class Statistics {

    private function __construct() {
        
    }
    
    public static function countRSS(){
        require_once(realpath($_SERVER['DOCUMENT_ROOT'])."/database.php");
        $con = connect();
        $query = "SELECT count_rss() AS `rss_count`";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);        
        $rss_count = $row['rss_count'];                
        mysql_close($con);
        return $rss_count;
    }
    
    public static function countUsers(){
        require_once(realpath($_SERVER['DOCUMENT_ROOT'])."/database.php");
        $con = connect();
        $query = "SELECT count_users() AS `u_count`";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);
        $rss_count = $row['u_count'];
        mysql_close($con);
        return $rss_count;
    }
    
    public static function countExercises(){
        require_once(realpath($_SERVER['DOCUMENT_ROOT'])."/database.php");
        $con = connect();
        $query = "SELECT count_exercises() AS `exercises_count`";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);
        $rss_count = $row['exercises_count'];
        mysql_close($con);
        return $rss_count;
    }
}
?>
