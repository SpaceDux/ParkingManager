<script type="text/javascript">
  // Login
  $('#Login_Form').on('submit', function() {
    event.preventDefault();
    var Data = $(this).serialize();
    $.ajax({
      url: "{URL}/core/ajax/user.handler.php?handler=User.Login",
      data: Data,
      method: "POST",
      dataType: "json",
      success:function(Response) {
        if(Response.Code != "0") {
          $('.AlertInfo').html('<div class="alert alert-warning alert-dismissible fade show" role="alert">'+Response.Text+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
          $('.AlertInfo').html('<div class="alert alert-success alert-dismissible fade show" role="alert">'+Response.Text+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          setTimeout(function() {
            window.location.reload();
          }, 3000)
        }
      }
    });
  });
  $(document).on('submit', '#User_Register_Form', function(e) {
    e.preventDefault();
    var Data = $('#User_Register_Form').serialize();
    $.ajax({
      url: "{URL}/core/ajax/user.handler.php?handler=User.Register",
      data: Data,
      method: "POST",
      dataType: "json",
      success:function(Data) {
        if(Data.Result == 1) {
          $.notify(Data.Message, {className:'success',globalPosition: 'top left',});
          $('#User_Register_Modal').modal('toggle');
          $('#User_Register_Form')[0].reset();
        } else {
          $.notify(Data.Message, {className:'error',globalPosition: 'top left',});
        }
      }
    })
  })

  function Update_Password(Ref) {
    event.preventDefault();
    $('#User_UpdatePW_Modal').modal('toggle');
    $('input[name="Ref"]').val(Ref);
  }

  $(document).on('submit', '#User_Update_Form', function() {
    event.preventDefault();
    var Data = $(this).serialize();
    $.ajax({
      url: "{URL}/core/ajax/user.handler.php?handler=User.Update",
      data: Data,
      method: "POST",
      dataType: "json",
      success:function(Data) {
        if(Data.Result == 1) {
          $.notify(Data.Message, {className:'success',globalPosition: 'top left',});
          $('#User_Update_Modal').modal('toggle');
          $('#User_Update_Form')[0].reset();
        } else {
          $.notify(Data.Message, {className:'error',globalPosition: 'top left',});
        }
      }
    })
  })

  $(document).on('submit', '#User_UpdatePW_Form', function() {
    event.preventDefault();
    var Data = $(this).serialize();
    $.ajax({
      url: "{URL}/core/ajax/user.handler.php?handler=User.UpdatePW",
      data: Data,
      method: "POST",
      dataType: "json",
      success:function(Data) {
        if(Data.Result == 1) {
          $.notify(Data.Message, {className:'success',globalPosition: 'top left',});
          $('#User_UpdatePW_Modal').modal('toggle');
          $('#User_UpdatePW_Form')[0].reset();
        } else {
          $.notify(Data.Message, {className:'error',globalPosition: 'top left',});
        }
      }
    })
  })

  function Logout() {
    $.ajax({
      url: "{URL}/core/ajax/user.handler.php?handler=User.Logout",
      method: "POST",
      success:function() {
        window.location.reload();
      }
    });
  }

  function Update_User(Ref) {
    $.ajax({
      url: "{URL}/core/ajax/user.handler.php?handler=User.Update_GET",
      data: {Ref:Ref},
      method: "POST",
      dataType: "json",
      success:function(Data) {
        $('#User_Ref').val(Data.Uniqueref);
        $('#User_FirstName').val(Data.FirstName);
        $('#User_LastName').val(Data.LastName);
        $('#User_Email').val(Data.Email);
        $('#User_Site').val(Data.Site);
        $('#User_ANPR').val(Data.ANPR);
        $('#User_Rank').val(Data.User_Rank);
        $('#User_Printer').val(Data.Printer);
        $('#User_Status').val(Data.Status);
        $('#User_Update_Modal').modal('toggle');
      }
    })
  }

</script>
