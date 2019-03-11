<script type="text/javascript">
//Parking
$(document).on('click', '#Parking_Tile', function() {
  $('#Wrapper').addClass("Hide");
  $.ajax({
    url: "<?php echo URL?>/ajax-handler.php?handler=Kiosk_Parking",
    type: "POST",
    success:function(data) {
      $('#Page').html(data);
    }
  })
});
//Wash
$(document).on('click', '#Wash_Tile', function() {
  alert("YOU CLICKED WASH");
});
//Exchange
$(document).on('click', '#Exchange_Tile', function() {
  alert("YOU CLICKED EXCHANGE");
});
</script>
