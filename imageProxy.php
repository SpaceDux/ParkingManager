<?php
$img = $_GET['i'];
$ext = substr($img, -3);
switch ($ext) {
  case 'jpg':
    $mime = 'image/jpeg';
    break;
  case 'gif':
    $mime = 'image/gif';
    break;
  case 'png':
    $mime = 'image/png';
    break;
  default: $mime = false;
}
if ($mime) {
  header('Content-type: '.$mime);
header('Content-length: '.filesize($img));

$file = @fopen($img, 'rb');
  if ($file) {
    fpassthru($file);
    exit;
  }
}
?>
