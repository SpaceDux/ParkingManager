<script type="text/javascript">
  // Ini Payment Portal
  function PaymentPaneToggle(Ref, Plate, Trl, Time, Type) {
    var Ref = Ref;
    var Plate = Plate;
    var Type = Type;
    $('#Payment_Type').val(Type);
    $('#Payment_Ref').val(Ref);
    $('#Payment_Plate').val(Plate);
    $('#Payment_Trl').val(Trl);
    $('#Payment_CaptureDate').val(Time);
    $('#Payment_Name').focus();
    // If vehicle isnt a duplicate
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
      PaymentPane();
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
      PaymentPane();
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
    //hide modals
    $('#Payment_ConfirmationCash_Modal').modal('hide');
    $('#Payment_ConfirmationCard_Modal').modal('hide');
    $('#Payment_ConfirmationAcc_Modal').modal('hide');
    $('#Payment_ConfirmationSNAP_Modal').modal('hide');
    $('#Payment_ConfirmationFuel_Modal').modal('hide');
  }
  // Close Payment Portal
  function PaymentPaneClose() {
    $('#PaymentPane_Form')[0].reset();
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
          data: {Method:5, Type:Type, Ref:Ref, Plate:Plate, Name:Name, Trl:Trl, Time:Time, VehType:VehType, Service:Service, CardNo:CardNo, CardExpiry:CardExpiry},
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
    UpdateVehPaneClose();
  });
  // Send print job to the ticket class.
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
  //
  // $(document).on('click', '#TL_ViewSales', function() {
  //   event.preventDefault();
  //   var DateStart = $('#TL_DateStart').val();
  //   var DateEnd = $('#TL_DateEnd').val();
  //   $('#PaymentsDataTable').DataTable({
  //     "serverSide": true,
  //     "processing": true,
  //     "order": [],
  //     "ajax": {
  //       url: '{URL}/core/ajax/payment.handler.php?handler=Payment.Transaction_List',
  //       type: 'POST',
  //       data:{
  //         DateStart:DateStart,
  //         DateEnd:DateEnd
  //       }
  //     }
  //   })
  // })
  $(document).ready(function() {

    fill_datatable();

    function fill_datatable(DateStart = '', DateEnd = '')
    {
     var dataTable = $('#PaymentsDataTable').DataTable({
      "processing" : true,
      "serverSide" : true,
      "search" : false,
      "ajax" : {
       url:"{URL}/core/ajax/payment.handler.php?handler=Payment.Transaction_List",
       type:"POST",
       data:{
        DateStart:DateStart, DateEnd:DateEnd
       }
      }
     });
    }
    $('#TL_ViewSales').click(function() {
      var DateStart = $('#TL_DateStart').val();
      var DateEnd = $('#TL_DateEnd').val();
        if(DateStart != '' && DateEnd != '')
        {
          $('#PaymentsDataTable').DataTable().destroy();
          fill_datatable(DateStart, DateEnd);
        }
        else
        {
          alert('Please choose a Start & End date');
          $('#PaymentsDataTable').DataTable().destroy();
          fill_datatable();
        }
    });


 });
</script>
