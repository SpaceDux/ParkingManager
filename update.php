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
      <title>Parking Manager: Update | <?php echo $row['veh_registration'] ?></title>
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
          <a href="<?php echo URL ?>/index">Dashboard</a> <small>\\\</small> Update <small>\\\</small> <b><?php echo $row['veh_registration']?></b>
          <div class="float-right">
            <?php $vehicles->timeCalc($row['veh_timein'], $row['veh_timeout']);?>
          </div>
        </div>
      </div>
      <div class="updateContent">
        <div id="tables">
        <div class="container">
          <form method="post" id="update">
          <div class="row">
            <div class="col">
              <?php $vehicles->isFlagged($row['veh_flagged'])?>
              <?php $vehicles->isDeleted($row['veh_deleted'])?>
              <div class="form-group">
                <label for="upd_company">Company Name</label>
                <input type="text" class="form-control" name="upd_company" id="upd_company" placeholder="Company..." value="<?php echo $row['veh_company'] ?>">
              </div>
              <div class="form-group">
                <label for="upd_reg">Registration</label>
                <input type="text" class="form-control" name="upd_reg" id="upd_reg" placeholder="Vehicle Registration" value="<?php echo $row['veh_registration'] ?>">
              </div>
              <div class="form-group">
                <label for="upd_trl">Trailer Number</label>
                <input type="text" class="form-control" name="upd_trl" id="upd_trl" placeholder="Trail Number" value="<?php echo $row['veh_trlno'] ?>">
              </div>
              <div class="form-group">
              <label>Type of Vehicle</label>
                <div class="form-check">
                  <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="upd_type" id="upd_type" value="0" <?php if($row['veh_type'] == 0) {echo "checked";}?>>
                    N/A
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="upd_type" id="upd_type" value="1" <?php if($row['veh_type'] == 1) {echo "checked";}?>>
                    Cab &amp; Trailer
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="upd_type" id="upd_type" value="2" <?php if($row['veh_type'] == 2) {echo "checked";}?>>
                    Cab
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="upd_type" id="upd_type" value="3" <?php if($row['veh_type'] == 3) {echo "checked";}?>>
                    Trailer
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="upd_type" id="upd_type" value="4" <?php if($row['veh_type'] == 4) {echo "checked";}?>>
                    Rigid
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="upd_type" id="upd_type" value="5" <?php if($row['veh_type'] == 5) {echo "checked";}?>>
                    Coach
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="upd_type" id="upd_type" value="6" <?php if($row['veh_type'] == 6) {echo "checked";}?>>
                    Car
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="upd_type" id="upd_type" value="7" <?php if($row['veh_type'] == 7) {echo "checked";}?>>
                    Motor Home
                  </label>
                </div>
              </div>
            </div>
            <div class="col">
              <table class="table table-striped table-dark text-center">
                <thead>
                  <tr>
                    <th scope="col">Ticket ID</th>
                    <th scope="col">Type of Ticket</th>
                    <th scope="col">Service Date</th>
                    <th scope="col">
                      <div class="btn-group" role="group" aria-label="Button Group">
                        <button type="button" tabindex="-1" class="btn btn-danger btn-sm payBtn" data-id="" data-toggle="modal" data-target="#addPaymentModal"><i class="fas fa-pound-sign"></i></i></button>
                        <button type="button" tabindex="-1" class="btn btn-danger btn-sm payBtn2" data-id="" data-toggle="modal" data-target="#addPaymentModalRenew"><i class="far fa-clock"></i></i></button>
                      </div>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>19191</td>
                    <td>
                      TICKET TYPE
                    </td>
                    <td>
                      H:I:S
                    </td>
                    <td>
                      <div class="btn-group" role="group" aria-label="Button Group">
                        <button type="button" id="edit" tabindex="-1" class="btn btn-danger btn-sm" data-id=""><i class="fas fa-cog"></i></button>
                        <button type="button" tabindex="-1" onClick="deletePayment()" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></i></button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="form-group">
                <label for="upd_timein">Time IN</label>
                <input type="text" class="form-control" id="upd_timein" name="upd_timein" placeholder="Time IN: Y-m-d H:m" value="<?php echo $row['veh_timein'] ?>">
              </div>
              <div class="form-check">
                <label class="form-check-label">
                <input class="form-check-input" type="radio" name="upd_col" id="upd_col" value="1" <?php if($row['veh_column'] == 1) {echo "checked";}?>>
                  Paid
                </label>
              </div>
              <div class="form-check">
                <label class="form-check-label">
                <input class="form-check-input" type="radio" name="upd_col" id="upd_col" value="2" <?php if($row['veh_column'] == 2) {echo "checked";}?>>
                  Renewal
                </label>
              </div>
              <div class="form-check">
                <label class="form-check-label">
                <input class="form-check-input" type="radio" name="upd_col" id="upd_col" value="3" <?php if($row['veh_column'] == 3) {echo "checked";}?>>
                  Exit
                </label>
              </div>
              <div class="form-group">
                <label for="upd_timeout">Time OUT</label>
                <input type="text" class="form-control" id="upd_timeout" name="upd_timeout" placeholder="Time OUT: Y-m-d H:m" value="<?php echo $row['veh_timeout'] ?>">
              </div>
              <div class="form-group">
                <label for="upd_comment">Comment / Notes</label>
                <textarea type="text" id="upd_comment" class="form-control" name="upd_comment" rows="3" cols="1" form="update"><?php echo $row['veh_comment'] ?></textarea>
              </div>
              <div class="btn-group float-right" role="group" aria-label="Button Group">
                <button type="submit" class="btn btn-dark"><i class="fa fa-save"></i> Save Data</button>
                <div class="btn-group" role="group">
                  <button id="btnGroupDrop1" type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                  <div class="dropdown-menu">
                    <a style="cursor: pointer" class="dropdown-item" onClick="exit(<?php echo $key ?>)">Exit Vehicle</a>
                    <div class="dropdown-divider"></div>
                      <a style="cursor: pointer" class="dropdown-item" onClick="markRenewal(<?php echo $key ?>)">Mark Renewal</a>
                      <a style="cursor: pointer" class="dropdown-item" onClick="setFlag(<?php echo $key ?>)">Flag Vehicle</a>
                    <div class="dropdown-divider"></div>
                    <a style="cursor: pointer" class="dropdown-item" onClick="deleteVehicle(<?php echo $key ?>)">Delete Vehicle</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          </form>
          <img src="<?php echo URL?>/assets/img/tmp/reg.jpg" alt="..." class="img-thumbnail">
          <img src="<?php echo URL?>/assets/img/tmp/reg.jpg" alt="..." class="img-thumbnail">
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
    <?php require(__DIR__."/assets/require.php");?>
  </body>
</html>
