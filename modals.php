<!-- ANPR MODALS -->
<div class="modal" id="ANPR_AddPlate_Modal" tabindex="-1" role="dialog" aria-labelledby="ANPR_AddPlate_Modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Manually add a plate into the ANPR</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-row" id="ANPR_AddPlate_Form">
          <div class="col">
            <label>Registration Plate</label>
            <input type="text" class="form-control" id="AddPlate_Plate" name="Plate" placeholder="GH11GFD" style="text-transform: uppercase;" autofocus>
          </div>
          <div class="col">
            <label>Time of Arrival</label>
            <input type="text" class="form-control" name="Time" id="AddPlate_Time" tabindex="-1">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <input type="submit" class="btn btn-primary" id="AddPlate_Save" value="Save Changes">
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal" id="ANPR_Update_Modal" tabindex="-1" role="dialog" aria-labelledby="ANPR_Update_Modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update ANPR Record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-row" id="ANPR_Update_Form">
            <div class="row">
              <div class="col">
                <label>Registration Plate</label>
                <input type="hidden" class="form-control" name="Update_Ref">
                <input type="text" class="form-control" name="Update_Plate" placeholder="GH11GFD" style="text-transform: uppercase;" autofocus>
              </div>
              <div class="col">
                <label>Trailer Number</label>
                <input type="text" class="form-control" name="Update_Trl" style="text-transform: uppercase;">
              </div>
              <div class="col">
                <label>Time of Arrival</label>
                <input type="text" class="form-control" name="Update_Time">
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div id="ANPR_Update_Img">
                </div>
              </div>
            </div>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <input type="submit" class="btn btn-primary" id="ANPR_Update_Save" value="Save Changes">
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Payment Confirmation Modals -->
<div class="modal fade" id="Payment_ConfirmationCash_Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="Payment_ConfirmationCash_Modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Cash Transaction</h5>
      </div>
      <div id="Modal_BodyCash">
        <div class="modal-body ConfirmModalBody">
          Please confirm that all information is correct and you would like to proceed with the
          <b>Cash</b> transaction.
          <br>
          <br>
          Once you click proceed, all information is then final.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger Modal_AuthBtn_false" onclick="ResetModals()" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-success Modal_AuthBtn_true" onClick="AuthorisePayment('1')">Proceed</button>
          <button type="button" data-dismiss="modal" onClick="PaymentPaneClose()" class="btn btn-danger Modal_PrintBtn_false Hide" data-dismiss="modal">No</button>
          <button type="button" class="btn btn-success Modal_PrintBtn_true Hide">Yes</button>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="Payment_ConfirmationCard_Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="Payment_ConfirmationCard_Modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Card Transaction</h5>
      </div>
      <div id="Modal_BodyCard">
        <div class="modal-body ConfirmModalBody">
          Please confirm that all information is correct and you would like to proceed with the
          <b>Card</b> transaction.
          <br>
          <br>
          Once you click proceed, all information is then final.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger Modal_AuthBtn_false" onclick="ResetModals()" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-success Modal_AuthBtn_true" onClick="AuthorisePayment('2')">Proceed</button>
          <button type="button" data-dismiss="modal" onClick="PaymentPaneClose()" class="btn btn-danger Modal_PrintBtn_false Hide" data-dismiss="modal">No</button>
          <button type="button" class="btn btn-success Modal_PrintBtn_true Hide">Yes</button>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="Payment_ConfirmationAcc_Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="Payment_ConfirmationAcc_Modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Account Transaction</h5>
      </div>
      <div id="Modal_BodyAcc">
        <div class="modal-body ConfirmModalBody">
          Please confirm that all information is correct and you would like to proceed with the
          <b>Account / Roadking Pay</b> transaction.
          <br>
          <br>
          Once you click proceed, all information is then final.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger Modal_AuthBtn_false" onclick="ResetModals()" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-success Modal_AuthBtn_true" onClick="AuthorisePayment('3')">Proceed</button>
          <button type="button" data-dismiss="modal" onClick="PaymentPaneClose()" class="btn btn-danger Modal_PrintBtn_false Hide" data-dismiss="modal">No</button>
          <button type="button" class="btn btn-success Modal_PrintBtn_true Hide">Yes</button>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="Payment_ConfirmationSNAP_Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="Payment_ConfirmationSNAP_Modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm SNAP Transaction</h5>
      </div>
      <div id="Modal_BodySNAP">
        <div class="modal-body ConfirmModalBody">
          Please confirm that all information is correct and you would like to proceed with the
          <b>SNAP Account</b> transaction.
          <br>
          <br>
          Once you click proceed, all information is then final.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger Modal_AuthBtn_false" onclick="ResetModals()" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-success Modal_AuthBtn_true" onClick="AuthorisePayment('4')">Proceed</button>
          <button type="button" data-dismiss="modal" onClick="PaymentPaneClose()" class="btn btn-danger Modal_PrintBtn_false Hide" data-dismiss="modal">No</button>
          <button type="button" class="btn btn-success Modal_PrintBtn_true Hide">Yes</button>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="Payment_ConfirmationFuel_Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="Payment_ConfirmationFuel_Modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Fuel Card Transaction</h5>
      </div>
      <div id="Modal_BodyFuel">
        <div class="modal-body ConfirmModalBody">
          Please confirm that all information is correct and you would like to proceed with the
          <b>Fuel Card</b> transaction.
          <br>
          <br>
          Once you click proceed, all information is then final.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger Modal_AuthBtn_false" onclick="ResetModals()" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-success Modal_AuthBtn_true" onClick="AuthorisePayment('5')">Proceed</button>
          <button type="button" data-dismiss="modal" onClick="PaymentPaneClose()" class="btn btn-danger Modal_PrintBtn_false Hide" data-dismiss="modal">No</button>
          <button type="button" class="btn btn-success Modal_PrintBtn_true Hide">Yes</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Duplicate Modal -->
<div class="modal fade" id="DuplicateVehicle" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="DuplicateVehicle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Duplicate Warning</h5>
      </div>
      <div>
        <div id="DuplicateVehicleBody">
          <div class="modal-body">
            This vehicle already has a parking record, you will not be able to process
            this transaction without first dealing with the record that already exists.
            <br><br>
            Pressing "Go-to Record" will take you to the existing vehicle record.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-warning" id="DuplicateVehicleBtn" data-id="" data-time="">Go-to Record</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Account modals -->
<div class="modal" id="Account_Register_Modal" tabindex="-1" role="dialog" aria-labelledby="Account_Register_Modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Register a new Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="Account_Register_Form">
          <div class="row">
            <div class="col-md-6">
              <label for="Name">Full Company Name</label>
              <input type="text" class="form-control" name="Name" placeholder="Example Transport Ltd" required autofocus>
              <hr>
            </div>
            <div class="col-md-6">
              <label for="Name">Company Short Name</label>
              <input type="text" class="form-control" name="ShortName" placeholder="EXAMPLE" required>
              <hr>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label for="Address">Company Address (Inc Post Code)</label>
              <textarea type="text" class="form-control" name="Address" rows="4" value=""></textarea>
              <hr>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label for="Contact_Email">Company Contact Email</label>
              <input type="text" class="form-control" name="Contact_Email" value="" placeholder="example@example.com" required>
              <hr>
            </div>
            <div class="col-md-6">
              <label for="Billing_Email">Company Billing Email</label>
              <input type="text" class="form-control" name="Billing_Email" value="" placeholder="example@example.com" required>
              <hr>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <label for="Site">Site</label>
              <select class="form-control" name="Site">
                {SITES}
              </select>
            </div>
            <div class="col-md-3">
              <label for="Address">Shared Account</label>
              <select class="form-control" name="Shared">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
            </div>
            <div class="col-md-3">
              <label for="Address">Allow Discounts</label>
              <select class="form-control" name="Discount">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
            </div>
            <div class="col-md-3">
              <label for="Address">Status</label>
              <select class="form-control" name="Status">
                <option value="0">Active</option>
                <option value="1">Suspended</option>
                <option value="2">Teminated</option>
              </select>
              <br>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="Account_Register_Save">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal" id="Account_Update_Modal" tabindex="-1" role="dialog" aria-labelledby="Account_Update_Modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="Account_Update_Form">
          <div class="row">
            <div class="col-md-6">
              <label for="Name">Full Company Name</label>
              <input type="hidden" class="form-control" name="Ref" id="Ref">
              <input type="text" class="form-control" name="Name" id="Name" placeholder="Example Transport Ltd" required autofocus>
              <hr>
            </div>
            <div class="col-md-6">
              <label for="ShortName">Company Short Name</label>
              <input type="text" class="form-control" name="ShortName" id="ShortName" placeholder="EXAMPLE" required>
              <hr>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label for="Address">Company Address (Inc Post Code)</label>
              <textarea type="text" class="form-control" name="Address" id="Address" rows="4" value=""></textarea>
              <hr>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label for="Contact_Email">Company Contact Email</label>
              <input type="text" class="form-control" name="Contact_Email" id="Contact_Email" value="" placeholder="example@example.com">
              <hr>
            </div>
            <div class="col-md-6">
              <label for="Billing_Email">Company Billing Email</label>
              <input type="text" class="form-control" name="Billing_Email" id="Billing_Email" value="" placeholder="example@example.com">
              <hr>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <label for="Site">Site</label>
              <select class="form-control" name="Site" id="Site">
                {SITES}
              </select>
            </div>
            <div class="col-md-3">
              <label for="Address">Shared Account</label>
              <select class="form-control" name="Shared" id="Shared">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
            </div>
            <div class="col-md-3">
              <label for="Address">Allow Discounts</label>
              <select class="form-control" name="Discount" id="Discount">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
            </div>
            <div class="col-md-3">
              <label for="Address">Status</label>
              <select class="form-control" name="Status" id="Status">
                <option value="0">Active</option>
                <option value="1">Suspended</option>
                <option value="2">Teminated</option>
              </select>
              <br>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Account Fleets -->
<div class="modal" id="Account_Update_Fleet_Modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Account Fleet</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="Account_Update_Fleet_Form">
          <div class="row">
            <div class="col-md-12">
              <label for="Name">Add a Vehicle</label>
              <input type="hidden" class="form-control" name="Ref" id="Acc_Ref">
              <div class="row">
                <div class="col-md-10">
                  <textarea class="form-control" name="Plate" id="Plate" placeholder="EX43PLE" autofocus></textarea>
                </div>
                <div class="col-md-2">
                  <input type="submit" class="btn btn-primary" style="width: 100%;" id="Save_Fleet" value="Save">
                </div>
              </div>
              <hr>
              <div id="FleetListTbl">

              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Tariff Modals -->
<div class="modal" id="New_Tariff_Modal" tabindex="-1" role="dialog" aria-labelledby="New_Tariff_Modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">New Tariff</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="New_Tariff_Form">
          <div class="row">
            <div class="col-md-6">
              <label for="Tariff_Name">Name</label>
              <input type="text" class="form-control" name="Tariff_Name" id="Tariff_Name" placeholder="24hr Cab Parking with Meal" required autofocus>
            </div>
            <div class="col-md-6">
              <label for="Tariff_TicketName">Ticket Name</label>
              <input type="text" class="form-control" name="Tariff_TicketName" id="Tariff_TicketName" placeholder="24hr Parking Ticket" required>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-6">
              <label for="Tariff_Gross">Gross Price</label>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">£</div>
                </div>
                <input type="text" class="form-control" name="Tariff_Gross" id="Tariff_Gross" value="" placeholder="" required>
              </div>
            </div>
            <div class="col-md-6">
              <label for="Tariff_Nett">Nett Price</label>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">£</div>
                </div>
                <input type="text" class="form-control" name="Tariff_Nett" id="Tariff_Nett" value="" placeholder="" required>
              </div>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-6">
              <label for="Tariff_Expiry">Expiry (in hours)</label>
              <input type="number" class="form-control" name="Tariff_Expiry" id="Tariff_Expiry" value="" placeholder="24" required>
            </div>
            <div class="col-md-6">
              <label for="Tariff_Group">Tariff Group</label>
              <select class="form-control" name="Tariff_Group" id="Tariff_Group">
                {TARIFF_GROUPS}
              </select>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-6">
              <label for="">Accept Cash</label>
              <select class="form-control" name="Tariff_Cash" id="Tariff_Cash">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
              <hr>
              <label for="">Accept Card</label>
              <select class="form-control" name="Tariff_Card" id="Tariff_Card">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
              <hr>
              <label for="">Accept Account</label>
              <select class="form-control" name="Tariff_Account" id="Tariff_Account">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="">Accept SNAP</label>
              <select class="form-control" name="Tariff_SNAP" id="Tariff_SNAP">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
              <hr>
              <label for="">Accept Fuel Card</label>
              <select class="form-control" name="Tariff_Fuel" id="Tariff_Fuel">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
              <hr>
              <label for="ETPID">ETPID Service ID (API)</label>
              <input type="number" class="form-control" name="Tariff_ETPID" id="Tariff_ETPID" value="0" placeholder="">
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-3">
              <label for="Tariff_Meal">Meal Vouchers</label>
              <input type="number" class="form-control" name="Tariff_Meal" id="Tariff_Meal" value="0" placeholder="" required>
            </div>
            <div class="col-md-3">
              <label for="Tariff_Shower">Shower Vouchers</label>
              <input type="number" class="form-control" name="Tariff_Shower" id="Tariff_Shower" value="0" placeholder="" required>
            </div>
            <div class="col-md-3">
              <label for="Tariff_Discount">Discount Vouchers</label>
              <input type="number" class="form-control" name="Tariff_Discount" id="Tariff_Discount" value="0" placeholder="" required>

            </div>
            <div class="col-md-3">
              <label for="Tariff_WiFi">WiFi Vouchers</label>
              <input type="number" class="form-control" name="Tariff_WiFi" id="Tariff_WiFi" value="0" placeholder="" required>
            </div>
            <br>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-4">
              <label for="VehType">Vehicle Type</label>
              <select class="form-control" name="Tariff_VehType" id="Tariff_VehType">
                <option value="0"> ANY VEHICLE </option>
                {VEHTYPES}
              </select>
            </div>
            <div class="col-md-4">
              <label for="Site">Site</label>
              <select class="form-control" name="Tariff_Site" id="Tariff_Site">
                <option value="unselected">-- Please choose a Site --</option>
                {SITES}
              </select>
            </div>
            <div class="col-md-4">
              <label for="Address">Status</label>
              <select class="form-control" name="Tariff_Status" id="Tariff_Status">
                <option value="0">Active</option>
                <option value="1">Disabled</option>
                <option value="2">Terminated</option>
              </select>
            </div>
            <br>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-6">
              <label for="Tariff_SettlementGroup">Settlement Group</label>
              <select class="form-control" name="Tariff_SettlementGroup" id="Tariff_SettlementGroup">

              </select>
            </div>
            <div class="col-md-6">
              <label for="Tariff_SettlementMulti">Settlement Multiply</label>
              <input type="number" class="form-control" name="Tariff_SettlementMulti" id="Tariff_SettlementMulti" value="" placeholder="" required>
            </div>
            <br>
          </div>
          </div>
          <div class="modal-footer">
            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
              <button type="submit" class="btn btn-primary">Save</button>

              <div class="btn-group" role="group">
                <button id="btnGroupDrop12356" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop12356">
                  <a class="dropdown-item" href="#" id="Tariff_Repeat">Save & Repeat</a>
                </div>
              </div>
            </div>
            <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<div class="modal" id="Update_Tariff_Modal" tabindex="-1" role="dialog" aria-labelledby="Update_Tariff_Modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Tariff</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="Update_Tariff_Form">
          <div class="row">
            <div class="col-md-6">
              <label for="Tariff_Name">Name</label>
              <input type="hidden" class="form-control" name="Tariff_Ref_Update" id="Tariff_Ref_Update" placeholder="24hr Cab Parking with Meal" required autofocus>
              <input type="text" class="form-control" name="Tariff_Name_Update" id="Tariff_Name_Update" placeholder="24hr Cab Parking with Meal" required autofocus>
            </div>
            <div class="col-md-6">
              <label for="Tariff_TicketName">Ticket Name</label>
              <input type="text" class="form-control" name="Tariff_TicketName_Update" id="Tariff_TicketName_Update" placeholder="24hr Parking Ticket" required>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-6">
              <label for="Tariff_Gross">Gross Price</label>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">£</div>
                </div>
                <input type="text" class="form-control" name="Tariff_Gross_Update" id="Tariff_Gross_Update" value="" placeholder="" required>
              </div>
            </div>
            <div class="col-md-6">
              <label for="Tariff_Nett">Nett Price</label>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">£</div>
                </div>
                <input type="text" class="form-control" name="Tariff_Nett_Update" id="Tariff_Nett_Update" value="" placeholder="" required>
              </div>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-6">
              <label for="Tariff_Expiry">Expiry (in hours)</label>
              <input type="number" class="form-control" name="Tariff_Expiry_Update" id="Tariff_Expiry_Update" value="" placeholder="24" required>
            </div>
            <div class="col-md-6">
              <label for="Tariff_Group">Tariff Group</label>
              <select class="form-control" name="Tariff_Group_Update" id="Tariff_Group_Update">
                {TARIFF_GROUPS}
              </select>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-6">
              <label for="">Accept Cash</label>
              <select class="form-control" name="Tariff_Cash_Update" id="Tariff_Cash_Update">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
              <hr>
              <label for="">Accept Card</label>
              <select class="form-control" name="Tariff_Card_Update" id="Tariff_Card_Update">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
              <hr>
              <label for="">Accept Account</label>
              <select class="form-control" name="Tariff_Account_Update" id="Tariff_Account_Update">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="">Accept SNAP</label>
              <select class="form-control" name="Tariff_SNAP_Update" id="Tariff_SNAP_Update">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
              <hr>
              <label for="">Accept Fuel Card</label>
              <select class="form-control" name="Tariff_Fuel_Update" id="Tariff_Fuel_Update">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
              <hr>
              <label for="ETPID">ETPID Service ID (API)</label>
              <input type="number" class="form-control" name="Tariff_ETPID_Update" id="Tariff_ETPID_Update" value="0" placeholder="">
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-3">
              <label for="Tariff_Meal">Meal Vouchers</label>
              <input type="number" class="form-control" name="Tariff_Meal_Update" id="Tariff_Meal_Update" value="0" placeholder="" required>
            </div>
            <div class="col-md-3">
              <label for="Tariff_Shower">Shower Vouchers</label>
              <input type="number" class="form-control" name="Tariff_Shower_Update" id="Tariff_Shower_Update" value="0" placeholder="" required>
            </div>
            <div class="col-md-3">
              <label for="Tariff_Discount">Discount Vouchers</label>
              <input type="number" class="form-control" name="Tariff_Discount_Update" id="Tariff_Discount_Update" value="0" placeholder="" required>

            </div>
            <div class="col-md-3">
              <label for="Tariff_WiFi">WiFi Vouchers</label>
              <input type="number" class="form-control" name="Tariff_WiFi_Update" id="Tariff_WiFi_Update" value="0" placeholder="" required>
            </div>
            <br>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-4">
              <label for="VehType">Vehicle Type</label>
              <select class="form-control" name="Tariff_VehType_Update" id="Tariff_VehType_Update">
                <option value="0"> ANY VEHICLE </option>
                {VEHTYPES}
              </select>
            </div>
            <div class="col-md-4">
              <label for="Site">Site</label>
              <select class="form-control" name="Tariff_Site_Update" id="Tariff_Site_Update">
                <option value="unselected">-- Please choose a Site --</option>
                {SITES}
              </select>
            </div>
            <div class="col-md-4">
              <label for="Address">Status</label>
              <select class="form-control" name="Tariff_Status_Update" id="Tariff_Status_Update">
                <option value="0">Active</option>
                <option value="1">Disabled</option>
                <option value="2">Terminated</option>
              </select>
            </div>
            <br>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-6">
              <label for="Tariff_SettlementGroup">Settlement Group</label>
              <select class="form-control" name="Tariff_SettlementGroup_Update" id="Tariff_SettlementGroup_Update">

              </select>
            </div>
            <div class="col-md-6">
              <label for="Tariff_SettlementMulti">Settlement Multiply</label>
              <input type="number" class="form-control" name="Tariff_SettlementMulti_Update" id="Tariff_SettlementMulti_Update" value="" placeholder="" required>
            </div>
            <br>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Site Modals -->
<div class="modal" id="Site_Register_Modal" tabindex="-1" role="dialog" aria-labelledby="Site_Register_Modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">New Site</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="Site_Register_Form">
          <div class="row">
            <div class="col-md-6">
              <label for="Site_Name">Name</label>
              <input type="text" class="form-control" name="Site_Name" id="Site_Name" placeholder="My Truckstop Name" required autofocus>
              <hr>
              <label for="Site_Barrier_IN">Entry Barrier IP</label>
              <input type="text" class="form-control" name="Site_Barrier_IN" id="Site_Barrier_IN" placeholder="192.168.0.1/moxaparams">
            </div>
            <div class="col-md-6">
              <label for="Site_VAT">VAT Number</label>
              <input type="number" class="form-control" name="Site_VAT" id="Site_VAT" placeholder="18174632" required>
              <hr>
              <label for="Site_Barrier_OUT">Exit Barrier IP</label>
              <input type="text" class="form-control" name="Site_Barrier_OUT" id="Site_Barrier_OUT" placeholder="192.168.0.1/moxaparams">
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-6">
              <label for="Site_ANPR_IP">ANPR IP</label>
              <input type="text" class="form-control" name="Site_ANPR_IP" id="Site_ANPR_IP" placeholder="192.168.0.0" required>
              <hr>
              <label for="Site_ANPR_DB">ANPR Database</label>
              <input type="text" class="form-control" name="Site_ANPR_DB" id="Site_ANPR_DB" placeholder="ANPRDB" required>
              <hr>
              <label for="Site_ANPR_Imgsrv">ANPR Image Server Address</label>
              <input type="text" class="form-control" name="Site_ANPR_Imgsrv" id="Site_ANPR_Imgsrv" placeholder="http://192.168.2.34" required>
            </div>
            <div class="col-md-6">
              <label for="Site_ANPR_User">ANPR User</label>
              <input type="text" class="form-control" name="Site_ANPR_User" id="Site_ANPR_User" placeholder="SA" required>
              <hr>
              <label for="Site_ANPR_Pass">ANPR Password</label>
              <input type="password" class="form-control" name="Site_ANPR_Pass" id="Site_ANPR_Pass" placeholder="Password" required>
              <hr>
              <label for="Site_ANPR_Imgstr">ANPR Image String</label>
              <input type="text" class="form-control" name="Site_ANPR_Imgstr" id="Site_ANPR_Imgstr" placeholder="D:\ANPR PICS\EXAMPLE" required>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-6">
              <label for="Site_Unifi_Status">Unifi Status</label>
              <select class="form-control" name="Site_Unifi_Status" id="Site_Unifi_Status" required>
                <option value="0">Disabled</option>
                <option value="1">Enabled</option>
              </select>
              <hr>
              <label for="Site_Unifi_User">Unifi User</label>
              <input type="text" class="form-control" name="Site_Unifi_User" id="Site_Unifi_User" placeholder="Username">
              <hr>
              <label for="Site_Unifi_Pass">Unifi Password</label>
              <input type="password" class="form-control" name="Site_Unifi_Pass" id="Site_Unifi_Pass" placeholder="Password">
            </div>
            <div class="col-md-6">
              <label for="Site_Unifi_IP">Unifi IP</label>
              <input type="text" class="form-control" name="Site_Unifi_IP" id="Site_Unifi_IP" placeholder="192.168.0.0">
              <hr>
              <label for="Site_Unifi_Site">Unifi Site</label>
              <input type="text" class="form-control" name="Site_Unifi_Site" id="Site_Unifi_Site" placeholder="default">
              <hr>
              <label for="Site_Unifi_Ver">Unifi Controller Version</label>
              <input type="text" class="form-control" name="Site_Unifi_Ver" id="Site_Unifi_Ver" placeholder="3.2.1">
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-6">
              <label for="Site_ETP_User">ETP User</label>
              <input type="text" class="form-control" name="Site_ETP_User" id="Site_ETP_User" placeholder="Username" required>
            </div>
            <div class="col-md-6">
              <label for="Site_ETP_Pass">ETP Password</label>
              <input type="password" class="form-control" name="Site_ETP_Pass" id="Site_ETP_Pass" placeholder="Password" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal" id="Site_Update_Modal" tabindex="-1" role="dialog" aria-labelledby="Site_Update_Modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Site</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="Site_Update_Form">
          <div class="row">
            <div class="col-md-6">
              <label for="Site_Name">Name</label>
              <input type="hidden" class="form-control" name="Site_Ref_Update" id="Site_Ref_Update">
              <input type="text" class="form-control" name="Site_Name_Update" id="Site_Name_Update" placeholder="My Truckstop Name" required autofocus>
              <hr>
              <label for="Site_Barrier_IN">Entry Barrier IP</label>
              <input type="text" class="form-control" name="Site_Barrier_IN_Update" id="Site_Barrier_IN_Update" placeholder="192.168.0.1/moxaparams">
            </div>
            <div class="col-md-6">
              <label for="Site_VAT">VAT Number</label>
              <input type="number" class="form-control" name="Site_VAT_Update" id="Site_VAT_Update" placeholder="18174632" required>
              <hr>
              <label for="Site_Barrier_OUT">Exit Barrier IP</label>
              <input type="text" class="form-control" name="Site_Barrier_OUT_Update" id="Site_Barrier_OUT_Update" placeholder="192.168.0.1/moxaparams">
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-6">
              <label for="Site_ANPR_IP">ANPR IP</label>
              <input type="text" class="form-control" name="Site_ANPR_IP_Update" id="Site_ANPR_IP_Update" placeholder="192.168.0.0" required>
              <hr>
              <label for="Site_ANPR_DB">ANPR Database</label>
              <input type="text" class="form-control" name="Site_ANPR_DB_Update" id="Site_ANPR_DB_Update" placeholder="ANPRDB" required>
              <hr>
              <label for="Site_ANPR_Imgsrv">ANPR Image Server Address</label>
              <input type="text" class="form-control" name="Site_ANPR_Imgsrv_Update" id="Site_ANPR_Imgsrv_Update" placeholder="http://192.168.2.34" required>
            </div>
            <div class="col-md-6">
              <label for="Site_ANPR_User">ANPR User</label>
              <input type="text" class="form-control" name="Site_ANPR_User_Update" id="Site_ANPR_User_Update" placeholder="SA" required>
              <hr>
              <label for="Site_ANPR_Pass">ANPR Password</label>
              <input type="password" class="form-control" name="Site_ANPR_Pass_Update" id="Site_ANPR_Pass_Update" placeholder="Password" required>
              <hr>
              <label for="Site_ANPR_Imgstr">ANPR Image String</label>
              <input type="text" class="form-control" name="Site_ANPR_Imgstr_Update" id="Site_ANPR_Imgstr_Update" placeholder="D:\ANPR PICS\EXAMPLE" required>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-6">
              <label for="Site_Unifi_Status">Unifi Status</label>
              <select class="form-control" name="Site_Unifi_Status_Update" id="Site_Unifi_Status_Update" required>
                <option value="0">Disabled</option>
                <option value="1">Enabled</option>
              </select>
              <hr>
              <label for="Site_Unifi_User">Unifi User</label>
              <input type="text" class="form-control" name="Site_Unifi_User_Update" id="Site_Unifi_User_Update" placeholder="Username">
              <hr>
              <label for="Site_Unifi_Pass">Unifi Password</label>
              <input type="password" class="form-control" name="Site_Unifi_Pass_Update" id="Site_Unifi_Pass_Update" placeholder="Password">
            </div>
            <div class="col-md-6">
              <label for="Site_Unifi_IP">Unifi IP</label>
              <input type="text" class="form-control" name="Site_Unifi_IP_Update" id="Site_Unifi_IP_Update" placeholder="192.168.0.0">
              <hr>
              <label for="Site_Unifi_Site">Unifi Site</label>
              <input type="text" class="form-control" name="Site_Unifi_Site_Update" id="Site_Unifi_Site_Update" placeholder="default">
              <hr>
              <label for="Site_Unifi_Ver">Unifi Controller Version</label>
              <input type="text" class="form-control" name="Site_Unifi_Ver_Update" id="Site_Unifi_Ver_Update" placeholder="3.2.1">
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-6">
              <label for="Site_ETP_User">ETP User</label>
              <input type="text" class="form-control" name="Site_ETP_User_Update" id="Site_ETP_User_Update" placeholder="Username" required>
            </div>
            <div class="col-md-6">
              <label for="Site_ETP_Pass">ETP Password</label>
              <input type="password" class="form-control" name="Site_ETP_Pass_Update" id="Site_ETP_Pass_Update" placeholder="Password" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- User Modals -->
<div class="modal" id="User_Register_Modal" tabindex="-1" role="dialog" aria-labelledby="User_Register_Modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Register a new User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="User_Register_Form">
          <div class="row">
            <div class="col-md-6">
              <label for="Name">First Name</label>
              <input type="text" class="form-control" name="FirstName" placeholder="Joe" required autofocus>
              <hr>
            </div>
            <div class="col-md-6">
              <label for="Name">Last Name</label>
              <input type="text" class="form-control" name="LastName" placeholder="Bloggs" required>
              <hr>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label for="EmailAddress">Email Address</label>
              <input type="email" class="form-control" name="EmailAddress" placeholder="example@example.com" required>
              <hr>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label for="Name">Password</label>
              <input type="password" class="form-control" name="Password" placeholder="Password" required>
              <hr>
            </div>
            <div class="col-md-6">
              <label for="Name">Confirm Password</label>
              <input type="password" class="form-control" name="ConfirmPassword" placeholder="Confirm Password" required>
              <hr>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="Site">Site</label>
              <select class="form-control" name="Site">
                {SITES}
              </select>
            </div>
            <div class="col-md-4">
              <label for="Address">Enable ANPR</label>
              <select class="form-control" name="ANPR">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
            </div>
            <div class="col-md-4">
              <label for="Rank">Rank</label>
              <select class="form-control" name="Rank">
                <option value="0">Security</option>
                <option value="1">Manager</option>
                <option value="2">Global Manager</option>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label for="Address">Printer</label>
              <select class="form-control" name="Printer">
                {PRINTERS}
              </select>
              <br>
            </div>
            <div class="col-md-6">
              <label for="Address">Status</label>
              <select class="form-control" name="Status">
                <option value="0">Active</option>
                <option value="1">Suspended</option>
                <option value="2">Teminated</option>
              </select>
              <br>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal" id="User_Update_Modal" tabindex="-1" role="dialog" aria-labelledby="User_Update_Modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="User_Update_Form">
          <div class="row">
            <div class="col-md-6">
              <label for="Name">First Name</label>
              <input type="hidden" class="form-control" name="User_Ref" id="User_Ref">
              <input type="text" class="form-control" name="User_FirstName" placeholder="Joe" id="User_FirstName" required autofocus>
              <hr>
            </div>
            <div class="col-md-6">
              <label for="Name">Last Name</label>
              <input type="text" class="form-control" name="User_LastName" placeholder="Bloggs" id="User_LastName" required>
              <hr>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label for="EmailAddress">Email Address</label>
              <input type="email" class="form-control" name="User_Email" id="User_Email" placeholder="example@example.com" required>
              <hr>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="Site">Site</label>
              <select class="form-control" name="User_Site" id="User_Site">
                {SITES}
              </select>
            </div>
            <div class="col-md-4">
              <label for="ANPR">Enable ANPR</label>
              <select class="form-control" name="User_ANPR" id="User_ANPR">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
            </div>
            <div class="col-md-4">
              <label for="Rank">Rank</label>
              <select class="form-control" name="User_Rank" id="User_Rank">
                <option value="0">Security</option>
                <option value="1">Manager</option>
                <option value="2">Global Manager</option>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label for="Printer">Printer</label>
              <select class="form-control" id="User_Printer" name="User_Printer">
                {PRINTERS}
              </select>
              <br>
            </div>
            <div class="col-md-6">
              <label for="Status">Status</label>
              <select class="form-control" name="User_Status" id="User_Status">
                <option value="0">Active</option>
                <option value="1">Suspended</option>
                <option value="2">Teminated</option>
              </select>
              <br>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal" id="User_UpdatePW_Modal" tabindex="-1" role="dialog" aria-labelledby="User_UpdatePW_Modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="User_UpdatePW_Form">
          <div class="row">
            <div class="col-md-6">
              <label for="Password">New Password</label>
              <input type="hidden" class="form-control" name="Ref">
              <input type="password" class="form-control" name="Password" placeholder="Password" required autofocus>
              <hr>
            </div>
            <div class="col-md-6">
              <label for="ConfirmPassword">Confirm Password</label>
              <input type="password" class="form-control" name="ConfirmPassword" placeholder="Password" required>
              <hr>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Search Records -->
<div class="modal" id="Search_Records_Modal" tabindex="-1" role="dialog" aria-labelledby="Search_Records_Modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Search Records</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col">
            <label for="Search_PM_Str">Search Parking Records</label>
            <input type="text" class="form-control" name="Search_PM_Str" id="Search_PM_Str" placeholder="Search Parking Records..." autofocus>
          </div>
          <div class="col">
            <label for="Search_Payment_Str">Search Payment Records</label>
            <input type="text" class="form-control" name="Search_Payment_Str" id="Search_Payment_Str" placeholder="Search Payment Records...">
          </div>
          <div class="col">
            <label for="Search_ANPR_Str">Search ANPR Records</label>
            <input type="text" class="form-control" name="Search_ANPR_Str" id="Search_ANPR_Str" placeholder="Search ANPR Records...">
          </div>
        </div>
        <div class="row">
          <div class="col">
            <hr>
            <div id="Search_Results">

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Update Secondary ANPR -->
<div class="modal" id="ANPR_Secondary_Update_Modal" tabindex="-1" role="dialog" aria-labelledby="ANPR_Secondary_Update_Modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update ANPR Record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-row" id="ANPR_Secondary_Update_Form">
          <div class="row">
            <div class="col">
              <label>Registration Plate</label>
              <input type="hidden" class="form-control" name="Update_Secondary_Ref">
              <input type="text" class="form-control" name="Update_Secondary_Plate" placeholder="GH11GFD" style="text-transform: uppercase;" autofocus>
            </div>
            <div class="col">
              <label>Trailer Number</label>
              <input type="text" class="form-control" name="Update_Secondary_Trl" style="text-transform: uppercase;">
            </div>
            <div class="col">
              <label>Time of Arrival</label>
              <input type="text" class="form-control" name="Update_Secondary_Time">
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div id="ANPR_Secondary_Update_Img">

              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <input type="submit" class="btn btn-primary" id="ANPR_Secondary_Update_Save" value="Save Changes">
        </div>
      </form>
    </div>
  </div>
</div>
<!-- PM Director Modal -->
<div class="modal" id="PM_Director_Modal" tabindex="-1" role="dialog" aria-labelledby="PM_Director_Modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Vehicle Director</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col">
            <label>Registration Plate (Enter in Full)</label>
            <input type="text" class="form-control" name="Plate" id="Director_Plate" placeholder="GH11GFD" style="text-transform: uppercase;" autofocus>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col">
            <div id="Director_Results">

            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" id="Director_Submit" value="Save Changes">
      </div>
    </div>
  </div>
</div>
<!-- Payment Update Modal -->
<div class="modal" id="Payment_UpdateModal" tabindex="-1" role="dialog" aria-labelledby="Payment_UpdateModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col">
            <input type="hidden" class="form-control" name="Payment_Uniqueref_Update" id="Payment_Uniqueref_Update" style="text-transform: uppercase;" autofocus>
            <label>Update Processed Time</label>
            <input type="text" class="form-control" name="Payment_Processed_Time_Update" id="Payment_Processed_Time_Update" style="text-transform: uppercase;" autofocus>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="button" class="btn btn-primary" id="Payment_Update" value="Save Changes">
      </div>
    </div>
  </div>
</div>
