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
  // User Logout

</script>
