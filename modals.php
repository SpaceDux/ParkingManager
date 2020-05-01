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
          <hr>
          <div class="row">
            <div class="col">
              By signing up to our website, you agree to our <a data-target="#CookiePolicy_Modal" data-toggle="modal"><b style="text-decoration: underline;cursor:pointer;">Cookie Policy</b></a> & <a data-target="#PrivacyPolicy_Modal" data-toggle="modal"><b style="text-decoration: underline;cursor:pointer;">Privacy Policy</b></a>
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
            <div class="col">
              <label>What company do you drive for? (OPTIONAL)</label>
              <input type="text" class="form-control form-control-lg" name="Company" placeholder="My Company Ltd">
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col">
              <label>What type of vehicle are you checking in with?</label>
              <select class="form-control form-control-lg" name="Type" required>
                <option value="1">Cab & Trailer</option>
                <option value="8">Car Transporter</option>
                <option value="4">Rigid</option>
                <option value="5">Coach</option>
              </select>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col">
              <label>What is your Estimated Time of Arrival?</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><?php echo date("d/m/y")?> @ </span>
                </div>
                <input type="time" class="form-control form-control-lg" name="ETA" value="<?php echo date("H:00", strtotime('+ 1 hour'))?>" min="14:00" required>
              </div>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col">
              <label>How long will you be parking with us?</label>
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
        <a href="{URL}/home" class="btn btn-secondary" data-dismiss="modal">Close</a>
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
      <form id="User_ChangePassword_Form">
        <div class="modal-body">
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
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-primary" value="Save Changes">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Cookie Policy -->
<div class="modal" id="CookiePolicy_Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Our Cookie Policy</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>
          <h4>1. Why and how we use cookies</h4>
          By using the Roadking Portal website you’re confirming that you’re happy to accept our use of cookies. Here you can find out more about how we use them. If you are concerned about cookies, it is important that you read about and understand their usage. They are very important to the working of this website as they are involved in the user functionality.
          <br>
          <h4>What are cookies?</h4>
          Cookies are small, harmless files placed on your computer’s hard drive or in your browser memory when you visit a website.
          <br>
          <h4>What do cookies do?</h4>
          Cookies help to make the interaction between users and websites faster and easier. For example, they can remember your login details or information you supply as you set up your user account. What cookies don't do is store any personal or confidential information about you.
          <br>
          <h4>Are cookies safe?</h4>
          Yes, cookies are harmless text files. They can’t look into your computer or read any personal information or other material on your hard drive. Cookies can’t carry viruses or install anything harmful on your computer.
          <br>
          <h4>Why should I keep cookies switched on?</h4>
          We advise you to keep cookies active during your visits to our website because parts of the site rely on them to work properly. For example, you won’t be able to sign in to your account if cookies are disabled.
          <hr>
          <h4>2. Types of cookie we use</h4>
          Like most large websites, Roadking Portal uses session cookies and persistent cookies. Neither session cookies nor persistent cookies collect any personally identifiable information.
          <br>
          <h4>Session cookies</h4>
          We use session cookies, which last only for the duration of your visit (your 'session') and are deleted when you close your browser. These simply enable us to identify that the same person is moving from page to page.
          <br>
          <h4>Persistent cookies</h4>
          We use certain cookies that are persistent, meaning that they last beyond your session. Persistent cookies help our website remember you as a user each time you use the same computer to revisit us.
          <br>
          <h4>Third party cookies</h4>
          As well as using cookies from our advertising partners, from time to time we may also embed external content from other third party websites within our website. These include sites such as Facebook and Twitter, whose cookie usage policy you can view on their own websites.
          <hr>
          <h4>3. Turning cookies on or off</h4>
          You have a number of options when it comes to receiving cookies. You can set your browser either to reject all cookies, to allow only ‘trusted’ sites to send them, or to accept only those cookies from websites you are currently using.
          <br>
          We recommend that you don’t block all cookies because parts of our website rely on them to work properly.
          If you prefer not to receive cookies then you won't be able to set up a user account or use some of the services we offer because both rely on cookies to function effectively.
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Privacy Policy -->
<div class="modal" id="PrivacyPolicy_Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Our Privacy Policy</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>
          The New Hollies Limited, <b>Trading as Roadking</b>.
          <br>
          Company Number: 07477525
          <br>
          Address;
          The New Hollies,
          Watling St,
          Four Crosses,
          Cannock,
          WS11 1SB
          <br>
          This privacy policy will explain how our company uses the personal data we collect from you when you use our websites.
          <br>
          Personal identification information (Name, email address, phone number, etc).
          <br>
          Vehicle identification information (registration number)
          <hr>
          How do we collect your data?
          You directly provide Roadking with most of the data we collect. We collect data and process data when you register your account & when you make a booking.
          <hr>
          <h4>How do we store your data?</h4>
          Roadking securely stores your data in our secure databases.
          <br>
          Roadking will keep your Names, Email Address, Telephone Number, Vehicle Information until you request otherwise. We will permenantly delete your data from all of our databases for all Roadking services upon request.
          <hr>
          <h4>Marketing</h4>
          Roadking would like to send you information about products and services of ours that we think you might like.
          <br>
          If you have agreed to receive marketing, you may always opt out at a later date.
          <br>
          You have the right at any time to stop Roadking from contacting you for marketing purposes.
          <br>
          <hr>
          <h4>What are your data protection rights?</h4>
          Roadking would like to make sure you are fully aware of all of your data protection rights. Every user is entitled to the following:
          <br>
          The right to access – You have the right to request Roadking for copies of your personal data. We may charge you a small fee for this service.
          <br>
          The right to rectification – You have the right to request that Roadking correct any information you believe is inaccurate. You also have the right to request Roadking to complete the information you believe is incomplete.
          <br>
          The right to erasure – You have the right to request that Roadking erase your personal data, under certain conditions.
          <br>
          The right to restrict processing – You have the right to request that Roadking restrict the processing of your personal data, under certain conditions.
          <br>
          The right to object to processing – You have the right to object to Roadking’s processing of your personal data, under certain conditions.
          <br>
          The right to data portability – You have the right to request that Roadking transfer the data that we have collected to another organization, or directly to you, under certain conditions.
          <br>
          If you make a request, we have one month to respond to you. If you would like to exercise any of these rights, please contact us at our email:
          <br>
          Call us at: 0333 023 5360
          <br>
          Or write to us: admin@roadkingcafe.co.uk
          <hr>
          <h4>Privacy policies of other websites</h4>
          The Roadking websites may contain links to other websites. Our privacy policy applies only to our websites, so if you click on a link to another website, you should read their privacy policy.
          <hr>
          <h4>Changes to our privacy policy</h4>
          Roadking keeps its privacy policy under regular review and places any updates on this web page. This privacy policy was last updated on 06 April 2020.
          <hr>
          <h4>How to contact us</h4>
          If you have any questions about Roadking’s privacy policy, the data we hold on you, or you would like to exercise one of your data protection rights, please do not hesitate to contact us.
          <br>
          <b>Email us at</b>: admin@roadkingcafe.co.uk
          <br>
          <b>Call us</b>: 0333 023 5360
          <br>
          <b>Or write to us at:</b>
          The New Hollies,
          Watling St,
          Four Crosses,
          Cannock,
          WS11 1SB
          <hr>
          <h4>How to contact the appropriate authority</h4>
          Should you wish to report a complaint or if you feel that Roadking has not addressed your concern in a satisfactory manner, you may contact the Information Commissioner’s Office.
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Forgotten Password -->
<div class="modal" id="ForgottenPassword_Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Forgot your Password?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Have you forgotten your password? Not to worry, we will send you an email with a code, just supply us with the email address you registered with.</p>
        <hr>
        <div class="row">
          <div class="col">
            <div id="ForgottenPassword_Error">

            </div>
            <input type="hidden" id="ConfirmedCode">
            <div id="ForgottenPassword_Data">
              <label>Email Address</label>
              <input type="email" class="form-control" id="ForgottenPassword_Email" name="EmailAddress" value="" placeholder="example@example.com">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="SendPasswordRecovery">Recover Account</button>
        <button type="button" class="btn btn-secondary" id="RecoveryCloseModal" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Modify Bookin -->
<div class="modal" id="ModifyBooking_Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modify your Booking.</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="ModifyBooking_Form">
        <div class="modal-body">
          <p>Modify your estimated time of arrival or vehicle type below.</p>
          <hr>
          <div class="row">
            <div class="col">
              <div id="ModifyBooking_Error"></div>
              <input type="hidden" name="Ref" id="ModifyBooking_Ref">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="ModifyBooking_ETA_Prepend"></span>
                </div>
                <input type="time" class="form-control form-control-lg" name="ETA" id="ModifyBooking_ETA" min="14:00" required>
              </div>
              <hr>
              <label>Vehicle Type</label>
              <select class="form-control" name="VehicleType" id="ModifyBooking_VehicleType">
                <option value="1">Cab & Trailer</option>
                <option value="8">Car Transporter</option>
                <option value="4">Rigid</option>
                <option value="5">Coach</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="ModifyBooking_Save">Save Changes</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
