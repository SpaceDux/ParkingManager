<script type="text/javascript">

//Vehicle Feeds
//ANPR Vehicle Feed
$(document).ready(function() {
    $('#ANPR_Feed').html('<img src="<?php echo URL?>/assets/img/loading.gif" style="margin-left: 40%;align: middle;max-width: 20%; max-height: 20%;"></img>');
    $.ajax({
      url: "<?php echo URL ?>/core/ajax/vehicles.ajax.php?handler=ANPR_Feed",
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
      dataType: "text",
      success:function(data) {
        $('#PAID_Feed').html(data);
      }
    })
})
//Renewal Vehicle Feed
$(document).ready(function() {
    $('#RENEWAL_Feed').html('<img src="<?php echo URL?>/assets/img/loading.gif" style="margin-left: 40%;align: middle;max-width: 20%; max-height: 20%;"></img>');
    $.ajax({
      url: "<?php echo URL ?>/core/ajax/vehicles.ajax.php?handler=RENEWAL_Feed",
      dataType: "text",
      success:function(data) {
        $('#RENEWAL_Feed').html(data);
      }
    })
})
//Exit Vehicle Feed
$(document).ready(function() {
    $('#EXIT_Feed').html('<img src="<?php echo URL?>/assets/img/loading.gif" style="margin-left: 40%;align: middle;max-width: 20%; max-height: 20%;"></img>');
    $.ajax({
      url: "<?php echo URL ?>/core/ajax/vehicles.ajax.php?handler=EXIT_Feed",
      dataType: "text",
      success:function(data) {
        $('#EXIT_Feed').html(data);
      }
    })
})
//=====


//Misc
//Refresh ANPR (Blue button)
$('#refreshANPR').click(function() {
  $('#ANPR_Feed').html('<img src="<?php echo URL?>/assets/img/loading.gif" style="margin-left: 40%;align: middle;max-width: 20%; max-height: 20%;"></img>');
  $.ajax({
    url: "<?php echo URL ?>/core/ajax/vehicles.ajax.php?handler=ANPR_Feed",
    dataType: "text",
    success:function(data) {
      $('#ANPR_Feed').html(data);
    }
  })
})
//ANPR Search Filter
$('#ANPR_Filter').keyup(function(){
  var Filter = $(this).val();
  if(Filter == '') {
    $('#ANPR_FilterResult').empty();
  } else {
    $('#ANPR_FilterResult').html('');
    $.ajax({
      url: "<?php echo URL ?>/core/ajax/vehicles.ajax.php?handler=ANPR_Filter",
      type: "POST",
      data: {Filter:Filter},
      dataType: "text",
      success:function(data) {
        $('#ANPR_FilterResult').html('<img src="<?php echo URL?>/assets/img/loading.gif" style="margin-left: 40%;align: middle;max-width: 20%; max-height: 20%;"></img>');
        $('#ANPR_FilterResult').html(data);
      }
    })
  }
})
//Exit Button
function exit(str) {
  event.preventDefault();
  var veh_id = str;
  $.ajax({
    url: "<?php echo URL?>/core/ajax/vehicles.ajax.php?handler=Vehicle_Exit",
    type: "POST",
    data: {veh_id:veh_id}
  })
}
//Flag Button
function setFlag(str) {
  event.preventDefault();
  var veh_id = str;
  $.ajax({
    url: "<?php echo URL?>/core/ajax/vehicles.ajax.php?handler=Vehicle_Flag",
    type: "POST",
    data: {veh_id:veh_id}
  })
}
</script>
