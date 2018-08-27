<?php
  require(__DIR__.'/global.php');
  $page = isset($_GET['p'])?$_GET['p']:'';

  if($page == "exit") {
    global $mysql;
    $date = date("Y-m-d H:i:s");
    $query = $mysql->dbc->prepare("UPDATE veh_log SET veh_column = '3', veh_timeout = ? WHERE id = ?");
    $query->bindParam(1, $date);
    $query->bindParam(2, $_POST['veh_id']);
    $query->execute();
  }
?>
