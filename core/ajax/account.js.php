<script type="text/javascript">
  $(document).on('click', '#Account_Register_Save', function() {
    event.preventDefault();
    var Data = $('#Account_Register_Form').serialize();
    $.ajax({
      url: "{URL}/core/ajax/account.handler.php?handler=Account.New_Account",
      method: "POST",
      data: Data,
      dataType: "json",
      success:function(Res) {

      }
    })
  });
</script>
