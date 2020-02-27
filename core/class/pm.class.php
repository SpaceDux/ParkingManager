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

    function PM_SiteInfo($Site, $What)
    {
      $this->mysql = new MySQL;

      $stmt = $this->mysql->dbc->prepare("SELECT * FROM settings WHERE id = ?");
      $stmt->bindParam(1, $Site);
      $stmt->execute();
      if($stmt->rowCount() > 0) {
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result[$What];
      } else {
        return "Unable to find";
      }

      $this->mysql = null;
    }
  }

?>
