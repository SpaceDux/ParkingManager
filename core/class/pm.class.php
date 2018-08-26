<?php
  namespace ParkingManager;
  class PM
  {
    #Variables
    public $err;
    public $runErr;

    //Error Handler, used to gently display user based errors.
    function ErrorHandler() {
      if(isset($this->err)) {
        $this->runErr .= '<div class="alert alert-danger" role="alert">';
        $this->runErr .= '<b>Oops: </b>';
        $this->runErr .= ''.$this->err.'';
        $this->runErr .= '</div>';
        echo $this->runErr;
      }
    }
  }
?>
