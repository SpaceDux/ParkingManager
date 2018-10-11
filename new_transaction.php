<?php
  require(__DIR__.'/global.php');
  $ANPRKey = $_GET['Uniqueref'];
  //Get ANPR Details
  $anpr_rec = $anpr->getANPR_Record($ANPRKey);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Parking Manager: New Transaction | <?php echo $anpr_rec['Plate'] ?></title>
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
          <a href="<?php echo URL ?>/index">Dashboard</a> <small>\\\</small> New Transaction <small>\\\</small> <b><?php echo $anpr_rec['Plate']?></b>
          <div class="float-right">
            <?php $vehicles->timeCalc($anpr_rec['Capture_Date'], "");?>
          </div>
        </div>
      </div>
      <div class="updateContent">
        <div class="container">
          <form action="new_transaction.php" method="post">
            <div class="row">
               <div class="col-md-5">
                 <div class="form-group">
                   <label for="NT_Vehicle_Plate">Vehicle Registration</label>
                   <input type="text" class="form-control" name="NT_Vehicle_Plate" id="NT_Vehicle_Plate" placeholder="Vehicle Registration" value="<?php echo $anpr_rec['Plate']?>" style="text-transform: uppercase;" readonly>
                   <input type="hidden" class="form-control" name="NT_ANPRKey" id="NT_ANPRKey" value="<?php echo $ANPRKey ?>" style="text-transform: uppercase;" readonly>
                 </div>
                 <div class="form-group">
                   <label for="NT_Vehicle_Type">Company Name</label>
                   <input type="text" class="form-control" name="NT_Company_Name" id="NT_Company_Name" placeholder="Company Name" style="text-transform: uppercase;" required autofocus>
                 </div>
                 <div class="form-group">
                   <label for="NT_Vehicle_Type">Trailer Number</label>
                   <input type="text" class="form-control" name="NT_Vehicle_Trailer" id="NT_Vehicle_Trailer" placeholder="Trailer Number" style="text-transform: uppercase;">
                 </div>
                 <div class="form-group">
                   <label for="NT_Vehicle_Type">Vehicle Type</label>
                   <select class="form-control" name="NT_Vehicle_Type" id="NT_Vehicle_Type" required>
                     <option value="unchecked">-- Please choose a vehicle type --</option>
                     <?php $pm->PM_VehicleTypes_Dropdown() ?>
                   </select>
                 </div>
                 <div class="form-group">
                   <label for="">ANPR Images</label>
                   <br>
                   <?php $anpr->ANPR_GetImage($ANPRKey) ?>
                 </div>
               </div>
               <div class="col-md-7">
               <?php if ($vehicles->isVehicleAccount($anpr_rec['Plate']) == TRUE) { //ACCOUNTS
                 $acc_id = $pm->PM_FleetInfo($anpr_rec['Plate'], "account_id");
                 ?>
                 <nav>
                   <div class="nav nav-tabs" id="nav-tab" role="tablist">
                     <a class="nav-item nav-link active" id="nav-account-tab" tabindex="-1" data-toggle="tab" href="#nav-account" role="tab" aria-controls="nav-account" aria-selected="false"><i class="fas fa-id-card"></i> Account</a>
                   </div>
                 </nav>
                 <div class="tab-content" id="nav-tabContent">
                   <div class="tab-pane fade show active" id="nav-account" role="tabpanel" aria-labelledby="nav-account-tab">
                     <div class="form-group">
                       <label>Select a Account Service</label>
                       <div id="Account_Dropdown">

                       </div>
                       <small class="form-text text-muted"> Ensure this is correct! </small>
                     </div>
                     <div class="form-group">
                       <label>Select an account</label>
                       <?php $pm->PM_Accounts_Dropdown_Set($acc_id); ?>
                     </div>
                     <div class="form-group" style="margin-top: 100px;">
                       <input type="submit" name="NT_Process_Account" id="NT_Process_Account" class="btn btn-outline-success btn-lg btn-block" value="Process Transaction">
                     </div>
                   </div>
                 </div>
               <?php } else {  //NON ACCOUNT?>
                 <nav>
                   <div class="nav nav-tabs" id="nav-tab" role="tablist">
                     <a class="nav-item nav-link active" id="nav-cash-tab" tabindex="-1" data-toggle="tab" href="#nav-cash" role="tab" aria-controls="nav-cash" aria-selected="false"><i class="fa fa-money-bill-alt"></i> Cash</a>
                     <a class="nav-item nav-link" id="nav-card-tab" tabindex="-1" data-toggle="tab" href="#nav-card" role="tab" aria-controls="nav-card" aria-selected="false"><i class="far fa-credit-card"></i> Card</a>
                     <a class="nav-item nav-link" id="nav-account-tab" tabindex="-1" data-toggle="tab" href="#nav-account" role="tab" aria-controls="nav-account" aria-selected="false"><i class="fas fa-id-card"></i> Account</a>
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
                         <input type="submit" id="NT_Process_Cash" name="NT_Process_Cash" class="btn btn-outline-success btn-lg btn-block" value="Process Transaction">
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
                       <input type="submit" name="NT_Process_Card" id="NT_Process_Card" class="btn btn-outline-success btn-lg btn-block" value="Process Transaction">
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
                       <?php $pm->PM_Accounts_Dropdown(); ?>
                     </div>
                     <div class="form-group" style="margin-top: 130px;">
                       <input type="submit" name="NT_Process_Account" id="NT_Process_Account" class="btn btn-outline-success btn-lg btn-block" value="Process Transaction">
                     </div>
                   </div>
                 </div>
              <?php } ?>
               </div>
            </div>
          </form>
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
