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
  function ALLVEH_Feed_Refresh() {
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
  }
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
  // Update
  function UpdateVehPaneToggle(Ref, Time) {
    $('#Update_Ref').val(Ref);
    $('#Update_Duration').html('<img style="width: 70px;display: block;margin: 20px auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
    // Time Prep
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.TimeCalc",
      data: {Time1:Time, Time2:""},
      method: "POST",
      dataType: "text",
      success:function(Response) {
        $('#Update_Duration').html(Response);
      }
    });
    // Get Veh Details
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.GetDetails",
      data: {Ref:Ref},
      method: "POST",
      dataType: "json",
      success:function(Response) {
        $('#Update_Plate').val(Response.Plate);
        $('#Update_Trailer').val(Response.Trailer_No);
        $('#Update_Name').val(Response.Name);
        $('#Update_VehType').val(Response.Type);
        $('#Update_Arrival').val(Response.Arrival);
        $('#Update_Exit').val(Response.Exit);
        $('#Update_Column').val(Response.Parked_Column);
        $('#Update_Notes').val(Response.Notes);
        // Payments
        $.ajax({
          url: "{URL}/core/ajax/payment.handler.php?handler=Payment.GetVehPayments",
          data: {Ref:Ref},
          method: "POST",
          dataType: "text",
          success:function(Response) {
            $('#Update_PaymentsTable').html(Response);
          }
        });
        // Images
        $.ajax({
          url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.Parking_GetImages",
          data: {Ref:Ref},
          method: "POST",
          dataType: "json",
          success:function(Response) {
            $('#Update_Images').html(Response);
          }
        });
        UpdateVehPane();
      }
    });
  };
  // Close Payment Portal
  function UpdateVehPaneClose() {
    $('#UpdateVehicle_Form')[0].reset();
    $('#UpdateVehicle_Form').load(' #UpdateVehicle_Form');

    ResetModals();
    ALLVEH_Feed_Refresh();

    UpdateVehPane();
  };
  // Update
  function UpdateVehicleRec() {
    var Ref = $('#Update_Ref').val();
    var Plate = $('#Update_Plate').val();
    var Name = $('#Update_Name').val();
    var Trailer = $('#Update_Trailer').val();
    var VehType = $('#Update_VehType').val();
    var Column = $('#Update_Column').val();
    var Arrival = $('#Update_Arrival').val();
    var Exit = $('#Update_Exit').val();
    var Notes = $('#Update_Notes').val();
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.UpdateRecord",
      data: {Ref:Ref, Plate:Plate, Name:Name, Trailer:Trailer, VehType:VehType, Column:Column, Arrival:Arrival, Exit:Exit, Notes:Notes},
      method: "POST",
      success:function() {
        UpdateVehPaneClose();
        $('#UpdateVehicle_Form')[0].reset();
      }
    });
  }

</script>
