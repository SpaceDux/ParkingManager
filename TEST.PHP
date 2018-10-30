<?php
  require("global.php");
?>
<script type="text/javascript">
//Automate Exit (Every 30secs)
function AutomateExit() {
  $.ajax({
    url: "<?php echo URL ?>/ajax-handler.php?handler=Automation_Exit",
    type: "POST",
    success:function() {
      $('#tables').load(' #tables');
      //$('#anpr').load(' #anpr');
    }
  });
}
setInterval(function(){AutomateExit()}, 15000);

</script>
