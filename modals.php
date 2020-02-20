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
