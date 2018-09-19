<?php
  namespace ParkingManager;

  class Payment
  {
    #Variables
    protected $mysql;
    private $user;
    private $vehicle;
    private $campus;

    function listTransactions() {
      //Prep Class'
      $this->mysql = new MySQL;
      $this->user = new User;
      $this->campus = $this->user->userInfo("campus");
      //Query
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_payments WHERE campus = ? ORDER BY service_date DESC");
      $query->bindParam(1, $this->campus);
      $query->execute();
      $result = $query->fetchAll();
      foreach ($result as $row) {
        $table = "<tr>";
        $table .= "<td>".$row['charge_type']."</td>";
        $table .= "<td>".$row['driver']."</td>";
        $table .= "<td>".$row['registration']."</td>";
        $table .= "<td>".$row['service_date']."</td>";
        $table .= "<td>".$row['service_type']."</td>";
        $table .= "<td>".$row['service_gross']."</td>";
        $table .= "<td>".$row['service_gross']."</td>";
        $table .= "<td>".$row['account']."</td>";
        $table .= "<td>".$row['id']."</td>";
        $table .= '<td>
          <div class="btn-group" role="group" aria-label="Options">
            <button type="button" class="btn btn-danger"><i class="fa fa-cog"></i></button>

            <div class="btn-group" role="group">
              <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

              </button>
              <div class="dropdown-menu" aria-labelledby="OptionsDrop">
                <a class="dropdown-item" href="#">Delete Transaction</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Reprint Ticket</a>
              </div>
            </div>
          </div>
        </td>';
        $table .= "</tr>";

        echo $table;
      }
      $this->mysql = null;
      $this->user = null;
      $this->campus = null;
    }
    //Get All transactions for the logged vehicle
    function getTransactions($key) {
      //Prep Class
      $this->mysql = new MySQL;
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_payments WHERE log_id = ?");
      $query->bindParam(1, $key);
      $query->execute();
      $result = $query->fetchAll();
      $this->mysql = null;
    }
  }

?>
