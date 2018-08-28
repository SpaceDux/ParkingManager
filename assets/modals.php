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
            <input type="text" id="searchPay" class="form-control" placeholder="Search ANPR database">
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
<!-- Add Vehicle to ANPR DB Modal -->
<div class="modal fade" id="addVehicleModal" tabindex="-1" role="dialog" aria-labelledby="addVehicleModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addVehicleModal">Add Vehicle to the ANPR dB</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="addVehicleModalReg">Registration</label>
            <input type="text" class="form-control" id="addVehicleModalReg" placeholder="Vehicle Registration" autofocus>
          </div>
          <div class="form-group">
            <label for="addVehicleModalTimeIN">Time IN</label>
            <input type="text" class="form-control" id="addVehicleModalTimeIN" placeholder="Vehicle Time In">
          </div>
        </form>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">Save <i class="fa fa-save"></i></button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
