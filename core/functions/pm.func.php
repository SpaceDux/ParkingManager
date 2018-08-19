<?php
  namespace ParkingManager;
  class PM implements iPM
  {
    #Variables
    public $err;
    public $runErr;

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
