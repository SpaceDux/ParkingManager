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
        if(Res.Result == 1) {
        $.notify(Res.Message, {className:'success',globalPosition: 'top left',});
          $('#Account_Register_Modal').modal('toggle');
          $('#Account_Register_Form')[0].reset();
        } else {
          $.notify(Res.Message, {className:'error',globalPosition: 'top left',});
        }
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
        $('#Account_Update_Modal').modal('toggle');
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

  $(document).on('submit', '#Account_Update_Form', function() {
    event.preventDefault();
    var Data = $('#Account_Update_Form').serialize();
    $.ajax({
      url: "{URL}/core/ajax/account.handler.php?handler=Account.Update_Account",
      method: "POST",
      data: Data,
      dataType: 'json',
      success:function(Res) {
        if(Res.Result == 1) {
          $.notify(Res.Message, {className:'success',globalPosition: 'top left',});
          $('#Account_Update_Modal').modal('toggle');
        } else {
          $.notify(Res.Message, {className:'error',globalPosition: 'top left',});
        }
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
      dataType: 'json',
      success:function(Res) {
        if(Res.Status > 0) {
          $.notify(Res.Message, {className:'success',globalPosition: 'top left',});
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
        } else {
          $('#Plate').val('');
          $.notify(Res.Message, {className:'error',globalPosition: 'top left',});
        }
      }
    })
  });
  // Account Report data tables
  $(document).ready(function() {
    // fill_datatable_Report();
    function fill_datatable_Report(Account = '', DateStart = '', DateEnd = '')
    {
     var dataTable = $('#AccReport_Tbl').DataTable({
      "processing" : true,
      "serverSide" : true,
      "search" : false,
      "order" : [[5, 'asc']],
      "ajax" : {
       url:"{URL}/core/ajax/account.handler.php?handler=Account.Account_Report",
       type:"POST",
       data:{
        Account:Account, DateStart:DateStart, DateEnd:DateEnd
       }
      }
     });
    }
    $('#Report_Generate').click(function()
    {
      var Account = $('#Report_Account').val();
      var DateStart = $('#Report_DateFrom').val();
      var DateEnd = $('#Report_DateToo').val();
      if(Account != 'unselected' && DateStart != '' && DateEnd != '')
      {
        $('#AccReport_Tbl').DataTable().destroy();
        fill_datatable_Report(Account, DateStart, DateEnd);
      }
      else
      {
        alert('Please choose an Account, Start & End date');
        $('#AccReport_Tbl').DataTable().destroy();
        // fill_datatable_Report();
      }
    });
  });
  $(document).on('click', '#Report_Generate', function() {
    var Account = $('#Report_Account').val();
    var DateStart = $('#Report_DateFrom').val();
    var DateEnd = $('#Report_DateToo').val();
    $.ajax({
      url: "{URL}/core/ajax/account.handler.php?handler=Account.Totals",
      method: "POST",
      data: {Account:Account, DateStart:DateStart, DateEnd:DateEnd},
      dataType: "json",
      success:function(Res) {
        $('#AccountTotals').html(Res);
      }
    })
  });
  function Download_AccountReport() {
    var Account = $('#Report_Account').val();
    var DateStart = $('#Report_DateFrom').val();
    var DateEnd = $('#Report_DateToo').val();
    $.ajax({
      url: "{URL}/core/ajax/account.handler.php?handler=Account.DownloadReport",
      method: "POST",
      data: {Account:Account, DateStart:DateStart, DateEnd:DateEnd}
    })
  }
</script>
