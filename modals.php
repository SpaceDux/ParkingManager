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
            <input type="text" class="form-control" name="Time" id="AddPlate_Time">
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
<div class="modal fade" id="Payment_ConfirmationCash_Modal" tabindex="-1" role="dialog" aria-labelledby="Payment_ConfirmationCash_Modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Cash Transaction</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Please confirm that all information is correct and you would like to proceed with the
        <b>Cash</b> transaction.
        <br>
        <br>
        Once you click proceed, all information is then final.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" onClick="AuthorisePayment('1')">Proceed</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="Payment_ConfirmationCard_Modal" tabindex="-1" role="dialog" aria-labelledby="Payment_ConfirmationCard_Modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Card Transaction</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Please confirm that all information is correct and you would like to proceed with the
        <b>Card</b> transaction.
        <br>
        <br>
        Once you click proceed, all information is then final.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" onClick="AuthorisePayment('2')">Proceed</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="Payment_ConfirmationAcc_Modal" tabindex="-1" role="dialog" aria-labelledby="Payment_ConfirmationAcc_Modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Account Transaction</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Please confirm that all information is correct and you would like to proceed with the
        <b>Account / KingPay</b> transaction.
        <br>
        <br>
        Once you click proceed, all information is then final.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" onClick="AuthorisePayment('3')">Proceed</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="Payment_ConfirmationSNAP_Modal" tabindex="-1" role="dialog" aria-labelledby="Payment_ConfirmationSNAP_Modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm SNAP Transaction</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Please confirm that all information is correct and you would like to proceed with the
        <b>Account</b> transaction.
        <br>
        <br>
        Once you click proceed, all information is then final.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" onClick="AuthorisePayment('4')">Proceed</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="Payment_ConfirmationFuel_Modal" tabindex="-1" role="dialog" aria-labelledby="Payment_ConfirmationFuel_Modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Fuel Card Transaction</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Please confirm that all information is correct and you would like to proceed with the
        <b>Fuel Card</b> transaction.
        <br>
        <br>
        Once you click proceed, all information is then final.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" onClick="AuthorisePayment('5')">Proceed</button>
      </div>
    </div>
  </div>
</div>
