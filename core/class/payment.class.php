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
    function list_services() {
      $this->mysql = new MySQL;
      $query = $this->mysql->dbc->prepare("SELECT * FROM pm_services ORDER BY service_price_gross DESC");
      $query->execute();
      $result = $query->fetchAll();

      foreach ($result as $row) {
        $table = "<tr>";
        $table .= "<td>".$row['service_name']."</td>";
        $table .= "<td>".$row['service_price_gross']."</td>";
        $table .= "<td>".$row['service_price_net']."</td>";
        $table .= "<td>".$row['service_expiry']."</td>";
        if($row['service_cash'] == 1) {
          $table .= "<td>Yes</td>";
        } else {
          $table .= "<td>No</td>";
        }
        if($row['service_card'] == 1) {
          $table .= "<td>Yes</td>";
        } else {
          $table .= "<td>No</td>";
        }
        if($row['service_account'] == 1) {
          $table .= "<td>Yes</td>";
        } else {
          $table .= "<td>No</td>";
        }
        if($row['service_snap'] == 1) {
          $table .= "<td>Yes</td>";
        } else {
          $table .= "<td>No</td>";
        }
        if($row['service_fuel'] == 1) {
          $table .= "<td>Yes</td>";
        } else {
          $table .= "<td>No</td>";
        }
        $table .= "<td>".$row['service_author']."</td>";
        $table .= "<td>".$row['service_created']."</td>";
        $table .= "<td>".$row['service_update_author']."</td>";
        $table .= "<td>".$row['service_campus']."</td>";
        $table .= '<td>
          <div class="btn-group" role="group" aria-label="Options">
            <button type="button" class="btn btn-danger"><i class="fa fa-cog"></i></button>

            <div class="btn-group" role="group">
              <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

              </button>
              <div class="dropdown-menu" aria-labelledby="OptionsDrop">
                <a class="dropdown-item" href="#">Delete Service</a>
              </div>
            </div>
          </div>
        </td>';
        $table .= "</tr>";

        echo $table;
      }
      $this->mysql = null;
    }
    function Add_Service($name, $price_gross, $price_net, $expiry, $cash, $card, $account, $snap, $fuel, $campus) {
      $this->mysql = new MySQL;
      $this->user = new User;
      $date = date("Y-m-d H:i");
      $fname = $this->user->userInfo("first_name");

      $query = $this->mysql->dbc->prepare("INSERT INTO pm_services VALUES('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $query->bindParam(1, $name);
      $query->bindParam(2, $price_gross);
      $query->bindParam(3, $price_net);
      $query->bindParam(4, $expiry);
      $query->bindParam(5, $cash);
      $query->bindParam(6, $card);
      $query->bindParam(7, $account);
      $query->bindParam(8, $snap);
      $query->bindParam(9, $fuel);
      $query->bindParam(10, $fname);
      $query->bindParam(11, $date);
      $query->bindParam(12, $fname);
      $query->bindParam(13, $campus);
      $query->execute();

      $this->mysql = null;
      $this->user = null;
    }
  }

?>
