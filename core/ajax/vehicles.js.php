<script type="text/javascript">
  // ANPR Feed
  $('#ANPR_Feed').ready(function() {
    $('#ANPR_Feed').html('<img style="width: 90px;display: block;margin: 0 auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.ANPR_Feed",
      method: "POST",
      dataType: "text",
      success:function(Response) {
        $('#ANPR_Feed').html(Response);
      }
    });
  });
  // PAID Feed
  $('#PAID_Feed').ready(function() {
    $('#PAID_Feed').html('<img style="width: 90px;display: block;margin: 0 auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.PAID_Feed",
      method: "POST",
      dataType: "text",
      success:function(Response) {
        $('#PAID_Feed').html(Response);
      }
    });
  });
  // RENEWAL Feed
  $('#RENEWAL_Feed').ready(function() {
    $('#RENEWAL_Feed').html('<img style="width: 90px;display: block;margin: 0 auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.RENEWAL_Feed",
      method: "POST",
      dataType: "text",
      success:function(Response) {
        $('#RENEWAL_Feed').html(Response);
      }
    });
  });
  // EXIT Feed
  $('#EXIT_Feed').ready(function() {
    $('#EXIT_Feed').html('<img style="width: 90px;display: block;margin: 0 auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.EXIT_Feed",
      method: "POST",
      dataType: "text",
      success:function(Response) {
        $('#EXIT_Feed').html(Response);
      }
    });
  });
</script>
