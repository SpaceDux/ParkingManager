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
  }, 15000);
</script>
