<?php

class Status {
    
    private $thestatus;
        
    private static $__map = array(
        0=>"Draft",
        1=>"Initial Submission",
        2=>"Final Submission by you",
        3=>"Under Review by Prof.",
        4=>"Evaluated"
    );
    
    public function getStatusText(){
        return Status::$__map[$this->thestatus];
    }
    
    public function setStatus($status){
        $this->thestatus = $status;
    }
    
    public function __construct() {
        $this->thestatus = 0;
    }
    
    
    
    
    
}
?>
