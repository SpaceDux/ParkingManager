<script type="text/javascript">
  // Ini Payment Portal
  function PaymentPaneToggle(Ref, Plate, Type) {
    var Ref = Ref;
    var Plate = Plate;
    var Type = Type;
    $.ajax({
      url: "{URL}/core/ajax/payment.handler.php?handler=Payment.GET_PaymentOptions",
      data: {Plate:Plate},
      method: "POST",
      dataType: "text",
      success:function(Response) {
        $('#PaymentOptions').html(Response);
        $('#Payment_Type').val(Type);
        $('#Payment_Ref').val(Ref);
        $('#Payment_Plate').val(Plate);

        PaymentPane();
      }
    });

  };
  // Close Payment Portal
  function PaymentPaneClose() {
    $('#PaymentPane_Form')[0].reset();

    PaymentPane();
  };
</script>
