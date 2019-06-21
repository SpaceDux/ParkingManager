<!-- Modal -->
<div class="modal fade" id="ANPR_AddPlate" tabindex="-1" role="dialog" aria-labelledby="ANPR_AddPlate" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Manually add a plate into the ANPR</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-row" id="ANPR_AddPlate">
          <div class="col">
            <label>Registration Plate</label>
            <input type="hidden" class="form-control" id="ANPR_AddPlate_Ref" name="Ref">
            <input type="text" class="form-control" name="Plate" placeholder="GH11GFD" style="text-transform: uppercase;">
          </div>
          <div class="col">
            <label>Time of Arrival</label>
            <input type="text" class="form-control" name="Time" id="Time">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="ANPR_AddPlate_Clear" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
