<?php
$db = new PDO("mysql:host=localhost;dbname=rkpm;", 'root', '1123');

$stmt = $db->prepare("SELECT * FROM parking WHERE id = ?");
$stmt->bindParam(1, $_GET['id']);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

  
?>
<form action="update2.php" method="post">
  <input type="text" name="company" placeholder="company" value="<?php echo $result['company']?>" >
  <input type="text" name="reg" placeholder="reg" value="<?php echo $result['reg']?>">
  <br>
  <br>
  <label>
    <input type="radio" name="type" value="1" <?php if($result['type'] == 1) echo "checked" ?>>
    Cab &amp; Trailer
  </label>
  <label>
    <input type="radio" name="type" value="2" <?php if($result['type'] == 2) echo "checked" ?>>
    Cab
  </label>
  <label>
    <input type="radio" name="type" value="3" <?php if($result['type'] == 3) echo "checked" ?>>
    Trailer
  </label>
  <label>
    <input type="radio" name="type" value="4" <?php if($result['type'] == 4) echo "checked" ?>>
    Rigid
  </label>
  <label>
    <input type="radio" name="type" value="5" <?php if($result['type'] == 5) echo "checked" ?>>
    Coach
  </label>
  <label>
    <input type="radio" name="type" value="6" <?php if($result['type'] == 6) echo "checked" ?>>
    Car
  </label>
  <br>
  <br>
  <input type="text" name="timein" placeholder="time in" value="<?php echo $result['timein']?>">
  <input type="text" name="timeout" placeholder="time out" value="<?php echo $result['timeout']?>">
  <input type="text" name="tid" placeholder="ticket id" value="<?php echo $result['tid']?>">
  <input type="text" name="paid" placeholder="Paid" value="<?php echo $result['paid']?>">
  <br>
  <br>
  <textarea name="comment" placeholder="Comment..." value="<?php echo $result['comment']?>"></textarea>
  <br>
  <br>
  <label>
    <input type="radio" name="col" value="1" <?php if($result['col'] == 1) echo "checked" ?> >
    Break
  </label>
  <label>
    <input type="radio" name="col" value="2" <?php if($result['col'] == 2) echo "checked" ?>>
    Paid
  </label>
  <label>
    <input type="radio" name="col" value="3" <?php if($result['col'] == 3) echo "checked" ?>>
    Exitted
  </label>

  <input type="submit">

</form>
