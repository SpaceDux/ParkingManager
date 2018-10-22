<?php
  require(__DIR__.'/global.php');
  $key = $_GET['id'];
  $row = $vehicles->getVehicle($key);
  //Call on updateVehicle() Function
  $vehicles->updateVehicle($key);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Parking Manager: Update | <?php echo $row['parked_plate'] ?></title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/theme.css">
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/fontawesome-all.min.css">
  </head>
  <body>
    <?php $pm->PM_Nav() ?>
    <!-- Wrapper / Main content -->
    <div id="wrapper">
      <div class="whereami">
        <div class="page">
          <a href="<?php echo URL ?>/index">Dashboard</a> <small>\\\</small> Update <small>\\\</small> <b><?php echo $row['parked_plate']?></b>
          <div class="float-right">
            <?php $vehicles->timeCalc($row['parked_timein'], $row['parked_timeout']);?>
          </div>
        </div>
      </div>
      <div class="updateContent">
        <div class="container">
          <form method="post" id="update">
          <div class="row">
            <div class="col">
              <?php $vehicles->isFlagged($row['parked_flag'])?>
              <?php $vehicles->isDeleted($row['parked_deleted'])?>
              <div class="form-group">
                <label for="upd_company">Company Name</label>
                <input type="text" class="form-control" name="upd_company" id="upd_company" placeholder="Company..." value="<?php echo $row['parked_company'] ?>">
              </div>
              <div class="form-group">
                <label for="upd_reg">Registration</label>
                <input type="text" class="form-control" name="upd_reg" id="upd_reg" placeholder="Vehicle Registration" value="<?php echo $row['parked_plate'] ?>">
              </div>
              <div class="form-group">
                <label for="upd_trl">Trailer Number</label>
                <input type="text" class="form-control" name="upd_trl" id="upd_trl" placeholder="Trailer Number" value="<?php echo $row['parked_trailer'] ?>">
              </div>
              <div class="form-group">
                <label>Type of Vehicle</label>
                <input type="hidden" id="hidden_veh_type" value="<?php echo $row['parked_type'] ?>">
                <select class="form-control" name="upd_type" id="upd_type">
                  <?php $pm->PM_VehicleTypes_Dropdown(); ?>
                </select>
              </div>
              <div class="form-group">
                <?php $anpr->ANPR_GetImage($row['parked_anprkey']);?>
              </div>
            </div>
            <div class="col">
              <table class="table table-striped table-dark text-center">
                <thead>
                  <tr>
                    <th scope="col">Payment Type</th>
                    <th scope="col">Service Name</th>
                    <th scope="col">Service Date</th>
                    <th scope="col">
                      <div class="btn-group" role="group" aria-label="Button Group">
                        <a href="<?php echo URL ?>/transaction/<?php echo $row['id']?>" tabindex="-1" class="btn btn-danger btn-sm payBtn"> <i class="fas fa-pound-sign"></i> New Payment</a>
                      </div>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php $payment->getTransactions($row['payment_ref'])?>
                </tbody>
              </table>
              <div class="form-group">
                <label for="upd_timein">Time IN</label>
                <input type="text" class="form-control" id="upd_timein" name="upd_timein" placeholder="Time IN: Y-m-d H:m" value="<?php echo $row['parked_timein'] ?>">
              </div>
              <div class="form-check">
                <label class="form-check-label">
                <input class="form-check-input" type="radio" name="upd_col" value="1" <?php if($row['parked_column'] == 1) {echo "checked";}?>>
                  Paid
                </label>
              </div>
              <div class="form-check">
                <label class="form-check-label">
                <input class="form-check-input" type="radio" name="upd_col" value="2" <?php if($row['parked_column'] == 2) {echo "checked";}?>>
                  Exit
                </label>
              </div>
              <div class="form-group">
                <label for="upd_timeout">Time OUT</label>
                <input type="text" class="form-control" id="upd_timeout" name="upd_timeout" placeholder="Time OUT: Y-m-d H:m" value="<?php echo $row['parked_timeout'] ?>">
              </div>
              <div class="form-group">
                <label for="upd_comment">Comment / Notes</label>
                <textarea type="text" id="upd_comment" class="form-control" name="upd_comment" rows="3" cols="1" form="update"><?php echo $row['parked_comment'] ?></textarea>
              </div>
              <div class="btn-group float-right" role="group" aria-label="Button Group">
                <button type="submit" class="btn btn-dark"><i class="fa fa-save"></i> Save Data</button>
                <button class="btn btn-dark" id="exitButton" onClick="exit(<?php echo $key ?>)"><i class="fa fa-times"></i> Exit</button>
                <div class="btn-group" role="group">
                  <button id="btnGroupDrop1" type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                  <div class="dropdown-menu">
                      <a style="cursor: pointer" id="flagButton" class="dropdown-item" onClick="setFlag(<?php echo $key ?>)">Flag Vehicle</a>
                    <div class="dropdown-divider"></div>
                    <a style="cursor: pointer" id="deleteButton" class="dropdown-item" onClick="deleteVehicle(<?php echo $key ?>)">Delete Vehicle</a>
                  </div>
                </div>
              </div>
            </div>
          </form>
          </div>
        </div>
      </div>
      <footer>
        <?php echo Footer ?>
      </footer>
    </div>
    <?php require(__DIR__."/assets/modals.php");?>
    <!-- javascript Files -->
    <script src="<?php echo URL?>/assets/js/jquery.min.js"></script>
    <script src="<?php echo URL?>/assets/js/popper.min.js"></script>
    <script src="<?php echo URL?>/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo URL?>/assets/js/mousetrap.min.js"></script>
    <script type="text/javascript">
      $('#upd_type').val($('#hidden_veh_type').val());
    </script>
    <?php require(__DIR__."/assets/require.php");?>
  </body>
</html>
