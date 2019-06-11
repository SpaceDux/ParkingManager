<script type="text/javascript">
  // Ini Payment Portal
  function PaymentPaneToggle(Ref, Type) {
    var Ref = Ref;
    var Type = Type;
    $('#Payment_Type').val(Type);
    $('#Payment_Ref').val(Ref);

    PaymentPane();
  };
  // Close Payment Portal
  function PaymentPaneClose() {
    $('#PaymentPane_Form')[0].reset();

    PaymentPane();
  };
</script>
