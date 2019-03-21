<?php
  namespace ParkingManager;

  class User
  {
    #Variables
    protected $mysql;
    private $PM;

    //Login Authentication
    function Login($email, $pass) {
      $this->mysql = new MySQL;
      $this->PM = new PM;
      if (!empty(strip_tags($email)) && !empty(strip_tags($pass))) {
        $query = $this->mysql->dbc->prepare("SELECT * FROM pm_users WHERE email = ?");
        $query->bindParam(1, $email);
        $query->execute();
        if($query->rowCount() > 0) {
          $result = $query->fetch(\PDO::FETCH_ASSOC);
          if(password_verify($pass, $result['password'])) {
            $_SESSION['id'] = $result['id'];
            $set = $this->mysql->dbc->prepare("UPDATE pm_users SET active = 1, last_log = ? WHERE id = ?");
            $set->bindParam(1, date("Y-m-d H:i:s"));
            $set->bindParam(2, $_SESSION['id']);
            $set->execute();
            header('Location: main');
          } else {
            $this->PM->err = 'your password does not match up with our records, please try again';
            return $this->PM->ErrorHandler();
          }
        } else {
          $this->PM->err = 'we can\'t seem to find that account in our records, please try again';
          return $this->PM->ErrorHandler();
        }
        $this->mysql = null;
        $this->PM = null;
      }
    }
    //Logout User, kill session
    function Logout() {
      $this->mysql = new MySQL;
      if(isset($_SESSION['id'])) {
        $query = $this->mysql->dbc->prepare("UPDATE pm_users SET active = 0 WHERE id = ?");
        $query->bindParam(1, $_SESSION['id']);
        $query->execute();
        session_destroy();
        $this->mysql = null;
        header('Location: index');
      } else {
        header('Location: index');
      }
    }
    //Check user hasn't been forced to logout, and do as needed
    function forceLogout() {
      $this->mysql = new MySQL;
      if(isset($_SESSION['id'])) {
        $query = $this->mysql->dbc->prepare("SELECT active FROM pm_users WHERE id = ?");
        $query->bindParam(1, $_SESSION['id']);
        $query->execute();
        $result = $query->fetch(\PDO::FETCH_ASSOC);
        $this->mysql = null;
        if ($result['active'] < 1) {
          session_destroy();
          header('Location: index');
        }
      }
    }
    //Check User has a valid session
    function isLogged() {
      if(isset($_SESSION['id'])) {
        return TRUE;
      } else {
        return FALSE;
      }
    }
    //Get User Details
    function userInfo($key) {
      $this->mysql = new MySQL;
      if(!empty($key)) {
        if(isset($_SESSION['id'])) {
          $query = $this->mysql->dbc->prepare("SELECT * FROM pm_users WHERE id = ?");
          $query->bindParam(1, $_SESSION['id']);
          if($query->execute()) {
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            return $result[$key];
          }
        }
      }
      $this->mysql = null;
    }
    //Lists all users
    function ListUsers() {
      $this->mysql = new MySQL;
      $this->pm = new PM;
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_users ORDER BY rank ASC");
      $query->execute();
      $result = $query->fetchAll();

      foreach ($result as $row) {
        $table = "<tr>";
        $table .= "<td>".$row['first_name']."</td>";
        $table .= "<td>".$row['last_name']."</td>";
        $table .= "<td>".$row['email']."</td>";
        if($row['anpr'] == 1) {
          $table .= "<td>Yes</td>";
        } else {
          $table .= "<td>No</td>";
        }
        $table .= "<td>".$this->pm->PM_RankInfo($row['rank'], "rank_name")."</td>";
        $table .= "<td>".$this->pm->PM_SiteInfo($row['campus'], "site_name")."</td>";
        if($row['active'] == 1) {
          $table .= "<td>Yes</td>";
        } else {
          $table .= "<td>No</td>";
        }
        $table .= "<td>".date("d/m/y H:i", strtotime($row['last_log']))."</td>";
        $table .= '<td>
          <div class="btn-group" role="group" aria-label="Options">
            <button type="button" id="User_Update" data-id="'.$row['id'].'" class="btn btn-danger"><i class="fa fa-cog"></i></button>

            <div class="btn-group" role="group">
              <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              </button>
              <div class="dropdown-menu" aria-labelledby="OptionsDrop">
                <a class="dropdown-item" onClick="User_Delete('.$row['id'].')" href="#">Delete User</a>
                <a class="dropdown-item" onClick="Force_Logout('.$row['id'].')" href="#">Force Logout</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" onClick="Change_User_Password('.$row['id'].')" href="#">Change Password</a>
              </div>
            </div>
          </div>
        </td>';
        $table .= "</tr>";

        echo $table;
      }

      $this->mysql = null;
      $this->pm = null;
    }
    //Check auth level
    function redirectRank($key) {
      $rank = $this->userInfo("rank");
      if($rank >= $key) {
        //Do nothing
      } else {
        header("Location: index");
        die("NO ACCESS GRANTED");
      }
    }
    //Update User GET
    function Update_User_Get($key) {
      $this->mysql = new MySQL;
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_users WHERE id = ?");
      $query->bindParam(1, $key);
      $query->execute();
      $result = $query->fetch(\PDO::FETCH_ASSOC);

      echo json_encode($result);
      $this->mysql = null;
    }
    //Update User Details
    function Update_User($id, $first_name, $last_name, $email, $campus, $anpr, $rank, $printer) {
      $this->mysql = new MySQL;
      if(isset($id)) {
        $query = $this->mysql->dbc->prepare("UPDATE pm_users SET first_name = ?, last_name = ?, email = ?, campus = ?, anpr = ?, rank = ?, printer = ? WHERE id = ?");
        $query->bindParam(1, $first_name);
        $query->bindParam(2, $last_name);
        $query->bindParam(3, $email);
        $query->bindParam(4, $campus);
        $query->bindParam(5, $anpr);
        $query->bindParam(6, $rank);
        $query->bindParam(7, $printer);
        $query->bindParam(8, $id);
        $query->execute();
      }
      $this->mysql = null;
    }
    //Register User
    function Register_User($first_name, $last_name, $email, $password, $campus, $anpr, $rank) {
      $this->mysql = new MySQL;
      if(isset($password)) {
        $query = $this->mysql->dbc->prepare("INSERT INTO pm_users (first_name, last_name, email, password, anpr, rank, campus, active, last_log) VALUES (?, ?, ?, ?, ?, ?, ?, '0', ?)");
        $query->bindParam(1, $first_name);
        $query->bindParam(2, $last_name);
        $query->bindParam(3, $email);
        $query->bindParam(4, password_hash($password, PASSWORD_BCRYPT));
        $query->bindParam(5, $campus);
        $query->bindParam(6, $anpr);
        $query->bindParam(7, $rank);
        $query->bindParam(8, date("Y-m-d H:i:s"));
        $query->execute();
      } else {

      }
      $this->mysql = null;
    }
    //User delete
    function User_Delete($id) {
      $this->mysql = new MySQL;
      $query = $this->mysql->dbc->prepare("DELETE FROM pm_users WHERE id = ?");
      $query->bindParam(1, $id);
      $query->execute();

      $this->mysql = null;
    }
    //Force USER Logout
    function adminLogout($id) {
      $this->mysql = new MySQL;
      $query = $this->mysql->dbc->prepare("UPDATE pm_users SET active = 0 WHERE id = ?");
      $query->bindParam(1, $id);
      $query->execute();

      $this->mysql = null;
    }
    //Admin change users pw
    function adminChangePW($id, $pw) {
      $this->mysql = new MySQL;

      $new_pass = password_hash($pw, PASSWORD_BCRYPT);

      $stmt = $this->mysql->dbc->prepare("UPDATE pm_users SET password = ? WHERE id = ?");
      $stmt->bindParam(1, $new_pass);
      $stmt->bindParam(2, $id);
      $stmt->execute();

      $this->mysql = null;
    }
    function User_FastUpdate($id, $what, $value) {
      $this->mysql = new MySQL;
      
        $stmt = $this->mysql->dbc->prepare("UPDATE pm_users SET $what = ? WHERE id = ?");
        $stmt->bindParam(1, $value);
        $stmt->bindParam(2, $id);
        $stmt->execute();

      $this->mysql = null;
    }
  }
?>
