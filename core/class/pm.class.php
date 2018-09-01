<?php
  namespace ParkingManager;
  class PM
  {
    #Variables
    public $err;
    public $runErr;
    protected $mysql;
    private $campus;
    private $user;
    private $author;

    //Error Handler, used to gently display user based errors.
    public function ErrorHandler() {
      if(isset($this->err)) {
        $this->runErr .= '<div class="alert alert-danger" role="alert">';
        $this->runErr .= '<b>Oops: </b>';
        $this->runErr .= ''.$this->err.'';
        $this->runErr .= '</div>';
        echo $this->runErr;
      }
    }
    public function openGate($key) {
      //Open Gate, key being IP Address for the gate. Using CURL
    }
    public function displayNotice() {
      //Have to issue a connection
      $this->mysql = new MySQL;
      $this->user = new User;
      //Get User  Campus
      $this->campus = $this->user->userInfo("campus");

      $query = $this->mysql->dbc->prepare("SELECT * FROM notices WHERE campus = ?");
      $query->bindParam(1, $this->campus);
      $query->execute();
      $result = $query->fetchAll();
      $this->mysql = null;
      $this->user = null;
      foreach($result as $row) {
        echo '<div style="margin-top: 10px;" class="alert alert-'.$row['notice_type'].'" role="alert"><b>'.$row['notice_title'].'</b> '.$row['notice_body'].'<br><i style="font-size: 13px;">'.$row['notice_author'].'</i></div>';
      }
      $this->mysql = null;
      $this->user = null;
      $this->campus = null;
    }
    public function listNotices() {
      //Have to issue a connection
      $this->mysql = new MySQL;
      $this->user = new User;
      //Get User  Campus
      $this->campus = $this->user->userInfo("campus");

      $query = $this->mysql->dbc->prepare("SELECT * FROM notices WHERE campus = ?");
      $query->bindParam(1, $this->campus);
      $query->execute();
      $result = $query->fetchAll();
      $this->mysql = null;
      $this->user = null;
      foreach($result as $row) {
        echo '<div class="alert alert-'.$row['notice_type'].'" role="alert"><b>'.$row['notice_title'].'</b> '.$row['notice_body'].'<br><i style="font-size: 13px;">'.$row['notice_author'].'</i><button type="button" class="close" onClick="deleteNotice('.$row['id'].')"><span aria-hidden="true">&times;</span></button></div>';
      }

      $this->mysql = null;
      $this->user = null;
      $this->campus = null;
    }
    public function newNotice($title, $body, $type) {
      if(isset($title)) {
        $this->mysql = new MySQL;
        $this->user = new User;
        $this->campus = $this->user->userInfo("campus");
        $this->author = $this->user->userInfo("first_name");

        $query = $this->mysql->dbc->prepare("INSERT INTO notices VALUES ('', ?, ?, ?, ?, ?)");
        $query->bindParam(1, $type);
        $query->bindParam(2, $title);
        $query->bindParam(3, $body);
        $query->bindParam(4, $this->author);
        $query->bindParam(5, $this->campus);
        $query->execute();

        //Null variables.
        $this->mysql = null;
        $this->user = null;
        $this->campus = null;
        $this->author = null;
      }
    }
  }
?>
