<?php
  namespace ParkingManager;
  class MSSQL
  {
    #Variables
    public $mssql;
    private $dbc;

    public function __construct($id) {
      //Establish MySQL Conn
      $this->dbc = new MySQL;

      if(isset($id)) {
        //Start query
        $query = $this->dbc->dbc->prepare("SELECT campus FROM pm_users WHERE id = ?");
        $query->bindParam(1, $id);
        $query->execute();
        $result = $query->fetch(\PDO::FETCH_ASSOC);
        if($result['campus'] == 1) {
          //Run ANPR-MSSQL Connection (Holyhead)
        } else if($result['campus'] == 2) {
          //Run ANPR-MSSQL Connection (Holyhead)
        }
      } else {
        //Do nothing, no need to establish any connection
        //as user is not logged in.
      }
    }
  }

?>
