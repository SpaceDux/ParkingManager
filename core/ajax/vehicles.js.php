<script type="text/javascript">
  // ANPR Feed
  $(document).ready(function() {
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
  // All other vehicle feeds
  $(document).ready(function() {
    $('#PAID_Feed').html('<img style="width: 90px;display: block;margin: 0 auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
    $('#RENEWAL_Feed').html('<img style="width: 90px;display: block;margin: 0 auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
    $('#EXIT_Feed').html('<img style="width: 90px;display: block;margin: 0 auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.ALLVEH_Feed",
      method: "POST",
      dataType: "json",
      success:function(Response) {
        $('#PAID_Feed').html(Response.Paid);
        $('#RENEWAL_Feed').html(Response.Renew);
        $('#EXIT_Feed').html(Response.Exit);
      }
    });
  });
</script>
