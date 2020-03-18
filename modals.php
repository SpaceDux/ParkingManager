<!-- Register User modal -->
<div class="modal" id="User_JoinModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Join Us At Roadking</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="JoinForm">
        <div class="modal-body">
          <div class="row">
            <div class="col">
              <p>In-order to pre-book your parking with us, you'll need to register for our online portal, that you can access anytime, anywhere.</p>
              <div id="User_JoinModal_Error"></div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="Join_FirstName">First Name</label>
              <input type="text" class="form-control" name="Join_FirstName" id="Join_FirstName" placeholder="John" autofocus required>
            </div>
            <div class="col">
              <label for="Join_LastName">Last Name</label>
              <input type="text" class="form-control" name="Join_LastName" id="Join_LastName" placeholder="Doe" required>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col">
              <label for="Join_Email">Email Address</label>
              <input type="email" class="form-control" name="Join_Email" id="Join_Email" placeholder="example@example.com" required>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col">
              <label for="Join_Password">Password</label>
              <input type="password" class="form-control" name="Join_Password" id="Join_Password" placeholder="Password" required>
            </div>
            <div class="col">
              <label for="Join_ConPassword">Confirm Password</label>
              <input type="password" class="form-control" name="Join_ConPassword" id="Join_ConPassword"  placeholder="Confirm Password" required>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col">
              <label for="Join_Telephone">Contact Number</label>
              <input type="phone" class="form-control" name="Join_Telephone" id="Join_Telephone" placeholder="Example: 0333 023 5360" required>
            </div>
          </div>
        </div>
      </form>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="JoinForm_Submit" class="btn btn-primary">Sign Up</button>
        </div>
    </div>
  </div>
</div>
<!-- Choose a Site Modal -->
<div class="modal" id="Booking_BookSiteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pick a Site</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="Booking_BookSiteModalForm">
        <div class="modal-body">
          <div class="row">
            <div class="col">
              <p>Where would you like to prebook your parking?</p>
              <div id="Booking_BookSiteModalForm_Error"></div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <select class="form-control form-control-lg" name="Site" id="Booking_BookSite">
                <option value="0">-- Please Choose a Site --</option>
                {SITES}
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <input type="submit" class="btn btn-primary" value="Confirm Site"/>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Booking Modal -->
<div class="modal" id="Booking_BookModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pre-book your Parking</h5>
      </div>
      <form id="Booking_BookModalForm">
        <div class="modal-body">
          <div class="row">
            <div class="col">
              <div id="Booking_BookModal_Note"></div>
              <br>
              <div id="Booking_BookModal_Error"></div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label>Choose your vehicle.</label>
              <select class="form-control form-control-lg" name="Vehicle" required>
                {MYVEHICLES}
              </select>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col">
              <label>What type of vehicle are you checking in with?</label>
              <select class="form-control form-control-lg" name="Type" required>
                <option value="1">Cab & Trailer</option>
                <option value="8">Car Transporter</option>
                <option value="2">Cab Only</option>
                <option value="4">Rigid</option>
                <option value="5">Coach</option>
              </select>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col">
              <label>What is your Estimated Time of Arrival?</label>
              <input type="time" class="form-control form-control-lg" name="ETA" value="14:00" min="14:00" required>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col">
              <label>How long with you be parking with us?</label>
              <select class="form-control form-control-lg" name="Break" required>
                <option value="1">Between 6 & 12 Hours</option>
                <option value="2">Between 12 & 24 Hours</option>
                <option value="3">Between 24+ Hours</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" onClick="Booking_MidwayCancel()">Cancel</button>
          <input type="submit" class="btn btn-primary" value="Confirm Booking"/>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- T&C's after booking -->
<div class="modal" id="Booking_BookTCSModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Booking Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col">
            <div id="Booking_Confirmation_Note"></div>
            <hr>
            <?php echo file_get_contents("email_templates/booking_rules.html", __DIR__); ?>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Cancel a booking -->
<div class="modal" id="Booking_CancelModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cancel Booking</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col">
            <div id="Booking_Cancelled_Note"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="Booking_CancelModal_YES" data-dismiss="modal">Yes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
<!-- Cancel a booking confirmed -->
<div class="modal" id="Booking_CancelConfirmModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Booking Cancelled</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col">
            <div id="Booking_CancelledConfirm_Note"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Change Password -->
<div class="modal" id="User_ChangePassword_Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Change your Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="User_ChangePassword_Form">
          <div class="row">
            <div class="col">
              <div id="User_ChangePassword_Note"></div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="Current_Password">Enter your current password.</label>
              <input class="form-control" type="password"  name="Current_Password" placeholder="Enter your current password." autofocus>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col">
              <label for="New_Password">Enter your new password.</label>
              <input class="form-control" type="password" name="New_Password" placeholder="Enter your new password">
            </div>
            <div class="col">
              <label for="Con_New_Password">Confirm your new password.</label>
              <input class="form-control" type="password"  name="Con_New_Password" placeholder="Confirm your new password">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
