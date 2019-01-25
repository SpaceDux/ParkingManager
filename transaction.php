<?php
  require(__DIR__.'/global.php');
  $pm->CheckAuth(1);

  $key = $_GET['id'];

  $record = $vehicles->getVehicle($key);

  $date = date("Y-m-d H:i:s", strtotime($record['parked_expiry']));
  $result = $etp->Check_SNAP($record['parked_plate']);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Parking Manager: New Transaction | <?php echo $record['parked_plate'] ?></title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/theme.css">
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo URL ?>/assets/css/fontawesome-all.min.css">
  </head>
  <body>
    <?php $pm->PM_Nav();?>
    <!-- Wrapper / Main content -->
    <div id="wrapper">
      <div class="whereami">
        <div class="page">
          <a href="<?php echo URL ?>/index">Dashboard</a> <small>\\\</small> New Transaction <small>\\\</small> <b><?php echo $record['parked_plate']?></b>
          <div class="float-right">
            <?php $vehicles->timeCalc($record['parked_expiry'], "");?>
          </div>
        </div>
      </div>
      <div class="updateContent">
        <div class="container">
          <!-- <form action="transaction.php" method="post"> -->
            <div class="row">
               <div class="col-md-5">
                 <div class="form-group">
                   <label for="NT_Vehicle_Plate">Vehicle Registration</label>
                   <input type="text" class="form-control" name="T_Vehicle_Plate" id="NT_Vehicle_Plate" placeholder="Vehicle Registration" value="<?php echo $record['parked_plate']?>" style="text-transform: uppercase;" readonly>
                   <input type="hidden" class="form-control" name="T_LogID" id="NT_LogID" value="<?php echo $key  ?>">
                   <input type="hidden" class="form-control" name="T_ANPRKey" id="NT_ANPRKey" value="<?php echo $record['parked_anprkey'] ?>">
                   <input type="hidden" class="form-control" name="T_PayRef" id="NT_PayRef" value="<?php echo $record['payment_ref'] ?>">
                   <input type="hidden" class="form-control" name="T_Expiry" id="NT_Expiry" value="<?php echo $record['parked_expiry'] ?>">
                   <input type="hidden" class="form-control" name="T_Date" id="NT_Date" value="<?php echo $date ?>">
                   <input type="hidden" class="form-control" name="T_Vehicle_Plate" id="NT_Vehicle_Plate" value="<?php echo $record['parked_plate'] ?>">
                   <input type="hidden" class="form-control" name="T_Company_Name" id="NT_Company_Name" value="<?php echo $record['parked_company'] ?>">
                   <input type="hidden" class="form-control" name="T_ANPRKey" id="NT_ANPRKey" value="<?php echo $record['parked_anprkey'] ?>">
                 </div>
                 <div class="form-group">
                   <label for="NT_Vehicle_Type">Company Name</label>
                   <input type="text" class="form-control" name="T_Company_Name" id="NT_Company_Name" placeholder="Company Name" value="<?php echo $record['parked_company']?>" style="text-transform: uppercase;" required autofocus>
                 </div>
                 <div class="form-group">
                   <label for="NT_Vehicle_Type">Trailer Number</label>
                   <input type="text" class="form-control" name="T_Vehicle_Trailer" id="NT_Vehicle_Trailer" <?php echo $record['parked_trailer']?> placeholder="Trailer Number" style="text-transform: uppercase;">
                 </div>
                 <div class="form-group">
                   <label for="T_Vehicle_Type">Vehicle Type</label>
                   <select class="form-control" name="T_Vehicle_Type" id="NT_Vehicle_Type">
                     <option value="unchecked">-- Please choose a vehicle type --</option>
                     <?php $pm->PM_VehicleTypes_Dropdown(); ?>
                    </select>
                 </div>
                 <div class="form-group">
                   <label for="">ANPR Images</label>
                   <br>
                   <?php $anpr->ANPR_GetImage($record['parked_anprkey']) ?>
                 </div>
               </div>
               <div class="col-md-7">
               <?php if ($account->Account_Check($record['parked_plate']) == TRUE) { //ACCOUNTS
                 $acc_id = $account->Account_FleetInfo($record['parked_plate'], "account_id");
                 ?>
                 <nav>
                   <div class="nav nav-tabs" id="nav-tab" role="tablist">
                     <a class="nav-item nav-link" id="nav-cash-tab" tabindex="-1" data-toggle="tab" href="#nav-cash" role="tab" aria-controls="nav-cash" aria-selected="false"><i class="fa fa-money-bill-alt"></i> Cash</a>
                     <a class="nav-item nav-link" id="nav-card-tab" tabindex="-1" data-toggle="tab" href="#nav-card" role="tab" aria-controls="nav-card" aria-selected="false"><i class="far fa-credit-card"></i> Card</a>
                     <a class="nav-item nav-link active" id="nav-account-tab" tabindex="-1" data-toggle="tab" href="#nav-account" role="tab" aria-controls="nav-account" aria-selected="false"><i class="fas fa-id-card"></i> Account</a>
                     <a class="nav-item nav-link" id="nav-snap-tab" tabindex="-1" data-toggle="tab" href="#nav-snap" role="tab" aria-controls="nav-snap" aria-selected="false"><?php echo $result ?> SNAP</a>
                     <a class="nav-item nav-link" id="nav-fuel-tab" tabindex="-1" data-toggle="tab" href="#nav-fuel" role="tab" aria-controls="nav-fuel" aria-selected="false"> Fuel Card</a>
                   </div>
                 </nav>
                 <div class="tab-content" id="nav-tabContent">
                   <div class="tab-pane fade" id="nav-cash" role="tabpanel" aria-labelledby="nav-cash-tab">
                     <div class="form-group">
                       <label>Select a Cash Service</label>
                       <div id="Cash_Dropdown">

                       </div>
                       <small class="form-text text-muted"> Ensure this is correct! </small>
                       <div class="form-group" style="margin-top: 130px;">
                         <input type="submit" id="T_Process_Cash" name="T_Process_Cash" class="btn btn-outline-success btn-lg btn-block" value="Process Transaction">
                       </div>
                     </div>
                   </div>
                   <div class="tab-pane fade" id="nav-card" role="tabpanel" aria-labelledby="nav-card-tab">
                     <div class="form-group">
                       <label>Select a Card Service</label>
                       <div id="Card_Dropdown">

                       </div>
                       <small class="form-text text-muted"> Ensure this is correct! </small>
                     </div>
                     <div class="form-group" style="margin-top: 130px;">
                       <input type="submit" name="T_Process_Card" id="T_Process_Card" class="btn btn-outline-success btn-lg btn-block" value="Process Transaction">
                     </div>
                   </div>
                   <div class="tab-pane fade show active" id="nav-account" role="tabpanel" aria-labelledby="nav-account-tab">
                     <div class="form-group">
                       <label>Select a Account Service</label>
                       <div id="Account_Dropdown">

                       </div>
                       <small class="form-text text-muted"> Ensure this is correct! </small>
                     </div>
                     <div class="form-group">
                       <label>Select an account</label>
                       <?php $account->Account_List_Dropdown_Set($acc_id); ?>
                     </div>
                     <div class="form-group" style="margin-top: 130px;">
                       <input type="submit" name="T_Process_Account" id="T_Process_Account" class="btn btn-outline-success btn-lg btn-block" value="Process Transaction">
                     </div>
                   </div>
                   <div class="tab-pane fade" id="nav-snap" role="tabpanel" aria-labelledby="nav-snap-tab">
                     <div class="form-group">
                       <label>Select a SNAP Service</label>
                       <div id="SNAP_Dropdown">

                       </div>
                       <small class="form-text text-muted"> Ensure this is correct! </small>
                     </div>
                     <div class="form-group" style="margin-top: 130px;">
                       <input type="submit" name="T_Process_SNAP" id="T_Process_SNAP" class="btn btn-outline-success btn-lg btn-block" value="Process Transaction">
                     </div>
                   </div>
                   <div class="tab-pane fade" id="nav-fuel" role="tabpanel" aria-labelledby="nav-fuel-tab">
                     <div class="form-group">
                       <label>Select a Fuel Service</label>
                       <div id="Fuel_Dropdown">

                       </div>
                       <small class="form-text text-muted"> Ensure this is correct! </small>
                     </div>
                     <div class="form-group">
                       <label>Swipe Fuel Card</label>
                       <input type="password" class="form-control form-control-lg" name="NT_Process_FuelStrip" id="NT_Process_FuelStrip" value="" placeholder="Swipe Fuel Card">
                     </div>
                     <hr>
                     <div class="form-row">
                       <div class="col-8">
                         <label>Fuel Card Number</label>
                         <input type="text" class="form-control" placeholder="Fuel Card Number" id="NT_FuelCard_Number" value="">
                       </div>
                       <div class="col">
                         <label>Expiration Date</label>
                         <input type="text" class="form-control" placeholder="Expiry (02/2020)" id="NT_FuelCard_Date" value="">
                       </div>
                     </div>
                     <small class="form-text text-muted"> Ensure this is correct! </small>
                     <div class="form-group" style="margin-top: 130px;">
                       <input type="submit" name="T_Process_Fuel" id="T_Process_Fuel" class="btn btn-outline-success btn-lg btn-block" value="Process Transaction">
                     </div>
                   </div>
                 </div>
               <?php } else {  //NON ACCOUNT?>
                 <nav>
                   <div class="nav nav-tabs" id="nav-tab" role="tablist">
                     <a class="nav-item nav-link active" id="nav-cash-tab" tabindex="-1" data-toggle="tab" href="#nav-cash" role="tab" aria-controls="nav-cash" aria-selected="false"><i class="fa fa-money-bill-alt"></i> Cash</a>
                     <a class="nav-item nav-link" id="nav-card-tab" tabindex="-1" data-toggle="tab" href="#nav-card" role="tab" aria-controls="nav-card" aria-selected="false"><i class="far fa-credit-card"></i> Card</a>
                     <a class="nav-item nav-link" id="nav-account-tab" tabindex="-1" data-toggle="tab" href="#nav-account" role="tab" aria-controls="nav-account" aria-selected="false"><i class="fas fa-id-card"></i> Account</a>
                     <a class="nav-item nav-link" id="nav-snap-tab" tabindex="-1" data-toggle="tab" href="#nav-snap" role="tab" aria-controls="nav-snap" aria-selected="false"><?php echo $result ?> SNAP</a>
                     <a class="nav-item nav-link" id="nav-fuel-tab" tabindex="-1" data-toggle="tab" href="#nav-fuel" role="tab" aria-controls="nav-fuel" aria-selected="false"> Fuel Card</a>
                   </div>
                 </nav>
                 <div class="tab-content" id="nav-tabContent">
                   <div class="tab-pane fade show active" id="nav-cash" role="tabpanel" aria-labelledby="nav-cash-tab">
                     <div class="form-group">
                       <label>Select a Cash Service</label>
                       <div id="Cash_Dropdown">

                       </div>
                       <small class="form-text text-muted"> Ensure this is correct! </small>
                       <div class="form-group" style="margin-top: 130px;">
                         <input type="submit" id="T_Process_Cash" name="T_Process_Cash" class="btn btn-outline-success btn-lg btn-block" value="Process Transaction">
                       </div>
                     </div>
                   </div>
                   <div class="tab-pane fade" id="nav-card" role="tabpanel" aria-labelledby="nav-card-tab">
                     <div class="form-group">
                       <label>Select a Card Service</label>
                       <div id="Card_Dropdown">

                       </div>
                       <small class="form-text text-muted"> Ensure this is correct! </small>
                     </div>
                     <div class="form-group" style="margin-top: 130px;">
                       <input type="submit" name="T_Process_Card" id="T_Process_Card" class="btn btn-outline-success btn-lg btn-block" value="Process Transaction">
                     </div>
                   </div>
                   <div class="tab-pane fade" id="nav-account" role="tabpanel" aria-labelledby="nav-account-tab">
                     <div class="form-group">
                       <label>Select a Account Service</label>
                       <div id="Account_Dropdown">

                       </div>
                       <small class="form-text text-muted"> Ensure this is correct! </small>
                     </div>
                     <div class="form-group">
                       <label>Select an account</label>
                       <?php $account->Account_List_Dropdown(); ?>
                     </div>
                     <div class="form-group" style="margin-top: 130px;">
                       <input type="submit" name="T_Process_Account" id="T_Process_Account" class="btn btn-outline-success btn-lg btn-block" value="Process Transaction">
                     </div>
                   </div>
                   <div class="tab-pane fade" id="nav-snap" role="tabpanel" aria-labelledby="nav-snap-tab">
                     <div class="form-group">
                       <label>Select a SNAP Service</label>
                       <div id="SNAP_Dropdown">

                       </div>
                       <small class="form-text text-muted"> Ensure this is correct! </small>
                     </div>
                     <div class="form-group" style="margin-top: 130px;">
                       <input type="submit" name="T_Process_SNAP" id="T_Process_SNAP" class="btn btn-outline-success btn-lg btn-block" value="Process Transaction">
                     </div>
                   </div>
                   <div class="tab-pane fade" id="nav-fuel" role="tabpanel" aria-labelledby="nav-fuel-tab">
                     <div class="form-group">
                       <label>Select a Fuel Service</label>
                       <div id="Fuel_Dropdown">

                       </div>
                       <small class="form-text text-muted"> Ensure this is correct! </small>
                     </div>
                     <div class="form-group">
                       <label>Swipe Fuel Card</label>
                       <input type="password" class="form-control form-control-lg" name="NT_Process_FuelStrip" id="NT_Process_FuelStrip" value="" placeholder="Swipe Fuel Card">
                     </div>
                     <hr>
                     <div class="form-row">
                       <div class="col-8">
                         <label>Fuel Card Number</label>
                         <input type="text" class="form-control" placeholder="Fuel Card Number" id="NT_FuelCard_Number" value="">
                       </div>
                       <div class="col">
                         <label>Expiration Date</label>
                         <input type="text" class="form-control" placeholder="Expiry (02/2020)" id="NT_FuelCard_Date" value="">
                       </div>
                     </div>
                     <small class="form-text text-muted"> Ensure this is correct! </small>
                     <div class="form-group" style="margin-top: 130px;">
                       <input type="submit" name="T_Process_Fuel" id="T_Process_Fuel" class="btn btn-outline-success btn-lg btn-block" value="Process Transaction">
                     </div>
                   </div>
                 </div>
              <?php } ?>
               </div>
            </div>
          <!-- </form> -->
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
