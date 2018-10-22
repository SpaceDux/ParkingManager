<?php
  namespace ParkingManager;

  class Account
  {
    protected $mysql;
    private $user;

    function Account_ListAll()
    {
      $this->mysql = new MySQL;
      $this->user = new User;

      $html = "";

      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_accounts ORDER BY campus ASC");
      $query->execute();
      $result = $query->fetchAll();

      foreach ($result as $row) {
        if($row['account_deleted'] == 1) {
          $type = "danger";
        } else if ($row['account_suspended'] == 1) {
          $type = "warning";
        } else {
          $type = "success";
        }

        $html .= '<tr class="table-'.$type.'">';
        $html .= '<td>'.$row['account_name'].'</td>';
        $html .= '<td>'.$row['account_contact_no'].'</td>';
        $html .= '<td>'.$row['account_contact_email'].'</td>';
        $html .= '<td>'.date("d/m/y H:i", strtotime($row['account_updated'])).'</td>';
        $html .= '<td><div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                  <button type="button" class="btn btn-secondary"><i class="fa fa-cog"></i> Update</button>
                  <button type="button" class="btn btn-secondary"><i class="fa fa-truck"></i> Fleet</button>

                  <div class="btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                      <a class="dropdown-item" href="#">View Statistics</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Suspend Account</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Delete Account</a>
                    </div>
                  </div>
                </div></td>';
      $html .= '<tr>';
      }

      echo $html;

      $this->mysql = null;
      $this->user = null;
    }
  }

?>
