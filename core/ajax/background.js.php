<script type="text/javascript">
  //automate Exit x1min
  setInterval(function(){
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Background.Automation_Exit",
      type: "POST",
      success:function() {

      }
    })
  }, 30000);
</script>
