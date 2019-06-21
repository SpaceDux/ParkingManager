<script type="text/javascript">
  // Mark a record as Duplicate
  function ANPR_Duplicate(str) {
    event.preventDefault();
    $('#ANPR_Feed_'+str).addClass('Hide');
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.ANPR_Duplicate",
      method: "POST",
      data: {Uniqueref:str}
    });
  }
  //Refresh ANPR feed
  function ANPR_Feed_Refresh() {
    event.preventDefault();
    $('#ANPR_Feed').html('<img style="width: 90px;display: block;margin: 0 auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.ANPR_Feed",
      method: "POST",
      dataType: "text",
      success:function(Response) {
        $('#ANPR_Feed').html(Response);
      }
    });
  }
  // Add a vehicle into the anpr feed
  function ANPR_AddPlate() {
    event.preventDefault();
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.ANPR_AddPlate",
      method: "POST",
      dataType: "text",
      success:function() {
        ANPR_Feed_Refresh();

      }
    });
  }
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
  // Add a vehicle into the anpr feed
</script>
