<script type="text/javascript">
  // Login
  $('#NotificationsBtn').on('click', function() {
    event.preventDefault();
    $('#Load_Notifications').html('<img style="width: 70px;display: block;margin: 50% auto;" src="{URL}/template/{TPL}/img/loading.gif"></img>');
    $.ajax({
      url: "{URL}/core/ajax/pm.handler.php?handler=PM.GET_Notifications",
      method: "POST",
      dataType: "text",
      success:function(Response) {
        $('#Load_Notifications').html(Response);
      }
    });
  });
  // Add a new site to pm
  $(document).on('submit', '#Site_Register_Form', function(e) {
    e.preventDefault();
    var Data = $('#Site_Register_Form').serialize();
    $.ajax({
      url: "{URL}/core/ajax/pm.handler.php?handler=PM.New_Site",
      type: "POST",
      data: Data,
      dataType: "json",
      success:function(Data) {
        if(Data.Result == 1) {
          $.notify(Data.Message, {className:'success',globalPosition: 'top left',});
          $('#Site_Register_Modal').modal('toggle');
          $('#Site_Register_Form')[0].reset();
        } else {
          $.notify(Data.Message, {className:'error',globalPosition: 'top left',});
        }
      }
    })
  });
  // Add a new site to pm
  $(document).on('submit', '#Site_Update_Form', function(e) {
    e.preventDefault();
    var Data = $('#Site_Update_Form').serialize();
    $.ajax({
      url: "{URL}/core/ajax/pm.handler.php?handler=PM.Update_Site",
      type: "POST",
      data: Data,
      dataType: "json",
      success:function(Data) {
        if(Data.Result == 1) {
          $.notify(Data.Message, {className:'success',globalPosition: 'top left',});
          $('#Site_Update_Modal').modal('toggle');
          $('#Site_Update_Form')[0].reset();
        } else {
          $.notify(Data.Message, {className:'error',globalPosition: 'top left',});
        }
      }
    })
  });
  function Site_Settings(Ref) {
    event.preventDefault();
    $.ajax({
      url: "{URL}/core/ajax/pm.handler.php?handler=PM.Update_Site_GET",
      method: "POST",
      data: {Ref:Ref},
      dataType: "json",
      success:function(Res) {
        $('#Site_Ref_Update').val(Res.Uniqueref);
        $('#Site_Name_Update').val(Res.Name);
        $('#Site_Barrier_IN_Update').val(Res.Barrier_IN);
        $('#Site_VAT_Update').val(Res.Vatno);
        $('#Site_Barrier_OUT_Update').val(Res.Barrier_OUT);
        $('#Site_ANPR_IP_Update').val(Res.ANPR_IP);
        $('#Site_ANPR_DB_Update').val(Res.ANPR_DB);
        $('#Site_ANPR_Imgsrv_Update').val(Res.ANPR_Img);
        $('#Site_ANPR_User_Update').val(Res.ANPR_User);
        $('#Site_ANPR_Pass_Update').val(Res.ANPR_Password);
        $('#Site_ANPR_Imgstr_Update').val(Res.ANPR_Imgstr);
        $('#Site_Unifi_Status_Update').val(Res.Unifi_Status);
        $('#Site_Unifi_User_Update').val(Res.Unifi_User);
        $('#Site_Unifi_Pass_Update').val(Res.Unifi_Pass);
        $('#Site_Unifi_IP_Update').val(Res.Unifi_IP);
        $('#Site_Unifi_Site_Update').val(Res.Unifi_Site);
        $('#Site_Unifi_Ver_Update').val(Res.Unifi_Ver);
        $('#Site_ETP_User_Update').val(Res.ETP_User);
        $('#Site_ETP_Pass_Update').val(Res.ETP_Pass);
        $('#Site_Update_Modal').modal('toggle');
      }
    })
  }
  function EOD_SettlementToggle() {
    var Date1 = $('#TL_DateStart').val();
    var Date2 = $('#TL_DateEnd').val();

    $.ajax({
      url: "{URL}/core/ajax/pm.handler.php?handler=PM.EOD_Settlement",
      type: "POST",
      data: {Date1:Date1, Date2:Date2}
    });
  }
  function BarrierToggle(Which) {
    event.preventDefault();
    $.ajax({
      url: "{URL}/core/ajax/pm.handler.php?handler=PM.Barrier_Toggle",
      type: "POST",
      data: {Which:Which},
      dataType: 'json',
      success:function(Data) {
        if(Data.Result == 1) {
          $.notify(Data.Message, {className:'success',globalPosition: 'top left',});
        } else {
          $.notify(Data.Message, {className:'error',globalPosition: 'top left',});
        }
      }
    });
  }
</script>
