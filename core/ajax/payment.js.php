<script type="text/javascript">
  // Ini Payment Portal
  function PaymentPaneToggle(Ref, Plate, Trl, Time, Type) {
    $('#Director_Plate').val('');
    $('#Director_Results').html('');
    // Firstly;
    // Check Blacklisted
    $.ajax({
      url: "{URL}/core/ajax/payment.handler.php?handler=Payment.CheckBlacklisted",
      data: {Plate:Plate},
      type: "POST",
      dataType: "json",
      success:function(Data) {
        if(Data.Status == 1) {
          $('#Blacklist_Ref').val(Data.Uniqueref);
          $('#Blacklist_ShowPlate').html(Data.Plate);
          $('#Blacklist_ShowMessage').html(Data.Message);
          $('#Blacklist_Show').modal('show');
        }
      }
    });
    // Begin Payment
    var Ref = Ref;
    var Plate = Plate;
    var Type = Type;
    $('#Payment_Type').val(Type);
    $('#Payment_Ref').val(Ref);
    $('#Payment_Plate').val(Plate);
    $('#Payment_Trl').val(Trl);
    $('#Payment_CaptureDate').val(Time);
    $('#Payment_CaptureDate_Bg').html(Time);
    $('#Payment_Name').focus();
    // If vehicle isnt a duplicate
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.CheckPortal",
      data: {Plate:Plate},
      method: "POST",
      dataType: "text",
      success:function(Response) {
        $('#PortalCheck').html(Response);
      }
    });
    if(Type == 1) {
      // Is Duplicate (Already has mysql rec)
      $.ajax({
        url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.CheckDuplicate",
        data: {Plate:Plate},
        method: "POST",
        dataType: "json",
        success:function(Response) {
          if(Response.Response == "TRUE") {
            $('#DuplicateVehicle').modal("toggle");
            $('#DuplicateVehicleBtn').attr('data-id', Response.Ref);
            $('#DuplicateVehicleBtn').attr('data-time', Response.Time);
          } else {

          }
        }
      });
      // Time Prep
      $.ajax({
        url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.TimeCalc",
        data: {Time1:Time, Time2:""},
        method: "POST",
        dataType: "text",
        success:function(Response) {
          $('#Payment_TimeCalculation').html(Response);
        }
      });
      $('#PaymentOptions').html('<img style="width: 70px;display: block;margin: 20px auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
      $('#ANPR_Images').html('<img style="width: 70px;display: block;margin: 20px auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
      $.ajax({
        url: "{URL}/core/ajax/payment.handler.php?handler=Payment.GET_PaymentOptions",
        data: {Plate:Plate},
        method: "POST",
        dataType: "text",
        success:function(Response) {
          $('#PaymentOptions').html(Response);
        }
      });
      $.ajax({
        url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.ANPR_GetImages",
        data: {Ref:Ref},
        method: "POST",
        dataType: "json",
        success:function(Response) {
          $('#ANPR_Images').html(Response);
        }
      });
      PaymentPane();
    } else {
      // Time Prep
      $.ajax({
        url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.TimeCalc",
        data: {Time1:Time, Time2:""},
        method: "POST",
        dataType: "text",
        success:function(Response) {
          $('#Payment_TimeCalculation').html(Response);
        }
      });
      $('#PaymentOptions').html('<img style="width: 70px;display: block;margin: 20px auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
      $('#ANPR_Images').html('<img style="width: 70px;display: block;margin: 20px auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
      $.ajax({
        url: "{URL}/core/ajax/payment.handler.php?handler=Payment.GET_PaymentOptions",
        data: {Plate:Plate},
        method: "POST",
        dataType: "text",
        success:function(Response) {
          $('#PaymentOptions').html(Response);
        }
      });
      $.ajax({
        url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.Parking_GetImages",
        data: {Ref:Ref},
        method: "POST",
        dataType: "json",
        success:function(Response) {
          $('#ANPR_Images').html(Response);
        }
      });
      PaymentPane();
    }
  }
  // Reset confirmation modals
  function ResetModals() {
    $('#Modal_BodyCash').load(' #Modal_BodyCash');
    $('#Modal_BodyCard').load(' #Modal_BodyCard');
    $('#Modal_BodyAcc').load(' #Modal_BodyAcc');
    $('#Modal_BodySNAP').load(' #Modal_BodySNAP');
    $('#Modal_BodyFuel').load(' #Modal_BodyFuel');
    $('#DuplicateVehicleBody').load(' #DuplicateVehicleBody');
    $('#Blacklist_Show').load(' #Blacklist_Show');
    //hide modals
    $('#Payment_ConfirmationCash_Modal').modal('hide');
    $('#Payment_ConfirmationCard_Modal').modal('hide');
    $('#Payment_ConfirmationAcc_Modal').modal('hide');
    $('#Payment_ConfirmationSNAP_Modal').modal('hide');
    $('#Payment_ConfirmationFuel_Modal').modal('hide');
    $('#Blacklist_Show').modal('hide');
  }
  // Close Payment Portal
  function PaymentPaneClose() {
    // $('#PaymentPane_Form')[0].reset();
    $('#PaymentPane_Form').load(' #PaymentPane_Form');

    ResetModals();
    ALLVEH_Feed_Refresh();
    ANPR_Feed_Refresh();

    PaymentPane();
  };
  // Close Payment Portal
  function ListTransactionsPaneClose() {
    ListTransactionsPane();
  };
  // Authorise Payment via TYPE
  function AuthorisePayment(Method) {
    //GET DATA
    var Type = $('#Payment_Type').val();
    var Ref = $('#Payment_Ref').val();
    var Plate = $('#Payment_Plate').val();
    var Name = $('#Payment_Name').val();
    var Trl = $('#Payment_Trl').val();
    var Time = $('#Payment_CaptureDate').val();
    var VehType = $("#Payment_VehType option:selected").val();
    // Sending data
    if(Method == "1") {
      // Cash Payment
      var Service = $("#Payment_Service_Cash option:selected").val();
      if(Plate == "") {
        alert("Please enter a valid Plate");
      } else if(VehType == "unselected") {
        alert("Please choose a valid vehicle type");
      } else if(Service == "unchecked") {
        alert("Please choose a service");
      } else {
        // After clicking authorise
        $('.ConfirmModalBody').html('<img style="width: 90px;display: block;margin: 0 auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
        $('.Modal_AuthBtn_true').addClass('Hide');
        $('.Modal_AuthBtn_false').addClass('Hide');
        $.ajax({
          url: "{URL}/core/ajax/payment.handler.php?handler=Payment.Proccess_Transaction",
          data: {Method:1, Type:Type, Ref:Ref, Plate:Plate, Name:Name, Trl:Trl, Time:Time, VehType:VehType, Service:Service},
          method: "POST",
          dataType: "json",
          success:function(Response) {
            if(Response.Result == 1) {
              $('.ConfirmModalBody').html('Transaction has successfully been added, would you like to print the ticket now?');
              $('.Modal_PrintBtn_true').removeClass('Hide');
              $('.Modal_PrintBtn_true').attr('data-id', Response.Ref);
              $('.Modal_PrintBtn_false').removeClass('Hide');
            } else {
              $('.ConfirmModalBody').html('Transaction has not been added, please check the details and try again<br></br><div id="ReasonFail"></div>');
              $('.Modal_AuthBtn_false').removeClass('Hide');
            }
          }
        });
      }
    }
    if(Method == "2") {
      // Card Payment
      var Service = $("#Payment_Service_Card option:selected").val();
      if(Plate == "") {
        alert("Please enter a valid Plate");
      } else if(VehType == "unselected") {
        alert("Please choose a valid vehicle type");
      } else if(Service == "unchecked") {
        alert("Please choose a service");
      } else {
        // After clicking authorise
        $('.ConfirmModalBody').html('<img style="width: 90px;display: block;margin: 0 auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
        $('.Modal_AuthBtn_true').addClass('Hide');
        $('.Modal_AuthBtn_false').addClass('Hide');
        $.ajax({
          url: "{URL}/core/ajax/payment.handler.php?handler=Payment.Proccess_Transaction",
          data: {Method:2, Type:Type, Ref:Ref, Plate:Plate, Name:Name, Trl:Trl, Time:Time, VehType:VehType, Service:Service},
          method: "POST",
          dataType: "json",
          success:function(Response) {
            if(Response.Result == 1) {
              $('.ConfirmModalBody').html('Transaction has successfully been added, would you like to print the ticket now?');
              $('.Modal_PrintBtn_true').removeClass('Hide');
              $('.Modal_PrintBtn_true').attr('data-id', Response.Ref);
              $('.Modal_PrintBtn_false').removeClass('Hide');
            } else {
              $('.ConfirmModalBody').html('Transaction has not been added, please check the details and try again<br></br><div id="ReasonFail"></div>');
              $('.Modal_AuthBtn_false').removeClass('Hide');
            }
          }
        });
      }
    }
    if(Method == "3") {
      // Account Payment
      var Service = $("#Payment_Service_Account option:selected").val();
      var Account_ID = $("#Payment_Account_ID option:selected").val();
      if(Plate == "") {
        alert("Please enter a valid Plate");
      } else if(VehType == "unselected") {
        alert("Please choose a valid vehicle type");
      } else if(Service == "unchecked") {
        alert("Please choose a service");
      } else if(Account_ID == "unchecked") {
        alert("Please choose a valid account");
      } else {
        // After clicking authorise
        $('.ConfirmModalBody').html('<img style="width: 90px;display: block;margin: 0 auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
        $('.Modal_AuthBtn_true').addClass('Hide');
        $('.Modal_AuthBtn_false').addClass('Hide');
        $.ajax({
          url: "{URL}/core/ajax/payment.handler.php?handler=Payment.Proccess_Transaction",
          data: {Method:3, Type:Type, Ref:Ref, Plate:Plate, Name:Name, Trl:Trl, Time:Time, VehType:VehType, Service:Service, Account_ID:Account_ID},
          method: "POST",
          dataType: "json",
          success:function(Response) {
            if(Response.Result == 1) {
              $('.ConfirmModalBody').html('Transaction has successfully been added, would you like to print the ticket now?');
              $('.Modal_PrintBtn_true').removeClass('Hide');
              $('.Modal_PrintBtn_true').attr('data-id', Response.Ref);
              $('.Modal_PrintBtn_false').removeClass('Hide');
            } else {
              $('.ConfirmModalBody').html('Transaction has not been added, please check the details and try again<br></br><div id="ReasonFail"></div>');
              $('.Modal_AuthBtn_false').removeClass('Hide');
            }
          }
        });
      }
    }
    if(Method == "4") {
      // SNAP Payment
      var Service = $("#Payment_Service_SNAP option:selected").val();
      if(Plate == "") {
        alert("Please enter a valid Plate");
      } else if(VehType == "unselected") {
        alert("Please choose a valid vehicle type");
      } else if(Service == "unchecked") {
        alert("Please choose a service");
      } else if(Name == "") {
        alert("Please enter a valid Company/Name");
      } else {
        // After clicking authorise
        $('.ConfirmModalBody').html('<img style="width: 90px;display: block;margin: 0 auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
        $('.Modal_AuthBtn_true').addClass('Hide');
        $('.Modal_AuthBtn_false').addClass('Hide');
        $.ajax({
          url: "{URL}/core/ajax/payment.handler.php?handler=Payment.Proccess_Transaction",
          data: {Method:4, Type:Type, Ref:Ref, Plate:Plate, Name:Name, Trl:Trl, Time:Time, VehType:VehType, Service:Service},
          method: "POST",
          dataType: "json",
          success:function(Response) {
            if(Response.Result == 1) {
              $('.ConfirmModalBody').html('Transaction has successfully been added, would you like to print the ticket now?');
              $('.Modal_PrintBtn_true').removeClass('Hide');
              $('.Modal_PrintBtn_true').attr('data-id', Response.Ref);
              $('.Modal_PrintBtn_false').removeClass('Hide');
            } else {
              $('.ConfirmModalBody').html('Transaction has not been added, please check the details and try again<br><br>'+Response.Msg);
              $('.Modal_AuthBtn_false').removeClass('Hide');
            }
          }
        });
      }
    }
    if(Method == "5") {
      // Fuel Payment
      var Service = $("#Payment_Service_Fuel option:selected").val();
      var CardNo = $('#Payment_FuelCard_Number').val();
      var CardExpiry = $('#Payment_FuelCard_Expiry').val();
      var CardRC = $('#Payment_FuelCard_RC').val();
      if(Plate == "") {
        alert("Please enter a valid Plate");
      } else if(VehType == "unselected") {
        alert("Please choose a valid vehicle type");
      } else if(Service == "unchecked") {
        alert("Please choose a service");
      } else if(CardNo.length < 7) {
        alert("Please enter a valid card number");
      } else if(CardExpiry.length < 3) {
        alert("Please enter a valid card expiry date (MM/YYYY)");
      } else if(Name == "") {
        alert("Please enter Company/Name");
      } else {
        // After clicking authorise
        $('.ConfirmModalBody').html('<img style="width: 90px;display: block;margin: 0 auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
        $('.Modal_AuthBtn_true').addClass('Hide');
        $('.Modal_AuthBtn_false').addClass('Hide');
        $.ajax({
          url: "{URL}/core/ajax/payment.handler.php?handler=Payment.Proccess_Transaction",
          data: {Method:5, Type:Type, Ref:Ref, Plate:Plate, Name:Name, Trl:Trl, Time:Time, VehType:VehType, Service:Service, CardNo:CardNo, CardExpiry:CardExpiry, CardRC:CardRC},
          method: "POST",
          dataType: "json",
          success:function(Response) {
            if(Response.Result == 1) {
              $('.ConfirmModalBody').html('Transaction has successfully been added, would you like to print the ticket now?');
              $('.Modal_PrintBtn_true').removeClass('Hide');
              $('.Modal_PrintBtn_true').attr('data-id', Response.Ref);
              $('.Modal_PrintBtn_false').removeClass('Hide');
            } else {
              $('.ConfirmModalBody').html('Transaction has not been added, please check the details and try again<br><br>'+Response.Msg);
              $('.Modal_AuthBtn_false').removeClass('Hide');
            }
          }
        });
      }
    }
  }
  // Authorise Payment via TYPE
  function DeleteTransaction(Ref) {
    $.ajax({
      url: "{URL}/core/ajax/payment.handler.php?handler=Payment.DeleteTransaction",
      type: "POST",
      data: {Ref:Ref},
      success:function(Data) {
        if(Data > 0) {
          $.notify("Transaction has successfully been deleted.", {className:'success',globalPosition: 'top left',});
          $('#Payment_Delete_'+Ref).addClass('Hide');
        } else {
          $.notify("Transaction has not been deleted.", {className:'error',globalPosition: 'top left',});
        }
      }
    })
  }
  // Print parking tickets
  function Print_Ticket(Ref) {
    $.ajax({
      url: "{URL}/core/ajax/payment.handler.php?handler=Payment.Print_Ticket",
      type: "POST",
      data: {Ref:Ref},
      success:function() {
        console.log("Successfully printed Ticket. Ref: "+Ref);
      }
    });
  }
  // Get tariff details ready for update
  function Update_Tariff_Tgl(Ref) {
    event.preventDefault();
    $.ajax({
      url: "{URL}/core/ajax/payment.handler.php?handler=Payment.Update_Tariff_GET",
      type: "POST",
      data: {Ref:Ref},
      dataType: 'json',
      success:function(Data) {
        var Site = Data.Site;
        var Type = Data.Settlement_Type;
        $.ajax({
          url: "{URL}/core/ajax/payment.handler.php?handler=Payment.Settlement_DropdownOpt",
          type: "POST",
          data: {Site:Site, Type:Type},
          dataType: "text",
          success:function(Res) {
            $('#Update_Tariff_Modal').modal('toggle');
            $('#Tariff_SettlementGroup_Update').html(Res);
            $('#Tariff_Ref_Update').val(Data.Uniqueref);
            $('#Tariff_Name_Update').val(Data.Name);
            $('#Tariff_TicketName_Update').val(Data.TicketName);
            $('#Tariff_Gross_Update').val(Data.Gross);
            $('#Tariff_Nett_Update').val(Data.Nett);
            $('#Tariff_Expiry_Update').val(Data.Expiry);
            $('#Tariff_Group_Update').val(Data.Tariff_Group);
            $('#Tariff_Cash_Update').val(Data.Cash);
            $('#Tariff_Card_Update').val(Data.Card);
            $('#Tariff_Account_Update').val(Data.Account);
            $('#Tariff_SNAP_Update').val(Data.Snap);
            $('#Tariff_Fuel_Update').val(Data.Fuel);
            $('#Tariff_ETPID_Update').val(Data.ETPID);
            $('#Tariff_Meal_Update').val(Data.Meal_Vouchers);
            $('#Tariff_Shower_Update').val(Data.Shower_Vouchers);
            $('#Tariff_Discount_Update').val(Data.Discount_Vouchers);
            $('#Tariff_WiFi_Update').val(Data.Wifi_Vouchers);
            $('#Tariff_VehType_Update').val(Data.VehicleType);
            $('#Tariff_Site_Update').val(Data.Site);
            $('#Tariff_Status_Update').val(Data.Status);
            $('#Tariff_SettlementType_Update').val(Data.Settlement_Type);
            $('#Tariff_SettlementGroup_Update').val(Data.Settlement_Group);
            $('#Tariff_SettlementMulti_Update').val(Data.Settlement_Multi);
            $('#Tariff_AllowKiosk_Update').val(Data.Kiosk);
          }
        });
      }
    });
  }
  //
  function Payment_Update(Ref) {
    $.ajax({
      url: "{URL}/core/ajax/payment.handler.php?handler=Payment.UpdatePayment_GET",
      data: {Ref:Ref},
      method: "POST",
      dataType: "json",
      success:function(Response) {
        $('#Payment_Uniqueref_Update').val(Response.Uniqueref);
        $('#Payment_Processed_Time_Update').val(Response.Processed_Time);
        $('#Payment_UpdateModal').modal('toggle');
      }
    });
  }
  function Delete_Settlement_Group(Ref) {
    $.ajax({
      url: "{URL}/core/ajax/payment.handler.php?handler=Payment.Delete_Settlement_Group",
      data: {Ref:Ref},
      method: "POST",
      dataType: "text",
      success:function(Data) {
        if(Data == 1) {
          $.notify("Settlement Group has successfully been added.", {className:'success',globalPosition: 'top left',});
          var Type = $('#Settlement_Type').val();
          var Site = $('#Settlement_Site').val();
          if(Site != 'unselected') {
            $('#Settlement_Tbl').html('<img style="width: 90px;display: block;margin: 0 auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
            $.ajax({
              url: "{URL}/core/ajax/payment.handler.php?handler=Payment.GetSettlementGroup",
              type: "POST",
              data: {Site:Site, Type:Type},
              dataType: "text",
              success:function(Data) {
                $('#Settlement_Tbl').html(Data);
              }
            })
          }
        } else {
          $.notify("Settlement Group has not been added.", {className:'danger',globalPosition: 'top left',});
        }
      }
    });
  }
  // Update Settlement Group
  function Update_Settlement_Group(Ref) {
    $.ajax({
      url: "{URL}/core/ajax/payment.handler.php?handler=Payment.Update_SettlementGroup_Get",
      data: {Ref:Ref},
      method: "POST",
      dataType: "json",
      success:function(Response) {
        $('#SettlementGroup_Ref_Update').val(Response.Uniqueref);
        $('#SettlementGroup_Name_Update').val(Response.Name);
        $('#SettlementGroup_Order_Update').val(Response.Set_Order);
        $('#SettlementGroup_Type_Update').val(Response.Type);
        $('#SettlementGroup_Site_Update').val(Response.Site);
        $('#SettlementGroup_UpdateModal').modal('toggle');
      }
    });
  }

  // Repeat tariff add
  $(document).on('click', '#Tariff_Repeat', function() {
    event.preventDefault();
    var Data = $('#New_Tariff_Form').serialize();
    $.ajax({
      url: "{URL}/core/ajax/payment.handler.php?handler=Payment.New_Tariff",
      type: "POST",
      data: Data,
      dataType: "json",
      success:function(Data) {
        if(Data.Result == 1) {
          $.notify(Data.Message, {className:'success',globalPosition: 'top left',});
        } else {
          $.notify(Data.Message, {className:'error',globalPosition: 'top left',});
        }
      }
    })
  });
  // Payment Service Dropdown
  $(document).on('change', '#Payment_VehType', function() {
    var Type = $(this).val();
    var Expiry = $('input[name="Payment_Services_Expiry"]:checked').val();
    var Plate = $('#Payment_Plate').val();

    if(Type == 'unselected') {
      $('#Cash_Service').empty();
      $('#Card_Service').empty();
      $('#Account_Service').empty();
      $('#SNAP_Service').empty();
      $('#Fuel_Service').empty();
    } else {
      $('#Cash_Service').html();
      $('#Card_Service').html();
      $('#Account_Service').html();
      $('#SNAP_Service').html();
      $('#Fuel_Service').html();
      $.ajax({
        url: "{URL}/core/ajax/payment.handler.php?handler=Payment.GET_PaymentServices",
        type: "POST",
        data: {Type:Type, Expiry:Expiry, Plate:Plate},
        dataType: "json",
        success:function(Data) {
          $('#Cash_Service').html(Data.Cash);
          $('#Card_Service').html(Data.Card);
          $('#Account_Service').html(Data.Account);
          $('#SNAP_Service').html(Data.Snap);
          $('#Fuel_Service').html(Data.Fuel);
        }
      })
    }
  });
  //Payment Service Dropdown (EXPIRY)
  $(document).on('change', 'input[name="Payment_Services_Expiry"]:checked', function() {
    var Expiry = $(this).val();
    var Type = $('#Payment_VehType').val();
    var Plate = $('#Payment_Plate').val();

    if(Type == 'unselected') {
      $('#Cash_Service').empty();
      $('#Card_Service').empty();
      $('#Account_Service').empty();
      $('#SNAP_Service').empty();
      $('#Fuel_Service').empty();
    } else {
      $('#Cash_Service').html();
      $('#Card_Service').html();
      $('#Account_Service').html();
      $('#SNAP_Service').html();
      $('#Fuel_Service').html();
      $.ajax({
        url: "{URL}/core/ajax/payment.handler.php?handler=Payment.GET_PaymentServices",
        type: "POST",
        data: {Type:Type, Expiry:Expiry, Plate:Plate},
        dataType: "json",
        success:function(Data) {
          $('#Cash_Service').html(Data.Cash);
          $('#Card_Service').html(Data.Card);
          $('#Account_Service').html(Data.Account);
          $('#SNAP_Service').html(Data.Snap);
          $('#Fuel_Service').html(Data.Fuel);
        }
      })
    }
  });
  // Fuel card mag breaker
  $(document).on('keyup', '#FuelCard_Swipe', function(e) {
    e.preventDefault();
    var Str = $(this).val();
    $.ajax({
      url: "{URL}/core/ajax/payment.handler.php?handler=Payment.FuelCard_Break",
      type: "POST",
      data: {CardStr:Str},
      dataType: "json",
      success:function(Data) {
        $('#Payment_FuelCard_Number').val(Data.cardno);
        $('#Payment_FuelCard_Expiry').val(Data.expiry);
        $('#Payment_FuelCard_RC').val(Data.rc);
      }
    })
  });
  // Directs user to active record
  $(document).on('click', '#DuplicateVehicleBtn', function(e) {
    e.preventDefault();
    var Ref = $(this).data('id');
    var Time = $(this).data('time');
    PaymentPaneClose();
    ResetModals();
    $('#DuplicateVehicle').modal('toggle');
    UpdateVehPaneToggle(Ref, Time);
  });
  // Click new payment via update
  $(document).on('click', '#PaymentOnUpdate', function() {
    var Ref = $('#Update_Ref').val();
    var Plate = $('#Update_Plate').val();
    var Trl = $('#Update_Trailer').val();
    var Time = $('#Update_Expiry').val();
    var Type = $('#Update_VehType').val();
    PaymentPaneToggle(Ref, Plate, Trl, Time, "2");
    // UpdateVehPaneClose();
  });
  // Send print job to the ticket class.
  $(document).on('click', '.Modal_PrintBtn_true', function() {
    var Ref = $(this).data("id");
    Print_Ticket(Ref);
    PaymentPaneClose();
    $('#Payment_ConfirmationCash_Modal').modal('hide');
    $('#Payment_ConfirmationCard_Modal').modal('hide');
    $('#Payment_ConfirmationAcc_Modal').modal('hide');
    $('#Payment_ConfirmationSNAP_Modal').modal('hide');
    $('#Payment_ConfirmationFuel_Modal').modal('hide');
  });
  // List Transactions via Datatables
  $(document).ready(function() {
    fill_datatable();
    function fill_datatable(DateStart = '', DateEnd = '', Cash = '', Card = '', Account = '', Snap = '', Fuel = '', Group = '', Settlement_Group = '', Deleted = '')
    {
     var dataTable = $('#PaymentsDataTable').DataTable({
       "createdRow" : function(row, data, index) {
         if(data[10] == "Deleted") {
           $(row).addClass("table-danger");
         }
       },
      "processing" : true,
      "serverSide" : true,
      "search" : false,
      "order" : [[6, 'desc']],
      "ajax" : {
       url:"{URL}/core/ajax/payment.handler.php?handler=Payment.Transaction_List",
       type:"POST",
       data:{
        DateStart:DateStart, DateEnd:DateEnd, Cash:Cash, Card:Card, Account:Account, Snap:Snap, Fuel:Fuel, Group:Group, Settlement_Group:Settlement_Group, Deleted:Deleted
       }
      }
     });
    }
    $('#TL_ViewSales').click(function()
    {
      var DateStart = $('#TL_DateStart').val();
      var DateEnd = $('#TL_DateEnd').val();
      var Cash = $('#TL_Cash:checked').val();
      var Card = $('#TL_Card:checked').val();
      var Account = $('#TL_Account:checked').val();
      var Snap = $('#TL_SNAP:checked').val();
      var Fuel = $('#TL_Fuel:checked').val();
      var Group = $('#TL_Group').val();
      var Settlement_Group = $('#TL_Settlement_Group').val();
      var Deleted = $('#TL_Deleted:checked').val();
      if(DateStart != '' && DateEnd != '')
      {
        $('#PaymentsDataTable').DataTable().destroy();
        fill_datatable(DateStart, DateEnd, Cash, Card, Account, Snap, Fuel, Group, Settlement_Group, Deleted);
      }
      else
      {
        alert('Please choose a Start & End date');
        $('#PaymentsDataTable').DataTable().destroy();
        fill_datatable();
      }
    });
  });
  // Choose site
  $(document).on('change', '#Tariff_SitePick', function(e) {
    e.preventDefault();
    var Site = $(this).val();
    if(Site != 'unselected') {
      $('#Tariff_Tbl').html('<img style="width: 90px;display: block;margin: 0 auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
      $.ajax({
        url: "{URL}/core/ajax/payment.handler.php?handler=Payment.GetTariffs",
        type: "POST",
        data: {Site:Site},
        dataType: "text",
        success:function(Data) {
          $('#Tariff_Tbl').html(Data);
        }
      })
    }
  })
  // Choose site & fill settlement dropdown
  $(document).on('change', '#Tariff_Site', function(e) {
    e.preventDefault();
    var Site = $(this).val();
    var Type = $('#Tariff_SettlementType').val();
    if(Site != 'unselected') {
      $('#Tariff_SettlementGroup').html('<img style="width: 90px;display: block;margin: 0 auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
      $.ajax({
        url: "{URL}/core/ajax/payment.handler.php?handler=Payment.Settlement_DropdownOpt",
        type: "POST",
        data: {Site:Site, Type:Type},
        dataType: "text",
        success:function(Data) {
          $('#Tariff_SettlementGroup').html(Data);
        }
      })
    }
  })
  $(document).on('change', '#Tariff_SettlementType', function(e) {
    e.preventDefault();
    var Type = $(this).val();
    var Site = $('#Tariff_Site').val();
    if(Site != 'unselected') {
      $('#Tariff_SettlementGroup').html('<img style="width: 90px;display: block;margin: 0 auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
      $.ajax({
        url: "{URL}/core/ajax/payment.handler.php?handler=Payment.Settlement_DropdownOpt",
        type: "POST",
        data: {Site:Site, Type:Type},
        dataType: "text",
        success:function(Data) {
          $('#Tariff_SettlementGroup').html(Data);
        }
      })
    }
  })
  // Choose site & fill settlement dropdown
  $(document).on('change', '#Tariff_Site_Update', function(e) {
    e.preventDefault();
    var Site = $(this).val();
    var Type = $('#Tariff_SettlementType_Update').val();
    if(Site != 'unselected') {
      $('#Tariff_SettlementGroup_Update').html('<img style="width: 90px;display: block;margin: 0 auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
      $.ajax({
        url: "{URL}/core/ajax/payment.handler.php?handler=Payment.Settlement_DropdownOpt",
        type: "POST",
        data: {Site:Site, Type:Type},
        dataType: "text",
        success:function(Data) {
          $('#Tariff_SettlementGroup_Update').html(Data);
        }
      })
    }
  })
  $(document).on('change', '#Tariff_SettlementType_Update', function(e) {
    e.preventDefault();
    var Site = $('#Tariff_Site_Update').val();
    var Type = $(this).val();
    if(Site != 'unselected') {
      $('#Tariff_SettlementGroup_Update').html('<img style="width: 90px;display: block;margin: 0 auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
      $.ajax({
        url: "{URL}/core/ajax/payment.handler.php?handler=Payment.Settlement_DropdownOpt",
        type: "POST",
        data: {Site:Site, Type:Type},
        dataType: "text",
        success:function(Data) {
          $('#Tariff_SettlementGroup_Update').html(Data);
        }
      })
    }
  })
  //Work VAT @ 1.2
  $(document).on('keyup', '#Tariff_Gross', function() {
    var Gross = $(this).val();
    var value = Gross / 1.2;
    var result = parseInt(value*100)/100;
    $('#Tariff_Nett').val(result);
  });
  $(document).on('keyup', '#Tariff_Gross_Update', function() {
    var Gross = $(this).val();
    var value = Gross / 1.2;
    var result = parseInt(value*100)/100;
    $('#Tariff_Nett_Update').val(result);
  });
  // Add a new tariff to pm
  $(document).on('submit', '#New_Tariff_Form', function(e) {
    e.preventDefault();
    var Data = $('#New_Tariff_Form').serialize();
    $.ajax({
      url: "{URL}/core/ajax/payment.handler.php?handler=Payment.New_Tariff",
      type: "POST",
      data: Data,
      dataType: "json",
      success:function(Data) {
        if(Data.Result == 1) {
          $.notify(Data.Message, {className:'success',globalPosition: 'top left',});
          $('#New_Tariff_Modal').modal('toggle');
          $('#New_Tariff_Form')[0].reset();
        } else {
          $.notify(Data.Message, {className:'error',globalPosition: 'top left',});
        }
      }
    })
  });
  // Add a new tariff to pm
  $(document).on('submit', '#Update_Tariff_Form', function(e) {
    e.preventDefault();
    var Data = $('#Update_Tariff_Form').serialize();
    $.ajax({
      url: "{URL}/core/ajax/payment.handler.php?handler=Payment.Update_Tariff",
      type: "POST",
      data: Data,
      dataType: "json",
      success:function(Data) {
        if(Data.Result == 1) {
          $.notify(Data.Message, {className:'success',globalPosition: 'top left',});
          $('#Update_Tariff_Modal').modal('toggle');
          $('#Update_Tariff_Form')[0].reset();
        } else {
          $.notify(Data.Message, {className:'error',globalPosition: 'top left',});
        }
      }
    })
  });
  // Search Payments via Modal
  $(document).on('keyup', '#Search_Payment_Str', function() {
    event.preventDefault();
    var Key = $(this).val();
    if(Key == '') {
      $('#Search_Results').html("No Data");
    } else {
      $.ajax({
        url: "{URL}/core/ajax/payment.handler.php?handler=Payment.Search_Payments",
        data: {Key:Key},
        method: "POST",
        dataType: "json",
        success:function(Data) {
          $('#Search_Results').html(Data);
        }
      });
    }
  });
  // Update Payment modal save
  $(document).on('click', '#Payment_Update', function() {
    event.preventDefault();
    var Ref = $('#Payment_Uniqueref_Update').val();
    var Time = $('#Payment_Processed_Time_Update').val();
    $.ajax({
      url: "{URL}/core/ajax/payment.handler.php?handler=Payment.UpdatePayment",
      data: {Ref:Ref, Time:Time},
      method: "POST",
      dataType: "json",
      success:function(Data) {
        if(Data == 1) {
          $('#Payment_UpdateModal').modal('toggle');
        } else {

        }
      }
    });
  });
// Settlement Designer
  // Choose site
  $(document).on('change', '#Settlement_Site', function(e) {
    e.preventDefault();
    var Site = $(this).val();
    var Type = $('#Settlement_Type').val();
    if(Site != 'unselected') {
      $('#Settlement_Tbl').html('<img style="width: 90px;display: block;margin: 0 auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
      $.ajax({
        url: "{URL}/core/ajax/payment.handler.php?handler=Payment.GetSettlementGroup",
        type: "POST",
        data: {Site:Site, Type:Type},
        dataType: "text",
        success:function(Data) {
          $('#Settlement_Tbl').html(Data);
        }
      })
    }
  })
  // Choose Type
  $(document).on('change', '#Settlement_Type', function(e) {
    e.preventDefault();
    var Type = $(this).val();
    var Site = $('#Settlement_Site').val();
    if(Site != 'unselected') {
      $('#Settlement_Tbl').html('<img style="width: 90px;display: block;margin: 0 auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
      $.ajax({
        url: "{URL}/core/ajax/payment.handler.php?handler=Payment.GetSettlementGroup",
        type: "POST",
        data: {Site:Site, Type:Type},
        dataType: "text",
        success:function(Data) {
          $('#Settlement_Tbl').html(Data);
        }
      })
    }
  })
  $(document).on('click', '#SettlementGroup_Update', function() {
    event.preventDefault();
    var Ref = $('#SettlementGroup_Ref_Update').val();
    var Name = $('#SettlementGroup_Name_Update').val();
    var Order = $('#SettlementGroup_Order_Update').val();
    var Type = $('#SettlementGroup_Type_Update').val();
    var Site = $('#SettlementGroup_Site_Update').val();
    $.ajax({
      url: "{URL}/core/ajax/payment.handler.php?handler=Payment.SettlementGroup_Update",
      data: {Ref:Ref, Name:Name, Order:Order, Type:Type, Site:Site},
      method: "POST",
      dataType: "json",
      success:function(Data) {
        if(Data == 1) {
          $.notify("Settlement Group has successfully been updated.", {className:'success',globalPosition: 'top left',});
          $('#SettlementGroup_UpdateModal').modal('toggle');
          var Type = $('#Settlement_Type').val();
          var Site = $('#Settlement_Site').val();
          if(Site != 'unselected') {
            $('#Settlement_Tbl').html('<img style="width: 90px;display: block;margin: 0 auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
            $.ajax({
              url: "{URL}/core/ajax/payment.handler.php?handler=Payment.GetSettlementGroup",
              type: "POST",
              data: {Site:Site, Type:Type},
              dataType: "text",
              success:function(Data) {
                $('#Settlement_Tbl').html(Data);
              }
            })
          }
        } else {
          $.notify("Settlement Group has not been updated.", {className:'danger',globalPosition: 'top left',});
        }
      }
    });
  });
  $(document).on('click', '#SettlementGroup_Add', function() {
    event.preventDefault();
    var Name = $('#SettlementGroup_Name').val();
    var Order = $('#SettlementGroup_Order').val();
    var Type = $('#SettlementGroup_Type').val();
    var Site = $('#SettlementGroup_Site').val();
    $.ajax({
      url: "{URL}/core/ajax/payment.handler.php?handler=Payment.SettlementGroup_Add",
      data: {Name:Name, Order:Order, Type:Type, Site:Site},
      method: "POST",
      dataType: "json",
      success:function(Data) {
        if(Data == 1) {
          $.notify("Settlement Group has successfully been added.", {className:'success',globalPosition: 'top left',});
          $('#SettlementGroup_AddModal').modal('toggle');
          var Type = $('#Settlement_Type').val();
          var Site = $('#Settlement_Site').val();
          if(Site != 'unselected') {
            $('#Settlement_Tbl').html('<img style="width: 90px;display: block;margin: 0 auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
            $.ajax({
              url: "{URL}/core/ajax/payment.handler.php?handler=Payment.GetSettlementGroup",
              type: "POST",
              data: {Site:Site, Type:Type},
              dataType: "text",
              success:function(Data) {
                $('#Settlement_Tbl').html(Data);
              }
            })
          }
        } else {
          $.notify("Settlement Group has not been added.", {className:'danger',globalPosition: 'top left',});
        }
      }
    });
  });
</script>
