<script type="text/javascript">
  $(document).ready(function() {
    // Registration form submit
    $(document).on('click', '#JoinForm_Submit', function() {
      event.preventDefault();
      if(document.getElementById("JoinForm_Submit").hasAttribute('disabled')) {
        // Do nothing
      } else {
        document.getElementById("JoinForm_Submit").setAttribute('disabled', true);
        var Data = $('#JoinForm').serialize();
        $.ajax({
          url: "{URL}/core/ajax/user.handler.php?handler=User.User_Registration",
          data: Data,
          method: "POST",
          dataType: "json",
          success:function(Response)
          {
            if(Response.Result < 1) {
              $('#User_JoinModal_Error').html('<div class="alert alert-danger">'+Response.Message+'</div>');
              document.getElementById("JoinForm_Submit").removeAttribute('disabled', true);
            } else {
              $('#User_JoinModal_Error').html('<div class="alert alert-success">'+Response.Message+'</div>');
            }
          }
        });
        return false;
      }
    });
    // Login Form submit
    $(document).on('submit', '#LoginForm', function() {
      event.preventDefault();
      var Data = $('#LoginForm').serialize();
      $.ajax({
        url: "{URL}/core/ajax/user.handler.php?handler=User.User_Login",
        data: Data,
        method: "POST",
        dataType: "json",
        success:function(Response)
        {
          if(Response.Result < 1) {
            $('#User_LoginForm_Error').html('<div class="alert alert-danger">'+Response.Message+'</div>');
          } else {
            $('#User_LoginForm_Error').html('<div class="alert alert-success">'+Response.Message+'</div>');
            setInterval(function() {
              location.replace("{URL}/home");
            }, 3000);
          }
        }
      });
      return false;
    });
    // Update USER Account form
    $(document).on('submit', '#Update_UserForm', function() {
      event.preventDefault();
      var Data = $(this).serialize();
      $.ajax({
        url: "{URL}/core/ajax/user.handler.php?handler=User.User_Update",
        data: Data,
        method: "POST",
        dataType: "json",
        success:function(Response)
        {
          if(Response.Result < 1) {
            $('#Update_UserError').html('<div class="alert alert-danger">'+Response.Message+'</div>');
          } else {
            $('#Update_UserError').html('<div class="alert alert-success">'+Response.Message+'</div>');
          }
        }
      });
      return false;
    });
    // Add USER Plates
    $(document).on('submit', '#Update_UserForm', function() {
      event.preventDefault();
      var Data = $(this).serialize();
      $.ajax({
        url: "{URL}/core/ajax/user.handler.php?handler=User.User_Update",
        data: Data,
        method: "POST",
        dataType: "json",
        success:function(Response)
        {
          if(Response.Result < 1) {
            $('#Update_UserError').html('<div class="alert alert-danger">'+Response.Message+'</div>');
          } else {
            $('#Update_UserError').html('<div class="alert alert-success">'+Response.Message+'</div>');
          }
        }
      });
      return false;
    });
    // Change user password
    $(document).on('submit', '#User_ChangePassword_Form', function() {
      event.preventDefault();
      var Data = $(this).serialize();
      $.ajax({
        url: "{URL}/core/ajax/user.handler.php?handler=User.User_ChangePassword",
        data: Data,
        method: "POST",
        dataType: "json",
        success:function(Response)
        {
          if(Response.Result < 1) {
            $('#User_ChangePassword_Note').html('<div class="alert alert-danger">'+Response.Message+'</div>');
          } else {
            $('#User_ChangePassword_Note').html('<div class="alert alert-success">'+Response.Message+'</div>');
          }
        }
      });
    });
    // Forgot Password phase 1
    $(document).on('click', '#SendPasswordRecovery', function() {
      event.preventDefault();
      if(this.hasAttribute('disabled', true)) {
        // Do nothing
      } else {
        $(this).attr('disabled', true);
        $('#RecoveryCloseModal').attr('disabled', true);
        var Email = $('#ForgottenPassword_Email').val();
        if(Email != '') {
          $.ajax({
            url: "{URL}/core/ajax/user.handler.php?handler=User.User_ForgottenPassword_Start",
            data: {Email:Email},
            method: "POST",
            dataType: "json",
            success:function(Response)
            {
              if(Response.Status < 1) {
                $('#SendPasswordRecovery').removeAttr('disabled');
                $('#ForgottenPassword_Error').html('<div class="alert alert-danger">'+Response.Message+'</div>');
              } else {
                $('#SendPasswordRecovery').attr('id', 'ConfirmCode');
                $('#ForgottenPassword_Error').html('<div class="alert alert-success">We have emailed you a recovery code, please enter the code below.</div>');
                $('#ForgottenPassword_Data').html('<label>Enter your code.</label><input type="text" id="ForgottenPassword_Code" class="form-control" required>');
                $('#ConfirmCode').removeAttr('disabled');
                $('#ConfirmCode').html('Confirm Code');
              }
            }
          })
        }
      }
    })
    // Forgot Password phase 2, confirm code.
    $(document).on('click', '#ConfirmCode', function() {
      event.preventDefault();
      if(this.hasAttribute('disabled', true)) {
        // Do nothing
      } else {
        $(this).attr('disabled', true);
        var Code = $('#ForgottenPassword_Code').val();
        if(Code != '') {
          $.ajax({
            url: "{URL}/core/ajax/user.handler.php?handler=User.User_ForgottenPassword_Code",
            data: {Code:Code},
            method: "POST",
            dataType: "json",
            success:function(Response)
            {
              if(Response.Status < 1) {
                $('#ForgottenPassword_Error').html('<div class="alert alert-danger">'+Response.Message+'</div>');
                $('#ConfirmCode').removeAttr('disabled');
              } else {
                $('#ConfirmCode').attr('id', 'ChangePassword');
                $('#ConfirmedCode').val(Code);
                $('#ForgottenPassword_Error').html('<div class="alert alert-success">Great, please enter your new password below.</div>');
                $('#ForgottenPassword_Data').html('<label>Enter your new password.</label><input type="password" id="ForgottenPassword_NewPassword" class="form-control" required><hr><label>Confirm your password.</label><input type="password" id="ForgottenPassword_ConfirmPassword" class="form-control" required>');
                $('#ChangePassword').removeAttr('disabled');
                $('#ChangePassword').html('Change Password');
              }
            }
          })
        }
      }
    })
    // Forgot password phase 3, final stage.
    $(document).on('click', '#ChangePassword', function() {
      event.preventDefault();
      if(this.hasAttribute('disabled', true)) {
        // Do nothing
      } else {
        $(this).attr('disabled', true);
        var Code = $('#ConfirmedCode').val();
        var Pass1 = $('#ForgottenPassword_NewPassword').val();
        var Pass2 = $('#ForgottenPassword_ConfirmPassword').val();
        if(Code != '' && Pass1 != '' && Pass2 != '') {
          $.ajax({
            url: "{URL}/core/ajax/user.handler.php?handler=User.User_ForgottenPassword_Change",
            data: {Code:Code, Pass1:Pass1, Pass2:Pass2},
            method: "POST",
            dataType: "json",
            success:function(Response)
            {
              if(Response.Status < 1) {
                $('#ForgottenPassword_Error').html('<div class="alert alert-danger">'+Response.Message+'</div>');
                $('#ChangePassword').removeAttr('disabled');
              } else {
                $('#ForgottenPassword_Error').html('<div class="alert alert-success">'+Response.Message+'</div>');
                $('#RecoveryCloseModal').removeAttr('disabled');
              }
            }
          })
        }
      }
    })
  });
</script>
