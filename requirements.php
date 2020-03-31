<!-- Update Veh Pane START -->
<div class="PaymentPane" id="UpdateVehPane" >
  <div class="Title">
    update vehicle.
    <div class="btn-group float-right" role="group">
      <button type="button" class="btn btn-danger" onClick="UpdateVehPaneClose()"><i class="fa fa-times"></i></button>
    </div>
  </div>
  <div class="Body">
    <form id="UpdateVehicle_Form">
      <div class="row">
        <div class="col">
          <input type="hidden" name="Update_Ref" id="Update_Ref" class="form-control">
          <input type="hidden" name="Update_Expiry" id="Update_Expiry" class="form-control">
          <input type="hidden" name="Update_Flag" id="Update_Flag" class="form-control">
          <label for="Update_Plate">Update Vehicle Plate</label>
          <input type="text" class="form-control" name="Update_Plate" id="Update_Plate">
          <hr>
          <label for="Update_Name">Update Vehicle Company/Name</label>
          <input type="text" class="form-control" name="Update_Name" id="Update_Name">
          <hr>
          <label for="Update_Trailer">Update Vehicle Trailer</label>
          <input type="text" class="form-control" name="Update_Trailer" id="Update_Trailer">
          <hr>
          <label for="Update_VehType">Update Vehicle Type</label>
          <select class="form-control" id="Update_VehType" name="Update_VehType">
            <option value="unselected">Please Choose a Vehicle Type...</option>
            {VEHTYPES}
          </select>
          <hr>
          <label>ANPR Images</label>
          <div id="Update_Images">

          </div>
        </div>
        <div class="col">
          <div class="alert alert-primary" id="Update_Duration"></div>
          <div id="Update_PaymentsTable">

          </div>
          <label for="Update_Column">Update Vehicle Parking Column</label>
          <select class="form-control" id="Update_Column" name="Update_Column">
            <option value="unselected">Please Choose a Parking Column...</option>
            <option value="1">Paid</option>
            <option value="2">Exit</option>
          </select>
          <hr>
          <label for="Update_Arrival">Update Time of Arrival</label>
          <input type="text" class="form-control" name="Update_Arrival" id="Update_Arrival">
          <hr>
          <label for="Update_Exit">Update Time of Exit</label>
          <input type="text" class="form-control" name="Update_Exit" id="Update_Exit">
          <hr>
          <label for="Update_Notes">Add a Comment</label>
          <textarea class="form-control" id="Update_Notes" name="Update_Notes"></textarea>
          <br><br><hr>
          <div class="btn-group btn-lg">
            <button type="button" class="btn btn-dark" onClick="UpdateVehicleRec()">Save <i class="fa fa-save"></i></button>
            <button type="button" class="btn btn-dark" id="Update_FlagBtn">Flag <i class="fa fa-flag"></i></button>
            <button type="button" class="btn btn-dark" id="Update_ExitBtn">Exit <i class="fa fa-times"></i></button>
            <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="#">Delete Vehicle</a>
            </div>
          </div>
          <span class="badge badge-secondary float-right" id="UD_Ref"></span>
          <span class="badge badge-primary float-right" id="UD_ExitKey"></span>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Update Pane END -->
<!-- Payment Pane START -->
<div class="PaymentPane" id="PaymentPane">
  <div class="Title">
    new transaction.
    <div class="btn-group float-right" role="group">
      <button type="button" class="btn btn-danger" onClick="PaymentPaneClose()"><i class="fa fa-times"></i></button>
    </div>
  </div>
  <div class="Body">
    <form id="PaymentPane_Form">
      <div class="row">
        <div class="col">
          <div id="PortalCheck"></div>
          <input type="hidden" name="Payment_Type" id="Payment_Type" class="form-control">
          <input type="hidden" name="Payment_Ref" id="Payment_Ref" class="form-control">
          <input type="hidden" name="Payment_CaptureDate" id="Payment_CaptureDate" class="form-control">
          <label>Vehicle Registration Plate</label>
          <input type="text" name="Payment_Plate" id="Payment_Plate" class="form-control" placeholder="E.G CY15GHX" style="text-transform: uppercase;" readonly>
          <hr>
          <label>Company / Name</label>
          <input type="text" name="Payment_Name" id="Payment_Name" class="form-control" placeholder="E.G EXAMPLE TRANSPORT" style="text-transform: uppercase;">
          <hr>
          <label>Vehicle Trailer Number</label>
          <input type="text" name="Payment_Trl" class="form-control" id="Payment_Trl" placeholder="E.G TRL001" style="text-transform: uppercase;">
          <hr>
          <label>Vehicle Type</label>
          <select class="form-control" id="Payment_VehType" name="Payment_VehType">
            <option value="unselected">Please Choose a Vehicle Type...</option>
            {VEHTYPES}
          </select>
          <hr>
          <div id="ANPR_Images">

          </div>
        </div>
        <div class="col">
          <div class="alert alert-primary" id="Payment_TimeCalculation"></div>
          <label>How many days parking</label><br>
          <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-secondary active">
              <input type="radio" name="Payment_Services_Expiry" value="24" autocomplete="off" checked=""> 1 Day
            </label>
            <label class="btn btn-secondary">
              <input type="radio" name="Payment_Services_Expiry" value="48" autocomplete="off"> 2 Days
            </label>
            <label class="btn btn-secondary">
              <input type="radio" name="Payment_Services_Expiry" value="72" autocomplete="off"> 3 Days
            </label>
            <label class="btn btn-secondary">
              <input type="radio" name="Payment_Services_Expiry" value="96" autocomplete="off"> 4 Days
            </label>
            <label class="btn btn-secondary">
              <input type="radio" name="Payment_Services_Expiry" value="120" autocomplete="off"> 5 Days
            </label>
            <label class="btn btn-secondary">
              <input type="radio" name="Payment_Services_Expiry" value="144" autocomplete="off"> 6 Days
            </label>
            <label class="btn btn-secondary">
              <input type="radio" name="Payment_Services_Expiry" value="168" autocomplete="off"> 7 Days
            </label>
          </div>
          <hr>
          <div id="PaymentOptions">

          </div>
          <hr>
          <span class="badge badge-secondary float-right" id="Payment_CaptureDate_Bg"></span>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Payment Pane END -->
<!-- Transaction List Pane START -->
<div class="PaymentPane" id="TransactionListPane">
  <div class="Title">
    view all transactions.
    <div class="btn-group float-right" role="group">
      <button type="button" class="btn btn-danger" onClick="ListTransactionsPaneClose()"><i class="fa fa-times"></i></button>
    </div>
  </div>
  <div class="Body">
    <form class="form-row" action="{URL}/download_sales.php" method="POST" id="TransactionListForm">
    <div class="col">
      <div class="input-group input-group-lg mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fa fa-calendar"></i></span>
        </div>
        <input type="text" class="form-control" name="TL_DateStart" placeholder="Start Date" id="TL_DateStart" value="<?php echo date("d-m-Y", strtotime("- 1 day")) ?>" autocomplete="off" style="z-index: 10000;">
      </div>
    </div>
    <div class="col">
      <div class="input-group input-group-lg mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fa fa-calendar"></i></span>
        </div>
        <input type="text" class="form-control" name="TL_DateEnd" placeholder="End Date"  id="TL_DateEnd" value="<?php echo date("d-m-Y") ?>" autocomplete="off" style="z-index: 10000;">
      </div>
    </div>
    <div class="col">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="TL_Cash" id="TL_Cash" value="1" checked="">
        <label class="form-check-label" for="TL_Cash">Cash</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="TL_Card" id="TL_Card" value="1" checked="">
        <label class="form-check-label" for="TL_Card">Card</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="TL_Account" id="TL_Account" value="1" checked="">
        <label class="form-check-label" for="TL_Account">Account</label>
      </div>
    </div>
    <div class="col">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="TL_SNAP" id="TL_SNAP" value="1" checked="">
        <label class="form-check-label" for="TL_SNAP">SNAP Account</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="TL_Fuel" id="TL_Fuel" value="1" checked="">
        <label class="form-check-label" for="TL_Fuel">Fuel Card</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="TL_Deleted" id="TL_Deleted" value="1" checked="">
        <label class="form-check-label" for="TL_Deleted">Hide Deleted</label>
      </div>
    </div>
    <div class="col">
      <div class="form-group">
        <select class="form-control form-control-lg" name="TL_Group" id="TL_Group" autocomplete="off">
          <option value="unselected">-- Choose a Group --</option>
          {TARIFF_GROUPS}
        </select>
      </div>
      <div class="form-group">
        <select class="form-control form-control-lg" name="TL_Settlement_Group" id="TL_Settlement_Group" autocomplete="off">
          {SETTLEMENT_GROUPS}
        </select>
      </div>
    </div>
    <div class="col">
      <div class="btn-group float-right" role="group" aria-label="View Sales">
        <button type="button" id="TL_ViewSales" class="btn btn-lg btn-secondary">View Sales</button>
        <button type="submit" class="btn btn-lg btn-secondary"><i class="fa fa-download"></i></button>
        <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
          <a class="dropdown-item" href="#" onclick="EOD_SettlementToggle()">EOD Settlement</a>
        </div>
      </div>
    </div>
  </form>
    <table id="PaymentsDataTable" class="table table-dark table-bordered" style="width:100%">
      <thead>
        <tr>
          <th>Name</th>
          <th>Registration</th>
          <th>Service</th>
          <th>Gross</th>
          <th>Nett</th>
          <th>Method</th>
          <th>Processed</th>
          <th>Account</th>
          <th>Author</th>
          <th><i class="fa fa-cogs"></i></th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th>Name</th>
          <th>Registration</th>
          <th>Service</th>
          <th>Gross</th>
          <th>Nett</th>
          <th>Method</th>
          <th>Processed</th>
          <th>Account</th>
          <th>Author</th>
          <th><i class="fa fa-cogs"></i></th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
<!-- Transaction List Pane END -->
