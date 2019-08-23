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
              <input type="text" class="form-control" name="Contact_Email" id="Contact_Email" value="" placeholder="example@example.com" required>
              <hr>
            </div>
            <div class="col-md-6">
              <label for="Billing_Email">Company Billing Email</label>
              <input type="text" class="form-control" name="Billing_Email" id="Billing_Email" value="" placeholder="example@example.com" required>
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
            <button type="button" class="btn btn-primary" id="Account_Update_Save">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Account Fleets -->
<div class="modal" id="Account_Update_Fleet_Modal" tabindex="-1" role="dialog" aria-labelledby="Account_Update_Modal" aria-hidden="true">
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
              <input type="text" class="form-control" name="Plate" id="Plate" placeholder="EX43PLE" autofocus>
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
<!-- New Tariff Modal -->
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
            <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
