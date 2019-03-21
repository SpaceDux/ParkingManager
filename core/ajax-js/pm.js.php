<script type="text/javascript">
//Exit Keypad
$(document).on('keyup', '#PM_ExitCode', function() {
  event.preventDefault();
  Code = $(this).val();

  if (Code.includes("*")) {
    $('#ExitForm')[0].reset();
  }

  if(Code.includes("£") || Code.includes("#")) {
    $.ajax({
      url: "<?php echo URL?>/core/ajax/pm.ajax.php?handler=ExitKeypad",
      type: "POST",
      data: {Code:Code},
      success:function(data) {
        if(data == "1") {
          $('#ExitForm')[0].reset();
        } else {
          $('#ExitForm')[0].reset();
        }
      }
    })
  }
});
function PM_SwitchSite() {
  $.ajax({
    url: "<?php echo URL?>/core/ajax/pm.ajax.php?handler=PM_SiteSwap",
    type: "POST",
    success:function() {
      window.location.replace("<?php echo URL?>/main");
    }
  })
}
</script>
