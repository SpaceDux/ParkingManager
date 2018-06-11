<?php
  require __DIR__.'/manage/config.php';
  class ParkingManager {
    function fetchNotices() {
      global $dbConn;
      $stmt = $dbConn->prepare("SELECT * FROM notices WHERE active = 1 ORDER BY id DESC");
      $stmt->execute();
      return $stmt->fetchAll();
    }
    function newNotice($short, $body, $type) {
      global $dbConn;
      $short = strtoupper($short);
      $stmt = $dbConn->prepare("INSERT INTO notices VALUES ('', ?, ?, '1', ?)");
      $stmt->bindParam(1, $short);
      $stmt->bindParam(2, $body);
      $stmt->bindParam(3, $type);
      $stmt->execute();
    }
    function regUser($first, $second, $email, $password, $rank) {
      global $dbConn;
      $password = password_hash($password, PASSWORD_BCRYPT);
      $sql = "INSERT INTO users VALUES ('', ?, ?, ?, ?, ?)";
      $stmt = $dbConn->prepare($sql);
      $stmt->bindParam(1, $first);
      $stmt->bindParam(2, $second);
      $stmt->bindParam(3, $email);
      $stmt->bindParam(4, $password);
      $stmt->bindParam(5, $rank);
      $stmt->execute();
    }
    function fetchUsers() {
      global $dbConn;
      $stmt = $dbConn->prepare("SELECT * FROM users ORDER BY id");
      $stmt->execute();

      return $stmt->fetchAll();
    }
    function Login($first, $pass) {
      $first = $_POST['log_firstName'];
      $pass = $_POST['log_password'];
      global $dbConn;
      $stmt = $dbConn->prepare("SELECT * FROM users WHERE first_name = ?");
      $stmt->bindParam(1, $first);
      $stmt->execute();
      $return = $stmt->fetch(PDO::FETCH_ASSOC);
    }
  }

?>
