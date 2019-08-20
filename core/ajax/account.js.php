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
  function Account_Settings(Ref) {
    event.preventDefault();
    $.ajax({
      url: "{URL}/core/ajax/account.handler.php?handler=Account.Update_Account_GET",
      method: "POST",
      data: {Ref:Ref},
      dataType: "json",
      success:function(Res) {
        $('#Account_Update_Modal').modal('toggle');
        $('#Ref').val(Res.Uniqueref);
        $('#Name').val(Res.Name);
        $('#ShortName').val(Res.ShortName);
        $('#Address').val(Res.Address);
        $('#Contact_Email').val(Res.Contact_Email);
        $('#Billing_Email').val(Res.Billing_Email);
        $('#Site').val(Res.Site);
        $('#Shared').val(Res.Shared);
        $('#Discount').val(Res.Discount_Vouchers);
        $('#Status').val(Res.Status);
      }
    })
  }
  function Account_Settings_Fleet(Ref) {
    event.preventDefault();
    $('#Account_Update_Fleet_Form').find('[autofocus]').focus();
    $.ajax({
      url: "{URL}/core/ajax/account.handler.php?handler=Account.Update_Fleet_GET",
      method: "POST",
      data: {Ref:Ref},
      dataType: "json",
      success:function(Res) {
        $('#Account_Update_Fleet_Modal').modal('toggle');
        $('#Acc_Ref').val(Ref);
        $('#FleetListTbl').html(Res);
      }
    })
  }
  function Fleet_Delete(Ref) {
    var Acc = $('#Acc_Ref').val();
    $.ajax({
      url: "{URL}/core/ajax/account.handler.php?handler=Account.Delete_Fleet_Record",
      method: "POST",
      data: {Ref:Ref},
      dataType: "json",
      success:function(Res) {
        if(Res > 0) {
          $.ajax({
            url: "{URL}/core/ajax/account.handler.php?handler=Account.Update_Fleet_GET",
            method: "POST",
            data: {Ref:Acc},
            dataType: "json",
            success:function(Res) {
              $('#FleetListTbl').html(Res);
            }
          })
        }
      }
    })
  }
  $(document).on('click', '#Account_Update_Save', function() {
    event.preventDefault();
    var Data = $('#Account_Update_Form').serialize();
    $.ajax({
      url: "{URL}/core/ajax/account.handler.php?handler=Account.Update_Account",
      method: "POST",
      data: Data,
      success:function(Res) {
        $('#Account_Update_Modal').modal('toggle');
      }
    })
  });
  $(document).on('submit', '#Account_Update_Fleet_Form', function() {
    event.preventDefault();
    var Ref = $('#Acc_Ref').val();
    var Plate = $('#Plate').val();
    $.ajax({
      url: "{URL}/core/ajax/account.handler.php?handler=Account.Update_Fleet",
      method: "POST",
      data: {Ref:Ref, Plate:Plate},
      success:function(Res) {
        if(Res > 0) {
          $('#Plate').val('');
          $.ajax({
            url: "{URL}/core/ajax/account.handler.php?handler=Account.Update_Fleet_GET",
            method: "POST",
            data: {Ref:Ref},
            dataType: "json",
            success:function(Res) {
              $('#FleetListTbl').html(Res);
            }
          })
        }
      }
    })
  });
</script>
