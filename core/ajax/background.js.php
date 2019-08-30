<script type="text/javascript">
  //automate Exit x1min
  setInterval(function(){
    $.ajax({
      url: "{URL}/core/ajax/background.handler.php?handler=Background.Automation_Exit",
      type: "POST",
      success:function(Data) {
        if(Data.Result == 1) {
          $.notify(Data.Message, {className:'success',globalPosition: 'top left',});
        }
      }
    })
  }, 30000);
</script>
