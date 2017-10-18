<?php
$db = new PDO("mysql:host=localhost;dbname=rkpm;", 'root', '1123');
  if(isset($_POST['veh_id']))
  {
    $stmt = $db->prepare("SELECT * FROM parking WHERE id = ?");
    $stmt->bindParam(1, $_POST['veh_id']);
    $stmt->execute();

    $result = return->$stmt->fetch();
    echo json_encode($result);
  }
?>
