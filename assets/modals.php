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
              <input type="text" style="text-transform: uppercase;" id="ANPR_Add_Date" class="form-control" value="<?php echo date("Y-m-d H:i:s")?>">
            </div>
          </div>
          <div class="modal-body">
            <div id="return">

            </div>
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
<!-- ANPR Images Modal -->
<div class="modal fade" id="ANPR_ImageModal" tabindex="-1" role="dialog" aria-labelledby="ANPR_UpdateModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ANPR_ImageModal">ANPR Images</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="ANPR_Images">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Add Payment Service -->
<div class="modal fade" id="Payment_Service_AddModal" tabindex="-1" role="dialog" aria-labelledby="Payment_Service_AddModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="Payment_Service_AddModal">Add Payment Service</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="Payment_Service_AddForm">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="Service_Name">Service Name</label>
                <input type="text" id="Service_Name" class="form-control" placeholder="24Hour Cab Only" autofocus required>
              </div>
            </div>
            <div class="col-md-6">
              <label for="Service_Price_Gross">Service Price (Gross)</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">£</span>
                </div>
                <input type="text" id="Service_Price_Gross" class="form-control" placeholder="10..." required>
              </div>
            </div>
            <div class="col-md-6">
              <label for="Service_Price_Net">Service Price (Net)</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">£</span>
                </div>
                <input type="text" id="Service_Price_Net" class="form-control" placeholder="10..." required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="Service_Expiry">Service Expiry</label>
                <input type="number" id="Service_Expiry" class="form-control" placeholder="24 (Hours)" required>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <lable>Accept Cash Transactions</label>
                  <br>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-secondary active">
                    <input type="radio" name="Service_Cash" class="Service_Cash" autocomplete="off" value="1" checked> Accept
                  </label>
                  <label class="btn btn-secondary">
                    <input type="radio" name="Service_Cash" class="Service_Cash" autocomplete="off" value="0"> Don't Accept
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label>Accept Card Transactions</label>
                <br>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-secondary active">
                    <input type="radio" name="Service_Card" class="Service_Card" autocomplete="off" value="1" checked> Accept
                  </label>
                  <label class="btn btn-secondary">
                    <input type="radio" name="Service_Card" class="Service_Card" autocomplete="off" value="0"> Don't Accept
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label>Accept Account Transactions</label>
                <br>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-secondary active">
                    <input type="radio" name="Service_Account" class="Service_Account" autocomplete="off" value="1" checked> Accept
                  </label>
                  <label class="btn btn-secondary">
                    <input type="radio" name="Service_Account" class="Service_Account" autocomplete="off" value="0"> Don't Accept
                  </label>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label>Accept SNAP Transactions</label>
                <br>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-secondary active">
                    <input type="radio" name="Service_Snap" class="Service_Snap" autocomplete="off" value="1" checked> Accept
                  </label>
                  <label class="btn btn-secondary">
                    <input type="radio" name="Service_Snap" class="Service_Snap" autocomplete="off" value="0"> Don't Accept
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label>Accept Fuel Transactions</label>
                <br>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-secondary active">
                    <input type="radio" name="Service_Fuel" class="Service_Fuel" autocomplete="off" value="1" checked> Accept
                  </label>
                  <label class="btn btn-secondary">
                    <input type="radio" name="Service_Fuel" class="Service_Fuel" autocomplete="off" value="0"> Don't Accept
                  </label>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>Choose a campus</label>
                <select class="form-control" name="Service_Campus" id="Service_Campus" required>
                  <?php $pm->PM_CampusSelectList(); ?>
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
            <div class="col-md-12">
              <div class="form-group">
                <label for="Service_Name">Service Name</label>
                <input type="hidden" id="Service_ID_Update" class="form-control" autofocus>
                <input type="text" id="Service_Name_Update" class="form-control" placeholder="24Hour Cab Only" autofocus>
              </div>
            </div>
            <div class="col-md-6">
              <label for="Service_Price_Gross">Service Price (Gross)</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">£</span>
                </div>
                <input type="text" id="Service_Price_Gross_Update" class="form-control" placeholder="10...">
              </div>
            </div>
            <div class="col-md-6">
              <label for="Service_Price_Net">Service Price (Net)</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">£</span>
                </div>
                <input type="text" id="Service_Price_Net_Update" class="form-control" placeholder="10...">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="Service_Expiry">Service Expiry</label>
                <input type="number" id="Service_Expiry_Update" class="form-control" placeholder="24 (Hours)">
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label>Accept Cash Transactions</label>
                <select class="form-control" name="Service_Cash_Update" id="Service_Cash_Update">
                  <option value="1">Accept Cash</option>
                  <option value="0">Don't Accept Cash</option>
                </select>
              </div>
              <div class="form-group">
                <label>Accept Card Transactions</label>
                <select class="form-control" name="Service_Card_Update" id="Service_Card_Update">
                  <option value="1">Accept Card</option>
                  <option value="0">Don't Accept Card</option>
                </select>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label>Accept Account Transactions</label>
                <select class="form-control" name="Service_Account_Update" id="Service_Account_Update">
                  <option value="1">Accept Account</option>
                  <option value="0">Don't Accept Account</option>
                </select>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label>Accept Fuel Card Transactions</label>
                <select class="form-control" name="Service_Fuel_Update" id="Service_Fuel_Update">
                  <option value="1">Accept Fuel Card</option>
                  <option value="0">Don't Accept Fuel Card</option>
                </select>
              </div>
              <div class="form-group">
                <label>Accept SNAP Transactions</label>
                <select class="form-control" name="Service_Snap_Update" id="Service_Snap_Update">
                  <option value="1">Accept SNAP</option>
                  <option value="0">Don't Accept SNAP</option>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>Choose a campus</label>
                <select class="form-control" name="Service_Campus_Update" id="Service_Campus_Update">
                  <?php $pm->PM_CampusSelectList();?>
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
                <input type="text" class="form-control" name="User_Firstname_Update" id="User_Firstname_Update" placeholder="First Name">
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
                <label>Password</label>
                <input type="password" class="form-control" name="User_Password_Update" id="User_Password_Update" placeholder="Password">
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" class="form-control" name="User_Password2_Update" id="User_Password2_Update" placeholder="Password">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label>Choose Campus</label>
                <select class="form-control" name="User_Campus_Update" id="User_Campus_Update">
                  <?php $pm->PM_CampusSelectList();?>
                </select>
                <small id="User_Campus_Update" class="form-text text-muted">Associate a campus for the user.</small>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label>Enable ANPR?</label>
                <select class="form-control" name="User_ANPR_Update" id="User_ANPR_Update">
                  <option value="0">No</option>
                  <option value="1">Yes</option>
                </select>
                <small id="User_Campus_Update" class="form-text text-muted">Use the ANPR functions in ParkingManager</small>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label>Choose a Rank</label>
                <select class="form-control" name="User_Rank_Update" id="User_Rank_Update">
                  <?php $pm->PM_RankSelectList();?>
                </select>
                <small id="User_Rank_Update" class="form-text text-muted">Caution when selecting a rank!</small>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-body">
          <div class="modal-footer">
            <input type="submit" class="btn btn-primary" id="User_Update" value="Save Changes">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
