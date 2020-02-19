<?php
  namespace ParkingManager;

  class User
  {
    // Vars
    protected $mysql;

    // Authorize user session(s)
    public function Login($email = '', $password = '')
    {
      global $_CONFIG;

      $this->mysql = new MySQL;
      if(!empty(strip_tags($email)) && !empty(strip_tags($password))) {
        $query = $this->mysql->dbc->prepare("SELECT Uniqueref, Email, Password FROM users WHERE Email = ?");
        $query->bindParam(1, $email);
        $query->execute();
        if($query->rowCount() > 0) {
          $result = $query->fetch(\PDO::FETCH_ASSOC);
          if(password_verify($password, $result['Password'])) {
            $_SESSION['id'] = $result['Uniqueref'];
            $date = date("Y-m-d H:i:s");
            $set = $this->mysql->dbc->prepare("UPDATE users SET Active = 1, Last_Logged = ? WHERE Uniqueref = ?");
            $set->bindParam(1, $date);
            $set->bindParam(2, $result['Uniqueref']);
            $set->execute();
            $result = [
              'Code' => '0',
              'Text' => 'Successfully logged in. You will be redirected in 3 seconds...'
            ];
          } else {
            $result = [
              'Code' => '1',
              'Text' => 'Your password doesn\'t match our records, please try again.'
            ];
          }
        } else {
          $result = [
            'Code' => '2',
            'Text' => 'We can\'t seem to find an account associated with that email address, please check your information is correct.'
          ];
        }
        $this->mysql = null;
        $this->PM = null;
      } else {
        $result = [
          'Code' => '3',
          'Text' => 'Please ensure all fields are filled.'
        ];
      }
      echo json_encode($result);
    }
    // Terminate user session & return to index
    public function Logout()
    {
      $this->mysql = new MySQL;
      $id = $_SESSION['id'];
      if(isset($_SESSION['id'])) {
        $query = $this->mysql->dbc->prepare("UPDATE users SET Active = 0 WHERE Uniqueref = ?");
        $query->bindParam(1, $id);
        $query->execute();
        session_destroy();
      }
      $this->mysql = null;
    }
    // Checks if session exists
    public function LoggedIn()
    {
      if(isset($_SESSION['id'])) {
        $return = [
          "Code" => "1"
        ];
      } else {
        $return = [
          "Code" => "0"
        ];
      }
      echo json_encode($return);
    }
    // User Info
    public function Info($what)
    {
      $this->mysql = new MySQL;

      if(isset($_SESSION['id'])) {
        $stmt = $this->mysql->dbc->prepare("SELECT * FROM users WHERE Uniqueref = ?");
        $stmt->bindParam(1, $_SESSION['id']);
        if($stmt->execute()) {
          $result = $stmt->fetch();
          return $result[$what];
        } else {
          echo "ERROR";
        }
      }

      $this->mysql = null;
    }
    function List_Users()
    {
      $this->mysql = new MySQL;
      $this->pm = new PM;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM users ORDER BY Status ASC");
      $stmt->execute();

      $html = '<table class="table table-hover table-bordered">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col">First Name</th>
                      <th scope="col">Last Name</th>
                      <th scope="col">Email</th>
                      <th scope="col">Site</th>
                      <th scope="col">Rank</th>
                      <th scope="col">Active</th>
                      <th scope="col">ANPR</th>
                      <th scope="col">Last Logged</th>
                      <th scope="col"><i class="fa fa-cog"></i></th>
                    </tr>
                  </thead>
                  <tbody>';
      foreach($stmt->fetchAll() as $row) {
        $ref = '\''.$row['Uniqueref'].'\'';
        if($row['Status'] < 1) {
          $html .= '<tr>';
        } else if($row['Status'] == 1) {
          $html .= '<tr class="table-warning">';
        } else {
          $html .= '<tr class="table-danger">';
        }
        $html .= '<td>'.$row['FirstName'].'</td>';
        $html .= '<td>'.$row['LastName'].'</td>';
        $html .= '<td>'.$row['Email'].'</td>';
        $html .= '<td>'.$this->pm->Site_Info($row['Site'], "Name").'</td>';
        $html .= '<td>'.$row['User_Rank'].'</td>';
        if($row['Active'] == 1) {
          $html .= '<td class="table-success">Yes</td>';
        } else {
          $html .= '<td class="table-danger">No</td>';
        }
        if($row['ANPR'] > 0) {
          $html .= '<td class="table-success">Enabled</td>';
        } else {
          $html .= '<td class="table-danger">Disabled</td>';
        }
        $html .= '<td>'.date("d/m/y H:i:s", strtotime($row['Last_Logged'])).'</td>';
        $html .= '<td>
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <button class="btn btn-primary" onClick="Update_User('.$ref.')"><i class="fa fa-cog"></i></button>
                    <button class="btn btn-primary" onClick="Update_Password('.$ref.')"><i class="fa fa-key"></i></button>

                    </div>
                  </td>';
      }

      $html .= '</tbody></table>';

      return $html;

      $this->mysql = null;
      $this->pm = null;
    }
    function Register($Data)
    {
      $this->mysql = new MySQL;

      $Uniqueref = date("YmdHis").mt_rand(1111, 9999);
      $Time = date("Y-m-d H:i:s");

      if($Data['Password'] === $Data['ConfPassword']) {
        $stmt = $this->mysql->dbc->prepare("INSERT INTO users VALUES('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindValue(1, $Uniqueref);
        $stmt->bindValue(2, $Data['FirstName']);
        $stmt->bindValue(3, $Data['LastName']);
        $stmt->bindValue(4, $Data['Email']);
        $stmt->bindValue(5, password_hash($Data['Password'], PASSWORD_BCRYPT));
        $stmt->bindValue(6, $Data['ANPR']);
        $stmt->bindValue(7, $Data['Rank']);
        $stmt->bindValue(8, $Data['Site']);
        $stmt->bindValue(9, "0");
        $stmt->bindValue(10, $Time);
        $stmt->bindValue(11, $Data['Printer']);
        $stmt->bindValue(12, $Data['Status']);
        $stmt->bindValue(13, $Time);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
          $result = array('Result' => '1', 'Message' => 'User has successfully been registered to ParkingManager');
        } else {
          $result = array('Result' => '0', 'Message' => 'User has not been registered to ParkingManager. Please try again.');
        }
      } else {
        $result = array('Result' => '0', 'Message' => 'User has not been added, please check the passwords match up.');
      }

      echo json_encode($result);

      $this->mysql = null;
    }
    function Update_GET($Ref)
    {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM users WHERE Uniqueref = ?");
      $stmt->bindParam(1, $Ref);
      $stmt->execute();

      $result = $stmt->fetch(\PDO::FETCH_ASSOC);


      echo json_encode($result);

      $this->mysql = new MySQL;
    }
    function Update($Data)
    {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("UPDATE users SET FirstName = ?, LastName = ?, Email = ?, Site = ?, ANPR = ?, User_Rank = ?, Printer = ?, Status = ? WHERE Uniqueref = ?");
      $stmt->bindValue(1, $Data['FirstName']);
      $stmt->bindValue(2, $Data['LastName']);
      $stmt->bindValue(3, $Data['Email']);
      $stmt->bindValue(4, $Data['Site']);
      $stmt->bindValue(5, $Data['ANPR']);
      $stmt->bindValue(6, $Data['Rank']);
      $stmt->bindValue(7, $Data['Printer']);
      $stmt->bindValue(8, $Data['Status']);
      $stmt->bindValue(9, $Data['Ref']);
      $stmt->execute();
      if($stmt->rowCount() > 0) {
        $result = array('Result' => '1', 'Message' => 'User has successfully been updated.');
      } else {
        $result = array('Result' => '0', 'Message' => 'User has not been updated. Please try again.');
      }

      echo json_encode($result);

      $this->mysql = null;
    }
    function UpdatePW($Ref, $Password, $ConfPass)
    {
      $this->mysql = new MySQL;

      if($Password === $ConfPass) {
        $stmt = $this->mysql->dbc->prepare("UPDATE users SET Password = ? WHERE Uniqueref = ?");
        $stmt->bindValue(1, password_hash($Password, PASSWORD_BCRYPT));
        $stmt->bindValue(2, $Ref);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
          $result = array('Result' => '1', 'Message' => 'User has successfully been updated.');
        } else {
          $result = array('Result' => '0', 'Message' => 'User has not been updated. Please try again.');
        }
      } else {
        $result = array('Result' => '0', 'Message' => 'Please ensure passwords match.');
      }


      echo json_encode($result);

      $this->mysql = null;
    }
  }

?>
