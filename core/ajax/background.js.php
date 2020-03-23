<script type="text/javascript">
  //automate Exit x1min
  setInterval(function(){
    $.ajax({
      url: "{URL}/core/ajax/background.handler.php?handler=Background.Automation_Exit",
      type: "POST",
      dataType: 'json',
      success:function(Data) {
        if(Data.Result == 1) {
          $.notify(Data.Message, {className:'success',globalPosition: 'top left',});
        }
      }
    })
  }, 30000);
  // Reinstate PArking
  setInterval(function(){
    $.ajax({
      url: "{URL}/core/ajax/background.handler.php?handler=Background.Parking_Reinstate",
      type: "POST",
      dataType: 'json',
      success:function(Data) {
        if(Data.Result == 1) {
          $.notify(Data.Message, {className:'warning',globalPosition: 'top left',});
        }
      }
    })
  }, 30000);

  $(document).ready(function() {
    $.ajax({
      url: "{URL}/core/ajax/background.handler.php?handler=Background.Blacklist_Check",
      type: "POST",
      dataType: "json",
      success:function(Data) {
        $('#Blacklist_Ref').val(Data.Uniqueref);
        $('#Blacklist_ShowPlate').html(Data.Plate);
        $('#Blacklist_ShowMessage').html(Data.Message);
        $('#Blacklist_Show').modal('show');
      }
    });
  });

  $(document).on('click', '#Blacklist_RemindMeLater', function() {
    var Ref = $('#Blacklist_Ref').val();
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.RemindMeBlacklist",
      data: {Ref:Ref},
      type: "POST",
      dataType: "json",
      success:function(Data) {
        if(Data.Status == "1") {
          $('#Blacklist_Show').modal('hide');
          $('#Blacklist_Show').load(' #Blacklist_Show');
          $.notify(Data.Message, {className:'success',globalPosition: 'top left',});
        } else {
          $.notify(Data.Message, {className:'warning',globalPosition: 'top left',});
        }
      }
    })
  });

  function Blacklist_Delete(Ref)
  {
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.Blacklist_Delete",
      data: {Ref:Ref},
      type: "POST",
      dataType: "json",
      success:function(Data) {
        if(Data.Status > 0) {
          $.notify(Data.Message, {className:'success',globalPosition: 'top left',});
        } else {
          $.notify(Data.Message, {className:'danger',globalPosition: 'top left',});
        }
      }
    })
  }
</script>
