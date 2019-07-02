<script type="text/javascript">
  // Microfunc to determine current datetime
  function addZero(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
  }
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
      dataType: "json",
      success:function(Response) {
        $('#ANPR_Feed').html(Response.Feed);
      }
    });
  }
  // Add a vehicle into the anpr feed
  function ANPR_AddPlate() {
    var d = new Date();
    var date = d.getFullYear()+'-'+(d.getMonth()+1)+'-'+d.getDate();
    var h = addZero(d.getHours());
    var m = addZero(d.getMinutes());
    var s = addZero(d.getSeconds());
    var datetime = date+' '+h+':'+m+':'+s;
    $('#AddPlate_Time').val(datetime);
    $('#ANPR_AddPlate_Modal').modal('show');
    $('#ANPR_AddPlate_Modal').find('[autofocus]').focus();
    // Main
    $('#AddPlate_Save').on('click', function(e) {
      e.preventDefault();
      e.stopImmediatePropagation();
      var Data = $('#ANPR_AddPlate_Form').serialize();
      $.ajax({
        url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.ANPR_AddPlate",
        method: "POST",
        data: Data,
        dataType: "text",
        success:function() {
          ANPR_Feed_Refresh();
          $('#ANPR_AddPlate_Form')[0].reset();
          $('#ANPR_AddPlate_Modal').modal('hide');
        }
      });
      return false;
    });
  }
  // Add a vehicle into the anpr feed
  function ANPR_Update(Ref, Plate, Time, Trl) {
    $('input[name="Update_Ref"]').val(Ref);
    $('input[name="Update_Plate"]').val(Plate);
    $('input[name="Update_Trl"]').val(Trl);
    $('input[name="Update_Time"]').val(Time);
    $('#ANPR_Update_Modal').modal('show');
    $('#ANPR_Update_Modal').find('[autofocus]').focus();
    // Query
    $('#ANPR_Update_Save').on('click', function(e) {
      e.preventDefault();
      e.stopImmediatePropagation();
      if($('input[name="Update_Plate"]').val() == "") {
        $('input[name="Update_Plate"]').addClass("is-invalid");
      } else if($('input[name="Update_Time"]').val() == "") {
        $('input[name="Update_Time"]').addClass("is-invalid");
      } else {
        $('input[name="Update_Plate"]').removeClass("is-invalid");
        $('input[name="Update_Time"]').removeClass("is-invalid");
        var Data = $('#ANPR_Update_Form').serialize();
        $.ajax({
          url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.ANPR_Update",
          method: "POST",
          data: Data,
          dataType: "text",
          success:function() {
            ANPR_Feed_Refresh();
            $('#ANPR_Update_Form')[0].reset();
            $('#ANPR_Update_Modal').modal('hide');
          }
        });
        return false;
      }
    });
  }
  // ANPR Feed
  $(document).ready(function() {
    $('#ANPR_Feed').html('<img style="width: 90px;display: block;margin: 0 auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.ANPR_Feed",
      method: "POST",
      dataType: "json",
      success:function(Response) {
        $('#ANPR_Feed').html(Response.Feed);
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
  // All other vehicle feeds
  $(document).ready(function() {
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.CountVehicles",
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
