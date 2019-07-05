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
  };
  // Close Payment Portal
  function PaymentPaneClose() {
    $('#PaymentPane_Form')[0].reset();
    $('#PaymentPane_Form').load(' #PaymentPane_Form');

    PaymentPane();
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
    if(Method == "1") {
      // Cash Payment
      var Service = $("#Payment_Service_Cash option:selected").val();
      if(Plate == "") {
        alert("Please enter a valid Plate");
      } else if(VehType == "unselected") {
        alert("Please choose a valid vehicle type");
      } else {
        $.ajax({
          url: "{URL}/core/ajax/payment.handler.php?handler=Payment.Proccess_Transaction",
          data: {Method:Method, Type:Type, Ref:Ref, Plate:Plate, Name:Name, Trl:Trl, Time:Time, VehType:VehType, Service:Service},
          method: "POST",
          dataType: "json",
          success:function(Response) {

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
      } else {
        $.ajax({
          url: "{URL}/core/ajax/payment.handler.php?handler=Payment.Proccess_Transaction",
          data: {Method:Method, Type:Type, Ref:Ref, Plate:Plate, Name:Name, Trl:Trl, Time:Time, VehType:VehType, Service:Service},
          method: "POST",
          dataType: "json",
          success:function(Response) {

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
      } else if(Account_ID == "unchecked") {
        alert("Please choose a valid account");
      } else {
        $.ajax({
          url: "{URL}/core/ajax/payment.handler.php?handler=Payment.Proccess_Transaction",
          data: {Method:Method, Type:Type, Ref:Ref, Plate:Plate, Name:Name, Trl:Trl, Time:Time, VehType:VehType, Service:Service, Account_ID:Account_ID},
          method: "POST",
          dataType: "json",
          success:function(Response) {

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
      } else {
        $.ajax({
          url: "{URL}/core/ajax/payment.handler.php?handler=Payment.Proccess_Transaction",
          data: {Method:Method, Type:Type, Ref:Ref, Plate:Plate, Name:Name, Trl:Trl, Time:Time, VehType:VehType, Service:Service},
          method: "POST",
          dataType: "json",
          success:function(Response) {

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
      } else if(CardNo.length < 7) {
        alert("Please choose a valid card number");
      } else if(CardExpiry.length < 3) {
        alert("Please choose a valid card expiry date");
      } else {
        $.ajax({
          url: "{URL}/core/ajax/payment.handler.php?handler=Payment.Proccess_Transaction",
          data: {Method:Method, Type:Type, Ref:Ref, Plate:Plate, Name:Name, Trl:Trl, Time:Time, VehType:VehType, Service:Service, CardNo:CardNo, CardExpiry:CardExpiry},
          method: "POST",
          dataType: "json",
          success:function(Response) {

          }
        });
      }
    }
  }
  //Payment Service Dropdown
  $(document).on('change', '#Payment_VehType', function(){
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
  $(document).on('change', 'input[name="Payment_Services_Expiry"]:checked', function(){
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
</script>
