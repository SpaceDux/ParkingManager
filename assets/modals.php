<!-- Search DB Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="searchModal">Search Database Entries</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col">
            <label>Search Vehicle Logs</label>
            <input type="text" id="searchData" class="form-control" placeholder="Search Registration, company, trailer number..." autofocus>
          </div>
          <div class="col">
            <label>Search Transactions</label>
            <input type="text" id="searchPay" class="form-control" placeholder="Search Ticket ID">
          </div>
          <div class="col">
            <label>Search ANPR database</label>
            <input type="text" id="ANPR_Search" class="form-control" placeholder="Search ANPR database">
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
            <input type="submit" onClick="saveANPR()" class="btn btn-primary" value="Save Changes">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
