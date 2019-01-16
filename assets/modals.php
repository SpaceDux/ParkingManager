<!-- Search DB Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="searchModalTitle">Search Database Entries</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col">
            <label>Search Vehicle Logs</label>
            <input type="text" id="PM_SearchLogs" class="form-control" placeholder="Search Registration, company, trailer number..." autofocus>
          </div>
          <div class="col">
            <label>Search Transactions</label>
            <input type="text" id="PM_PaymentSearch" class="form-control" placeholder="Search Ticket ID, SNAP ES.ID">
          </div>
          <div class="col">
            <label>Search ANPR database</label>
            <input type="text" id="ANPR_Search" class="form-control" placeholder="Search ANPR Entries">
          </div>
        </div>
        <div class="modal-body">
          <div id="return">

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Update Vehicle Modal -->
<div class="modal fade" id="ANPR_UpdateModal" tabindex="-1" role="dialog" aria-labelledby="ANPR_UpdateModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ANPR_UpdateModal">ANPR Update Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="ANPR_UpdateForm">
          <div class="row">
            <div class="col">
              <label>Update ANPR Plate</label>
              <input type="hidden" id="ANPR_Update_ID" class="form-control">
              <input type="text" style="text-transform: uppercase;" id="ANPR_Update_Plate" class="form-control" autofocus>
            </div>
            <div class="col">
              <label>Update ANPR Date & Time</label>
              <input type="text" style="text-transform: uppercase;" id="ANPR_Update_Date" class="form-control">
            </div>
          </div>
          <div class="modal-body">
            <div id="return">

            </div>
          </div>
          <div class="modal-footer">
            <input type="submit" id="saveANPR" class="btn btn-primary" value="Save Changes">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Add Vehicle Modal -->
<div class="modal fade" id="ANPR_AddModal" tabindex="-1" role="dialog" aria-labelledby="ANPR_UpdateModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ANPR_AddModal">ANPR Add Vehicle</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="ANPR_AddForm">
          <div class="row">
            <div class="col">
              <label>Add ANPR Plate</label>
              <input type="text" style="text-transform: uppercase;" id="ANPR_Add_Plate" class="form-control" autofocus>
            </div>
            <div class="col">
              <label>Add ANPR Date & Time</label>
              <input type="text" style="text-transform: uppercase;" id="ANPR_Add_Date" class="form-control">
            </div>
          </div>
          <div class="modal-body">

          </div>
          <div class="modal-footer">
            <input type="submit" id="addANPR" class="btn btn-primary" value="Save Changes">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Add Payment Service -->
<div class="modal fade" id="Payment_Service_AddModal" tabindex="-1" role="dialog" aria-labelledby="Payment_Service_AddModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="Payment_Service_AddModal">New Payment Service</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="Payment_Service_AddForm">
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label for="Service_Name">Service Name</label>
                <input type="text" id="Service_Name" class="form-control" placeholder="24Hour Cab Only with Meal" autofocus required>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="Service_Ticket_Name">Service Ticket Name</label>
                <input type="text" id="Service_Ticket_Name" class="form-control" placeholder="24Hour Cab Only" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label for="Service_Price_Gross">Service Price (Gross)</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">£</span>
                </div>
                <input type="text" id="Service_Price_Gross" class="form-control" placeholder="10.00" required>
              </div>
            </div>
            <div class="col-md-6">
              <label for="Service_Price_Net">Service Price (Net)</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">£</span>
                </div>
                <input type="text" id="Service_Price_Net" class="form-control" placeholder="8.33" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="Service_Expiry">Service Expiry</label>
                <input type="number" id="Service_Expiry" class="form-control" placeholder="24 (Hours)" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="Service_Expiry">Service Group</label>
                <select class="form-control" name="Service_Group" id="Service_Group">
                  <?php $payment->Payment_Service_Group_Dropdown() ?>
                </select>
              </div>
            </div>
            <div class="col">
              <hr>
              <div class="form-group">
                <label for="Service_Cash">Allow Cash Payments</label>
                <select class="form-control" id="Service_Cash">
                  <option value="0">Don't Accept Cash</option>
                  <option value="1">Accept Cash</option>
                </select>
              </div>
              <div class="form-group">
                <label for="Service_Card">Allow Card Payments</label>
                <select class="form-control" id="Service_Card">
                  <option value="0">Don't Accept Card</option>
                  <option value="1">Accept Card</option>
                </select>
              </div>
              <div class="form-group">
                <label for="Service_Account">Allow Account Payments</label>
                <select class="form-control" id="Service_Account">
                  <option value="0">Don't Accept Account</option>
                  <option value="1">Accept Account</option>
                </select>
              </div>
              <hr>
            </div>
            <div class="col">
              <hr>
              <div class="form-group">
                <label for="Service_SNAP">Allow SNAP Payments</label>
                <select class="form-control" id="Service_SNAP">
                  <option value="0">Don't Accept SNAP</option>
                  <option value="1">Accept SNAP</option>
                </select>
              </div>
              <div class="form-group">
                <label for="Service_Fuel">Allow Fuel Card Payments</label>
                <select class="form-control" id="Service_Fuel">
                  <option value="0">Don't Accept Fuel Card</option>
                  <option value="1">Accept Fuel Card</option>
                </select>
              </div>
              <div class="form-group">
                <label for="Service_ETPID">ETP Service ID (via API)</label>
                <input type="text" class="form-control" id="Service_ETPID" value="" placeholder="2453...">
              </div>
              <hr>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <div class="form-group">
                  <label for="Service_Meal_Amount">How many MEAL vouchers?</label>
                  <input type="number" id="Service_Meal_Amount" class="form-control" placeholder="0" value="0" required>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <div class="form-group">
                  <label for="Service_Shower_Amount">How many SHOWER vouchers?</label>
                  <input type="number" id="Service_Shower_Amount" class="form-control" placeholder="0" value="0" required>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="Service_Vehicles">Select Vehicle Types</label>
              <div class="form-group">
                <select class="form-control" name="Service_Vehicles" id="Service_Vehicles">
                  <?php $pm->PM_VehicleTypes_Dropdown() ?>
                </select>
              </div>
            </div>
            <div class="col">
              <label for="Service_Vehicles_Any">Allow ANY Vehicle?</label>
              <div class="form-group">
                <select class="form-control" name="Service_Vehicles_Any_Update" id="Service_Vehicles_Any">
                  <option value="0">No</option>
                  <option value="1">Yes</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label>Choose a site</label>
                <select class="form-control" name="Service_Campus" id="Service_Campus" required>
                  <?php $pm->PM_Sites_Dropdown(); ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-body">
          <div class="modal-footer">
            <input type="submit" class="btn btn-primary" id="Payment_Service_Save" value="Save">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Update Payment Service -->
<div class="modal fade" id="Payment_Service_UpdateModal" tabindex="-1" role="dialog" aria-labelledby="Payment_Service_UpdateModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="Payment_Service_UpdateModal">Update Payment Service</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="Payment_Service_UpdateForm">
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label for="Service_Name_Update">Service Name</label>
                <input type="hidden" id="Service_ID_Update" class="form-control">
                <input type="text" id="Service_Name_Update" class="form-control" placeholder="24Hour Cab Only with Meal" autofocus required>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="Service_Ticket_Name_Update">Service Ticket Name</label>
                <input type="text" id="Service_Ticket_Name_Update" class="form-control" placeholder="24Hour Cab Only" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label for="Service_Price_Gross_Update">Service Price (Gross)</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">£</span>
                </div>
                <input type="text" id="Service_Price_Gross_Update" class="form-control" placeholder="10.00" required>
              </div>
            </div>
            <div class="col-md-6">
              <label for="Service_Price_Net_Update">Service Price (Net)</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">£</span>
                </div>
                <input type="text" id="Service_Price_Net_Update" class="form-control" placeholder="8.33" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="Service_Expiry_Update">Service Expiry</label>
                <input type="number" id="Service_Expiry_Update" class="form-control" placeholder="24 (Hours)" required>
              </div>
              <hr>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="Service_Expiry_Update">Service Group</label>
                <select class="form-control" name="Service_Group_Update" id="Service_Group_Update">
                  <?php $payment->Payment_Service_Group_Dropdown() ?>
                </select>
              </div>
              <hr>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="Service_Cash_Update">Allow Cash Payments</label>
                <select class="form-control" id="Service_Cash_Update">
                  <option value="0">Don't Accept Cash</option>
                  <option value="1">Accept Cash</option>
                </select>
              </div>
              <div class="form-group">
                <label for="Service_Card_Update">Allow Card Payments</label>
                <select class="form-control" id="Service_Card_Update">
                  <option value="0">Don't Accept Card</option>
                  <option value="1">Accept Card</option>
                </select>
              </div>
              <div class="form-group">
                <label for="Service_Account_Update">Allow Account Payments</label>
                <select class="form-control" id="Service_Account_Update">
                  <option value="0">Don't Accept Account</option>
                  <option value="1">Accept Account</option>
                </select>
              </div>
              <hr>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="Service_SNAP_Update">Allow SNAP Payments</label>
                <select class="form-control" id="Service_SNAP_Update">
                  <option value="0">Don't Accept SNAP</option>
                  <option value="1">Accept SNAP</option>
                </select>
              </div>
              <div class="form-group">
                <label for="Service_Fuel_Update">Allow Fuel Card Payments</label>
                <select class="form-control" id="Service_Fuel_Update">
                  <option value="0">Don't Accept Fuel Card</option>
                  <option value="1">Accept Fuel Card</option>
                </select>
              </div>
              <div class="form-group">
                <label for="Service_ETPID">ETP Service ID (via API)</label>
                <input type="text" class="form-control" id="Service_ETPID_Update" value="" placeholder="2453...">
              </div>
              <hr>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <div class="form-group">
                  <label for="Service_Meal_Amount_Update">How many MEAL vouchers?</label>
                  <input type="number" id="Service_Meal_Amount_Update" class="form-control" placeholder="0" value="0" required>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <div class="form-group">
                  <label for="Service_Shower_Amount_Update">How many SHOWER vouchers?</label>
                  <input type="number" id="Service_Shower_Amount_Update" class="form-control" placeholder="0" value="0" required>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="Service_Vehicles_Update">Select Vehicle Types</label>
              <div class="form-group">
                <select class="form-control" name="Service_Vehicles_Update" id="Service_Vehicles_Update">
                  <?php $pm->PM_VehicleTypes_Dropdown() ?>
                </select>
              </div>
            </div>
            <div class="col">
              <label for="Service_Vehicles_Any_Update">Allow ANY Vehicle?</label>
              <div class="form-group">
                <select class="form-control" name="Service_Vehicles_Any_Update_Update" id="Service_Vehicles_Any_Update">
                  <option value="0">No</option>
                  <option value="1">Yes</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label for="Service_Campus_Update">Choose a site</label>
                <select class="form-control" name="Service_Campus_Update" id="Service_Campus_Update" required>
                  <?php $pm->PM_Sites_Dropdown(); ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-body">
          <div class="modal-footer">
            <input type="submit" class="btn btn-primary" id="Payment_Service_Update" value="Save Changes">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Update User Modal -->
<div class="modal fade" id="User_UpdateModal" tabindex="-1" role="dialog" aria-labelledby="User_UpdateModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="User_UpdateModal">Update User Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="User_UpdateForm">
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label>First Name</label>
                <input type="hidden" class="form-control" name="User_ID" id="User_ID">
                <input type="text" class="form-control" name="User_Firstname_Update" id="User_Firstname_Update" placeholder="First Name" autofocus>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label>Last Name</label>
                <input type="text" class="form-control" name="User_Lastname_Update" id="User_Lastname_Update" placeholder="Last Name">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label>Email Address</label>
                <input type="text" class="form-control" name="User_Email_Update" id="User_Email_Update" placeholder="Email Address">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label>Choose Campus</label>
                <select class="form-control" name="User_Campus_Update" id="User_Campus_Update">
                  <?php $pm->PM_Sites_Dropdown();?>
                </select>
                <small class="form-text text-muted">Associate a campus for the user.</small>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label>Enable ANPR?</label>
                <select class="form-control" name="User_ANPR_Update" id="User_ANPR_Update">
                  <option value="0">No</option>
                  <option value="1">Yes</option>
                </select>
                <small class="form-text text-muted">Use the ANPR functions in ParkingManager</small>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label>Choose a Rank</label>
                <select class="form-control" name="User_Rank_Update" id="User_Rank_Update">
                  <?php $pm->PM_Ranks_Dropdown();?>
                </select>
                <small class="form-text text-muted">Caution when selecting a rank!</small>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-body">
          <div class="modal-footer">
            <input type="submit" class="btn btn-primary" id="User_Save_Update" value="Save Changes">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- New User Modal -->
<div class="modal fade" id="User_New" tabindex="-1" role="dialog" aria-labelledby="User_New" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="User_New">New User Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="User_newForm">
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label>First Name</label>
                <input type="text" class="form-control" name="User_Firstname_New" id="User_Firstname_New" placeholder="First Name" autofocus>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label>Last Name</label>
                <input type="text" class="form-control" name="User_Lastname_New" id="User_Lastname_New" placeholder="Last Name">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label>Email Address</label>
                <input type="text" class="form-control" name="User_Email_New" id="User_Email_New" placeholder="Email Address">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="User_Password_New" id="User_Password_New" placeholder="Password">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label>Choose Campus</label>
                <select class="form-control" name="User_Campus_Update" id="User_Campus_New">
                  <?php $pm->PM_Sites_Dropdown();?>
                </select>
                <small class="form-text text-muted">Associate a campus for the user.</small>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label>Enable ANPR?</label>
                <select class="form-control" name="User_ANPR_Update" id="User_ANPR_New">
                  <option value="0">No</option>
                  <option value="1">Yes</option>
                </select>
                <small class="form-text text-muted">Use the ANPR functions in ParkingManager</small>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label>Choose a Rank</label>
                <select class="form-control" name="User_Rank_Update" id="User_Rank_New">
                  <?php $pm->PM_Ranks_Dropdown();?>
                </select>
                <small class="form-text text-muted">Caution when selecting a rank!</small>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-body">
          <div class="modal-footer">
            <input type="submit" class="btn btn-primary" id="User_Save_New" value="Save Changes">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Update Vehicle Type -->
<div class="modal fade" id="Update_Vehicle_TypeModal" tabindex="-1" role="dialog" aria-labelledby="Update_Vehicle_TypeModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="Update_Vehicle_TypeModal">Update Vehicle Type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="Update_Vehicle_TypeForm">
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label>Vehicle Type Name</label>
                <input type="hidden" id="Update_Type_ID" class="form-control" autofocus>
                <input type="text" class="form-control" id="Update_Type_Name" placeholder="Cab & Trailer" autofocus>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label>Vehicle Name Short</label>
                <input type="text" class="form-control" id="Update_Type_Short" placeholder="C/T" style="text-transform: uppercase;">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label>Vehicle Image URL</label>
                <input type="text" class="form-control" id="Update_Type_ImageURL" placeholder="http://example.com/img.png">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-body">
          <div class="modal-footer">
            <input type="submit" class="btn btn-primary" id="Update_Type_Save" value="Save Changes">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Update Account Info -->
<div class="modal fade" id="Update_AccountModal" tabindex="-1" role="dialog" aria-labelledby="Update_AccountModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="Update_AccountModal">Update Account Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="Update_AccountForm">
          <div class="col">
            <div class="form-group">
              <label>Account Name</label>
              <input type="hidden" id="Update_Account_ID" class="form-control">
              <input type="text" class="form-control" id="Update_Account_Name" placeholder="Company Name" autofocus>
            </div>
            <label>Short name (used as company name on parking record)</label>
            <div class="form-group">
              <input type="text" class="form-control" id="Update_Account_Name_Short" placeholder="Short Name">
            </div>
          </div>
          <div class="col">
            <div class="form-group">
              <label>Account Contact Number</label>
              <input type="text" class="form-control" id="Update_Account_Tel" placeholder="+7373266364" style="text-transform: uppercase;">
            </div>
          </div>
          <div class="col">
            <div class="form-group">
              <label>Account Contact Email</label>
              <input type="text" class="form-control" id="Update_Account_Email" placeholder="example@account.com">
            </div>
          </div>
          <div class="col">
            <div class="form-group">
              <label>Account Billing Email</label>
              <input type="text" class="form-control" id="Update_Account_Billing_Email" placeholder="example@account.com">
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label>Account Site</label>
                <select class="form-control" id="Update_Account_Campus">
                  <?php $pm->PM_Sites_Dropdown() ?>
                </select>
              </div>
              <div class="form-group">
                <label>Share Account</label>
                <select class="form-control" id="Update_Account_Share">
                  <option value="0">No</option>
                  <option value="1">Yes</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-body">
          <div class="modal-footer">
            <input type="submit" class="btn btn-primary" id="Update_Account_Save" value="Save Changes">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- New Account Info -->
<div class="modal fade" id="New_AccountModal" tabindex="-1" role="dialog" aria-labelledby="New_AccountModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="New_AccountModal">Register New Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="New_AccountModalForm">
          <div class="col">
            <div class="form-group">
              <label>Account Name</label>
              <input type="text" class="form-control" id="New_Account_Name" placeholder="Company Name" autofocus>
            </div>
            <label>Short name (used as company name on parking record)</label>
            <div class="form-group">
              <input type="text" class="form-control" id="New_Account_Name_Short" placeholder="Short Name">
            </div>
          </div>
          <div class="col">
            <div class="form-group">
              <label>Account Contact Number</label>
              <input type="text" class="form-control" id="New_Account_Tel" placeholder="+7373266364" style="text-transform: uppercase;">
            </div>
          </div>
          <div class="col">
            <div class="form-group">
              <label>Account Contact Email</label>
              <input type="text" class="form-control" id="New_Account_Email" placeholder="example@account.com">
            </div>
          </div>
          <div class="col">
            <div class="form-group">
              <label>Account Billing Email</label>
              <input type="text" class="form-control" id="New_Account_Billing_Email" placeholder="example@account.com">
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label>Account Site</label>
                <select class="form-control" id="New_Account_Campus">
                  <?php $pm->PM_Sites_Dropdown() ?>
                </select>
              </div>
              <div class="form-group">
                <label>Share Account</label>
                <select class="form-control" id="New_Account_Share">
                  <option value="0">No</option>
                  <option value="1">Yes</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-body">
          <div class="modal-footer">
            <input type="submit" class="btn btn-primary" id="New_Account_Save" value="Save Changes">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Update Fleet Modal -->
<div class="modal fade" id="Update_Account_FleetModal" tabindex="-1" role="dialog" aria-labelledby="Update_Account_FleetModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="Update_Account_FleetModal">Update Account Fleet</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="Update_AccountFleet">
          <div class="col">
            <div class="form-group">
              <label>Add a vehicle to this Accounts fleet</label>
              <input type="hidden" id="Account_ID" class="form-control" autofocus>
              <input type="text" class="form-control" id="Update_Account_Fleet_Plate" placeholder="Press ENTER to save" style="text-transform: uppercase;" autofocus>
            </div>
            <div id="fleets">

            </div>
          </div>
        </form>
      </div>
      <div class="modal-body">
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Delete payment modal -->
<div class="modal fade" id="Delete_Payment_Modal" tabindex="-1" role="dialog" aria-labelledby="Delete_Payment_Modal" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="Delete_Payment_Modal">Delete Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="DeletePaymentForm">
      <div class="modal-body">
          <div class="col">
            <div class="form-group">
              <label>Reason for deleting this transaction</label>
              <input type="hidden" id="Payment_ID" class="form-control">
              <input type="text" class="form-control" id="Payment_Delete_Comment" placeholder="Please supply a valid reason!" autofocus>
            </div>
          </div>
      </div>
      <div class="modal-body">
        <div class="modal-footer">
          <input type="submit" id="Payment_Delete_Submit" class="btn btn-danger" data-dismiss="modal" value="Delete Payment">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>
<!-- USER PW CHANGE -->
<div class="modal fade" id="User_Change_PW" tabindex="-1" role="dialog" aria-labelledby="User_Change_PW" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="User_Change_PW_Title">Update Password</h5>
      </div>
      <form class="form-group" id="User_Change_PW_Form" method="post">
        <div class="modal-body">
            <input type="hidden" name="User_ID" id="User_ID_ChangePW">
            <label>New Password</label>
            <input type="password" class="form-control" name="User_Password" id="User_New_Password" placeholder="Password" autofocus>
            <label>Confirm new password</label>
            <input type="password" class="form-control" id="User_New_Password_Confirm" placeholder="Password">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" id="User_Change_PW_Confirm">Confirm Change</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Print Ticket modal -->
<div class="modal fade" id="Print_Ticket_Modal" tabindex="-1" role="dialog" aria-labelledby="Print_Ticket_Modal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="Print_Ticket_Modal">Print Ticket?</h5>
      </div>
      <div class="modal-body">
        Would you like to print a parking ticket for this transaction now?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" tabindex="1" autofocus id="NT_Print_Ticket_Yes">Yes</button>
        <button type="button" class="btn btn-danger" tabindex="2" id="NT_Print_Ticket_No">No</button>
      </div>
    </div>
  </div>
</div>
<!-- ANPR Filter Search -->
<div class="modal fade" id="ANPR_FilterSearchModal" tabindex="-1" role="dialog" aria-labelledby="ANPR_FilterSearchModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ANPR_FilterSearchModal">ANPR Filtered Search</h5>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <input type="text" class="form-control" id="ANPR_Filter" placeholder="Enter the plate you require" autofocus>
        </div>
        <div id="ANPR_FilterResult">

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- ANPR Exit -->
<div class="modal fade" id="ANPR_Exit_Log" tabindex="-1" role="dialog" aria-labelledby="ANPR_Exit_Log" aria-hidden="true">
  <div class="modal-dialog modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ANPR_Exit_Log">ANPR Exit Feed</h5>
      </div>
      <div class="modal-body">
        <?php $pm->PM_ExitList() ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Warning Modal -->
<div class="modal fade" id="WarningModal" tabindex="-1" role="dialog" aria-labelledby="WarningModal" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content bg-danger" style="border: inherit;">
      <div class="modal-header bg-danger">
        <h5 class="modal-title">Warning</h5>
      </div>
      <div class="modal-body">
        <div id="WarningInfo">

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
