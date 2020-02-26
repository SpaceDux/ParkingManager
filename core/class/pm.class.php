<?php
  namespace ParkingManager;

  class PM
  {
    protected $mysql;

    // List Sites (AS HTML Select's)
    function PM_ListSitesAsSelect()
    {
      $this->mysql = new MySQL;

      $html = '';

      $stmt = $this->mysql->dbc->prepare("SELECT id, SiteName FROM settings WHERE Status = 0");
      $stmt->execute();
      foreach($stmt->fetchAll() as $row) {
        $html .= '<option value="'.$row['id'].'">'.$row['SiteName'].'</option>';
      }

      return $html;

      $this->mysql = null;
    }
  }

?>
