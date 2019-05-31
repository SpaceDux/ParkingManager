<script type="text/javascript">
  // Login
  $('#NotificationsBtn').on('click', function() {
    event.preventDefault();
    $('#Load_Notifications').html('<img style="width: 70px;display: block;margin: 50% auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
    $.ajax({
      url: "{URL}/core/ajax/pm.handler.php?handler=PM.GET_Notifications",
      method: "POST",
      dataType: "text",
      success:function(Response) {
        $('#Load_Notifications').html(Response);
      }
    });
  });

</script>
