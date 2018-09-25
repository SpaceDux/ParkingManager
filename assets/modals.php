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
                <input type="text" id="Service_Name" class="form-control" placeholder="24Hour Cab Only" autofocus>
              </div>
            </div>
            <div class="col-md-6">
              <label for="Service_Price_Gross">Service Price (Gross)</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">£</span>
                </div>
                <input type="text" id="Service_Price_Gross" class="form-control" placeholder="10...">
              </div>
            </div>
            <div class="col-md-6">
              <label for="Service_Price_Net">Service Price (Net)</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">£</span>
                </div>
                <input type="text" id="Service_Price_Net" class="form-control" placeholder="10...">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="Service_Expiry">Service Expiry</label>
                <input type="number" id="Service_Expiry" class="form-control" placeholder="24 (Hours)">
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <lable>Accept Cash Transactions</label>
                  <br>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-secondary active">
                    <input type="radio" name="Service_Cash" id="Service_Cash" autocomplete="off" value="1" checked> Accept
                  </label>
                  <label class="btn btn-secondary">
                    <input type="radio" name="Service_Cash" id="Service_Cash" autocomplete="off" value="0"> Don't Accept
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label>Accept Card Transactions</label>
                <br>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-secondary active">
                    <input type="radio" name="Service_Card" id="Service_Card" autocomplete="off" value="1" checked> Accept
                  </label>
                  <label class="btn btn-secondary">
                    <input type="radio" name="Service_Card" id="Service_Card" autocomplete="off" value="0"> Don't Accept
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label>Accept Account Transactions</label>
                <br>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-secondary active">
                    <input type="radio" name="Service_Account" id="Service_Account" autocomplete="off" value="1" checked> Accept
                  </label>
                  <label class="btn btn-secondary">
                    <input type="radio" name="Service_Account" id="Service_Account" autocomplete="off" value="0"> Don't Accept
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
                    <input type="radio" name="Service_Snap" id="Service_Snap" autocomplete="off" value="1" checked> Accept
                  </label>
                  <label class="btn btn-secondary">
                    <input type="radio" name="Service_Snap" id="Service_Snap" autocomplete="off" value="0"> Don't Accept
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label>Accept Fuel Transactions</label>
                <br>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-secondary active">
                    <input type="radio" name="Service_Fuel" id="Service_Fuel" autocomplete="off" value="1" checked> Accept
                  </label>
                  <label class="btn btn-secondary">
                    <input type="radio" name="Service_Fuel" id="Service_Fuel" autocomplete="off" value="0"> Don't Accept
                  </label>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>Choose a campus</label>
                <select class="form-control" name="Service_Campus" id="Service_Campus">
                  <option selected>Please choose a campus</option>
                  <option values="1">RoadKing: Parc Cybi</option>
                  <option value="2">RoadKing: The New Hollies</option>
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
