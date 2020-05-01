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
  // Mark a record as Duplicate
  function ANPR_Secondary_Duplicate(str) {
    event.preventDefault();
    $('#ANPR_Secondary_Feed_'+str).addClass('Hide');
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.ANPR_Secondary_Duplicate",
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
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.ANPR_GetImages",
      data: {Ref:Ref},
      method: "POST",
      dataType: "json",
      success:function(Response) {
        $('#ANPR_Update_Img').html(Response);
      }
    });
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
          dataType: "json",
          success:function(Response) {
            if(Response.Status > 0) {
              ANPR_Feed_Refresh();
              $('#ANPR_Update_Form')[0].reset();
              $('#ANPR_Update_Modal').modal('hide');
              $.notify(Response.Message, {className:'success',globalPosition: 'top left',});
            } else {
              $.notify(Response.Message, {className:'error',globalPosition: 'top left',});
            }
          }
        });
        return false;
      }
    });
  }
  function ANPR_Secondary_Update(Ref, Plate, Time, Trl) {
    $('input[name="Update_Secondary_Ref"]').val(Ref);
    $('input[name="Update_Secondary_Plate"]').val(Plate);
    $('input[name="Update_Secondary_Trl"]').val(Trl);
    $('input[name="Update_Secondary_Time"]').val(Time);
    $('#ANPR_Secondary_Update_Modal').modal('show');
    $('#ANPR_Secondary_Update_Modal').find('[autofocus]').focus();
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.ANPR_Secondary_GetImages",
      data: {Ref:Ref},
      method: "POST",
      dataType: "json",
      success:function(Response) {
        $('#ANPR_Secondary_Update_Img').html(Response);
      }
    });
    // Query
    $('#ANPR_Secondary_Update_Save').on('click', function(e) {
      e.preventDefault();
      e.stopImmediatePropagation();
      if($('input[name="Update_Secondary_Plate"]').val() == "") {
        $('input[name="Update_Secondary_Plate"]').addClass("is-invalid");
      } else if($('input[name="Update_Secondary_Time"]').val() == "") {
        $('input[name="Update_Secondary_Time"]').addClass("is-invalid");
      } else {
        $('input[name="Update_Secondary_Plate"]').removeClass("is-invalid");
        $('input[name="Update_Secondary_Time"]').removeClass("is-invalid");
        var Data = $('#ANPR_Secondary_Update_Form').serialize();
        $.ajax({
          url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.ANPR_Secondary_Update",
          method: "POST",
          data: Data,
          dataType: "text",
          success:function() {
            ANPR_Feed_Refresh();
            $('#ANPR_Secondary_Update_Form')[0].reset();
            $('#ANPR_Secondary_Update_Modal').modal('hide');
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
    $('#Director_Plate').val('');
    $('#Director_Results').html('');
    // Begin Pane
    $('#Update_Ref').val(Ref);
    $('#Update_Duration').html('<img style="width: 70px;display: block;margin: 20px auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
    $('#UD_Ref').html(Ref);
    // Get Veh Details
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.GetDetails",
      data: {Ref:Ref},
      method: "POST",
      dataType: "json",
      success:function(Response) {
        $('#Update_Plate').val(Response.Plate);
        $('#Update_Flag').val(Response.Flagged);
        $('#Update_Expiry').val(Response.Expiry);
        $('#Update_Trailer').val(Response.Trailer_No);
        $('#Update_Name').val(Response.Name);
        $('#Update_VehType').val(Response.Type);
        $('#Update_Arrival').val(Response.Arrival);
        $('#Update_Exit').val(Response.Departure);
        $('#Update_Column').val(Response.Parked_Column);
        $('#Update_Notes').val(Response.Notes);
        $('#UD_ExitKey').html(Response.ExitKey);
        // Time Prep
        $.ajax({
          url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.TimeCalc",
          data: {Time1:Response.Arrival, Time2:Response.Departure},
          method: "POST",
          dataType: "text",
          success:function(Response) {
            $('#Update_Duration').html(Response);
          }
        });
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
    if(Column != "unselected") {
      $.ajax({
        url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.UpdateRecord",
        data: {Ref:Ref, Plate:Plate, Name:Name, Trailer:Trailer, VehType:VehType, Column:Column, Arrival:Arrival, Exit:Exit, Notes:Notes},
        method: "POST",
        success:function() {
          UpdateVehPaneClose();
          $('#UpdateVehicle_Form')[0].reset();
        }
      });
    } else {
      alert("Please choose a valid Parking Column");
    }
  }
  // Quick Exit
  $(document).on('click', '#Update_ExitBtn', function(e) {
    e.preventDefault();
    var Ref = $('#Update_Ref').val();
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.QuickExit",
      data: {Ref:Ref},
      method: "POST",
      success:function() {
        UpdateVehPaneClose();
        $('#UpdateVehicle_Form')[0].reset();
      }
    })
  });
  function QuickExit(Ref) {
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.QuickExit",
      data: {Ref:Ref},
      method: "POST",
      success:function() {
        ALLVEH_Feed_Refresh();
      }
    });
  };
  // Flag
  $(document).on('click', '#Update_FlagBtn', function(e) {
    e.preventDefault();
    var Ref = $('#Update_Ref').val();
    var Flagged = $('#Update_Flag').val();
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.QuickFlag",
      data: {Ref:Ref, Flagged:Flagged},
      method: "POST",
      success:function() {
        UpdateVehPaneClose();
        $('#UpdateVehicle_Form')[0].reset();
      }
    })
  });
  function QuickFlag(Ref, Flagged) {
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.QuickFlag",
      data: {Ref:Ref, Flagged:Flagged},
      method: "POST",
      success:function() {
        ALLVEH_Feed_Refresh();
      }
    });
  };

  $(document).on('keyup', '#Search_PM_Str', function() {
    event.preventDefault();
    var Key = $(this).val();
    if(Key == '') {
      $('#Search_Results').html("No Data");
    } else {
      $.ajax({
        url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.Search_Parking",
        data: {Key:Key},
        method: "POST",
        dataType: "json",
        success:function(Data) {
          $('#Search_Results').html(Data);
        }
      });
    }
  });

  $(document).on('keyup', '#Search_ANPR_Str', function() {
    event.preventDefault();
    var Key = $(this).val();
    if(Key == '') {
      $('#Search_Results').html("No Data");
    } else {
      $.ajax({
        url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.Search_ANPR",
        data: {Key:Key},
        method: "POST",
        dataType: "json",
        success:function(Data) {
          $('#Search_Results').html(Data);
        }
      });
    }
  });
  $(document).on('keyup', '#Director_Plate', function() {
    event.preventDefault();
    var Plate = $(this).val();
    if(Plate == '') {
      // Do nothing
    } else {
      $.ajax({
        url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.Director",
        data: {Plate:Plate},
        method: "POST",
        dataType: "json",
        success:function(Data) {
          $('#Director_Results').html(Data);
        }
      });
    }
  });
  // Payment Refresh
  $(document).on('click', '#RefreshUpdatePayments', function() {
    var Ref = $('#Update_Ref').val();
    $('#Update_PaymentsTable').html('<img style="width: 70px;display: block;margin: 20px auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
    $.ajax({
      url: "{URL}/core/ajax/payment.handler.php?handler=Payment.GetVehPayments",
      data: {Ref:Ref},
      method: "POST",
      dataType: "text",
      success:function(Response) {
        $('#Update_PaymentsTable').html(Response);
      }
    });
  });
  // Add vehicle to blacklist
  $(document).on('click', '#Blacklist_Add', function() {
    event.preventDefault();
    var Plate = $('#Blacklist_AddPlate').val();
    var Type = $('#Blacklist_AddType').val();
    var Message = $('#Blacklist_AddMessage').val();
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.AddToBlacklist",
      data: {Plate:Plate, Type:Type, Message:Message},
      method: "POST",
      dataType: "json",
      success:function(Response) {
        alert(Response.Message);
      }
    });
  });

  function Update_PortalBooking(Ref, Eta_Date, Eta_Time, vehtype, telephone, company, note)
  {
    event.preventDefault();
    $('#ModifyBooking_Ref').val(Ref);
    $('#ModifyBooking_ETA').val(Eta_Time);
    $('#ModifyBooking_VehicleType').val(vehtype);
    $('#ModifyBooking_ETA_Prepend').html(Eta_Date);
    $('#ModifyBooking_Telephone').val(telephone);
    $('#ModifyBooking_Company').val(company);
    $('#ModifyBooking_Note').val(note);
    $('#Portal_ModifyBooking').modal('toggle');
  }
  // Save booking update
  $(document).on('click', '#ModifyBooking_Save', function() {
    event.preventDefault();
    var Data = $('#ModifyBooking_FORM').serialize();
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.ModifyPortalBooking",
      data: Data,
      method: "POST",
      dataType: "json",
      success:function(Response) {
        if(Response.Status == "1") {
          $.notify(Response.Message, {className:'success',globalPosition: 'top left',});
          $('#Portal_ModifyBooking').modal('toggle');
          DownloadActivePortalBookings();
        } else {
          $.notify(Response.Message, {className:'danger',globalPosition: 'top left',});
        }
      }
    })
    return false;
  });
  function Cancel_PortalBooking(Ref, Status)
  {
    event.preventDefault();
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.Cancel_PortalBooking",
      data: {Ref:Ref, Status:Status},
      method: "POST",
      dataType: "json",
      success:function(Response) {
        if(Response.Status == "1") {
          $.notify(Response.Message, {className:'success',globalPosition: 'top left',});
          DownloadActivePortalBookings()
        } else {
          $.notify(Response.Message, {className:'danger',globalPosition: 'top left',});
        }
      }
    })
    return false;
  }
  function DownloadActivePortalBookings() {
    event.preventDefault();
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.List_PortalBookings",
      method: "POST",
      dataType: "text",
      success:function(Response) {
        $('#Portal_BookingData').html(Response);
      }
    })
  }
</script>
