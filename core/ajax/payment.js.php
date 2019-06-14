<script type="text/javascript">
  // Ini Payment Portal
  function PaymentPaneToggle(Ref, Plate, Type) {
    var Ref = Ref;
    var Plate = Plate;
    var Type = Type;
    $('#Payment_Type').val(Type);
    $('#Payment_Ref').val(Ref);
    $('#Payment_Plate').val(Plate);
    PaymentPane();
    $('#PaymentOptions').html('<img style="width: 70px;display: block;margin: 20px auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
    $.ajax({
      url: "{URL}/core/ajax/payment.handler.php?handler=Payment.GET_PaymentOptions",
      data: {Plate:Plate},
      method: "POST",
      dataType: "text",
      success:function(Response) {
        $('#PaymentOptions').html(Response);
      }
    });
  };
  // Close Payment Portal
  function PaymentPaneClose() {
    $('#PaymentPane_Form')[0].reset();
    $('#PaymentPane_Form').load(' #PaymentPane_Form');

    PaymentPane();
  };
  //Payment Service CASH Dropdown
  $(document).on('change', '#Payment_VehType', function(){
    var Type = $(this).val();
    var Expiry = $('input[name="Payment_Services_Expiry"]:checked').val();
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
        data: {Type:Type, Expiry:Expiry},
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
  //Payment Service CASH Dropdown (EXPIRY)
  $(document).on('change', 'input[name="Payment_Services_Expiry"]:checked', function(){
    var Expiry = $(this).val();
    var Type = $('#Payment_VehType').val();
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
        data: {Type:Type, Expiry:Expiry},
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
