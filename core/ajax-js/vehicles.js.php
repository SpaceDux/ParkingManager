<script type="text/javascript">

//ANPR Vehicle Feed
$(document).ready(function() {
    $('#ANPR_Feed').html('<img src="<?php echo URL?>/assets/img/loading.gif" style="margin-left: 40%;align: middle;max-width: 20%; max-height: 20%;"></img>');
    $.ajax({
      url: "<?php echo URL ?>/core/ajax/vehicles.ajax.php?handler=ANPR_Feed",
      //type: "POST",
      dataType: "text",
      success:function(data) {
        $('#ANPR_Feed').html(data);
      }
    })
})
//Paid Vehicle Feed
$(document).ready(function() {
    $('#PAID_Feed').html('<img src="<?php echo URL?>/assets/img/loading.gif" style="margin-left: 40%;align: middle;max-width: 20%; max-height: 20%;"></img>');
    $.ajax({
      url: "<?php echo URL ?>/core/ajax/vehicles.ajax.php?handler=PAID_Feed",
      //type: "POST",
      dataType: "text",
      success:function(data) {
        $('#PAID_Feed').html(data);
      }
    })
})
</script>
