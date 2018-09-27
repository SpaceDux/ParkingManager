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
    public function displayNotice() {
      //Have to issue a connection
      $this->mysql = new MySQL;
      $this->user = new User;
      //Get User  Campus
      $this->campus = $this->user->userInfo("campus");

      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_notices WHERE campus = ?");
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

      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_notices WHERE campus = ?");
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

        $query = $this->mysql->dbc->prepare("INSERT INTO pm_notices VALUES ('', ?, ?, ?, ?, ?)");
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
    public function PM_Nav() {
      $this->user = new User;

      //Top Bar
      $nav ='<nav class="topBar">';
      $nav .=  '<a href="'.URL.'/index">';
      $nav .=  '<div class="brand">';
      $nav .=    'Parking<b>Manager</b>';
      $nav .=  '</div>';
      $nav .=  '</a>';
      $nav .=  '<ul>';
      $nav .=    '<a onClick="menuHide()"><li><i class="fas fa-align-justify"></i></li></a>';
      $nav .=    '<li data-toggle="modal" data-target="#searchModal"><i class="fa fa-search"></i></li>';
      $nav .=    '<li data-toggle="modal" data-target="#ANPR_AddModal"><i class="fa fa-plus"></i></li>';
      $nav .=    '<li onClick="ANPR_Barrier(1)" title="Toggle Entry Barrier"><i class="fa fa-arrow-right"></i></li>';
      $nav .=    '<li onClick="ANPR_Barrier(0)" title="Toggle Exit Barrier"><i class="fa fa-arrow-left"></i></li>';
      $nav .=  '</ul>';
      $nav .='</nav>';

      //Main Nav
      $nav .='<nav id="sideBar" style="margin-left: -220px;">';
        //UserBox
      $nav .=  '<div class="userBox">';
      $nav .=    '<div class="userInfo">';
      $nav .=      '<div class="userName">'.$this->user->userInfo('first_name').' <b>'.substr($this->user->userInfo('last_name'), 0, 1).'</b></div>';
      $nav .=      '<div class="userLocation">';
      $nav .=        $this->PM_CampusInfo($this->user->userInfo("campus"), "campus_name");
      $nav .=      '</div>';
      $nav .=      '<div class="pmVer">'.VER.'</div>';
      $nav .=    '</div>';
      $nav .=    '<div class="buttons">';
      $nav .=      '<a href="#settings"><i class="fa fa-cog"></i></a>';
      $nav .=      '<a href="'.URL.'/logout"><i class="fa fa-sign-out-alt"></i></a>';
      $nav .=    '</div>';
      $nav .=   '</div>';
        //Options
      $nav .=  '<ul>';
      $nav .=    '<a href="'.URL.'/main"><li><i class="fa fa-tachometer-alt"></i> Dashboard</li></a>';
      $nav .=    '<li><i class="fa fa-truck-moving"></i> Vehicle Tools';
      $nav .=     ' <ul>';
      $nav .=        '<a href="'.URL.'/yardcheck" target="_blank"><li>Yard Check</li></a>';
      $nav .=      '</ul>';
      $nav .=    '</li>';
      $nav .=    '<li><i class="fa fa-pound-sign"></i> Payment Tools';
      $nav .=     ' <ul>';
      $nav .=        '<a href="'.URL.'/reports"><li>Transactions History</li></a>';
      $nav .=      '</ul>';
      $nav .=    '</li>';
      $nav .=    '<li><i class="fa fa-book"></i> Account Tools';
      $nav .=      '<ul>';
      $nav .=        '<a href="'.URL.'/reports"><li>Account Reports</li></a>';
      $nav .=        '<a href="'.URL.'/reports"><li>Account Fleets</li></a>';
      $nav .=      '</ul>';
      $nav .=    '</li>';
      $nav .=    '<li><i class="fa fa-cogs"></i> P<b>M</b> Tools';
      $nav .=      '<ul>';
      $nav .=        '<a href="'.URL.'/notices"><li>Notices</li></a>';
      if($this->user->userInfo("rank") > 1) {
        $nav .= '<a href="'.URL.'/users"><li>Users</li></a>';
      }
      $nav .=      '</ul>';
      $nav .=    '</li>';
      if($this->user->userInfo("rank") > 2) {
        $nav .=    '<li><i class="fa fa-chart-line"></i> Admin Tools';
        $nav .=      '<ul>';
        $nav .=        '<a href="'.URL.'/services"><li>Services</li></a>';
        $nav .=      '</ul>';
        $nav .=    '</li>';
      }
      $nav .=  '</ul>';
      $nav .='</nav>';

      echo $nav;

      $this->user = null;
    }
    function PM_CampusSelectList() {
      $this->mysql = new MySQL;

      $list = '';
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_campus ORDER BY id ASC");
      $query->execute();
      $result = $query->fetchAll();
      foreach ($result as $row) {
        $list .= '<option value="'.$row['id'].'">'.$row['campus_name'].'</option>';
      }
      echo $list;
      $this->mysql = null;
    }
    function PM_RankSelectList() {
      $this->mysql = new MySQL;

      $list = '';
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_ranks ORDER BY id ASC");
      $query->execute();
      $result = $query->fetchAll();
      foreach ($result as $row) {
        $list .= '<option value="'.$row['id'].'">'.$row['rank_name'].'</option>';
      }
      echo $list;
      $this->mysql = null;
    }
    function PM_CampusInfo($id, $key) {
      $this->mysql = new MySQL;

      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_campus WHERE id = ?");
      $query->bindParam(1, $id);
      $query->execute();
      $result = $query->fetch(\PDO::FETCH_ASSOC);

      return $result[$key];
      $this->mysql = null;
    }
    function PM_RankInfo($id, $key) {
      $this->mysql = new MySQL;

      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_ranks WHERE id = ?");
      $query->bindParam(1, $id);
      $query->execute();
      $result = $query->fetch(\PDO::FETCH_ASSOC);

      return $result[$key];
      $this->mysql = null;
    }
  }
?>
