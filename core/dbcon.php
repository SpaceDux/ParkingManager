<?php
try {

} catch(PDOException $e) {
  die("Failed to Connect: " . $e->getMessage());
}
?>
