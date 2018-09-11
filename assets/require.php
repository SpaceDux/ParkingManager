<script type="text/javascript">
  //Menu JS
  function menuHide() {
    var sideBar = document.getElementById("sideBar");
    var wrapper = document.getElementById("wrapper");
    if (sideBar.style.marginLeft === "-220px") {
        sideBar.style.marginLeft = "0px";
        sideBar.style.transition = "0.2s ease-in-out";
        //Wrapper
        wrapper.style.paddingLeft = "220px";
        wrapper.style.transition = "0.2s ease-in-out";
    } else {
        sideBar.style.marginLeft = "-220px";
        sideBar.style.transition = "0.2s ease-in-out";
        //Wrapper
        wrapper.style.paddingLeft = "0px";
        wrapper.style.transition = "0.2s ease-in-out";
    }
  }
  //AJAX for Exit
  function exit(str) {
    event.preventDefault();
    var veh_id = str;
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=exit",
      type: "POST",
      data: "veh_id="+veh_id
    })
    $('#tables').load(' #tables');
  }
  //Ajax mark Renewal function
  function markRenewal(str) {
    event.preventDefault();
    var veh_id = str;
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=markRenewal",
      type: "POST",
      data: "veh_id="+veh_id
    })
    $('#tables').load(' #tables');
  }
  //Ajax setFlag Function
  function setFlag(str) {
    event.preventDefault();
    var veh_id = str;
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=setFlag",
      type: "POST",
      data: "veh_id="+veh_id
    })
    $('#tables').load(' #tables');
  }
  //Ajax deleteVehicle Function
  function deleteVehicle(str) {
    event.preventDefault();
    var veh_id = str;
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=deleteVehicle",
      type: "POST",
      data: "veh_id="+veh_id
    })
    $('#tables').load(' #tables');
  }
  //Ajax deleteNotice Function
  function deleteNotice(str) {
    event.preventDefault();
    var notice_id = str;
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=deleteNotice",
      type: "POST",
      data: "notice_id="+notice_id
    })
    $('#tables').load(' #tables');
  }
  //Ajax ANPR Duplicate
  function ANPR_Duplicate(str) {
    event.preventDefault();
    var anpr_id = str;
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=ANPR_Duplicate",
      type: "POST",
      data: "anpr_id="+anpr_id
    })
    $('#anpr').load(' #anpr');
  }
  //ANPR Search
  $(document).ready(function() {
    $('#ANPR_Search').keyup(function(){
      var search = $(this).val();
      if(search == '') {
        $('#return').empty();
      } else {
        $('#return').html('');
        $.ajax({
         url: "<?php echo URL?>/ajax-handler.php?handler=ANPR_Search",
         type: "POST",
         data: {search:search},
         dataType: "text",
         success:function(data) {
           $('#return').html(data);
         }
        })
      }
    });
  })
  //ANPR Edit Record Display
  $(document).on('click', '#ANPR_Edit', function() {
    var anpr_id = $(this).data('id');
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=ANPR_Update_Get",
      type: "POST",
      data: {anpr_id:anpr_id},
      dataType: "json",
      success:function(data) {
        $('#ANPR_Update_ID').val(data.Uniqueref);
        $('#ANPR_Update_Plate').val(data.Plate);
        $('#ANPR_Update_Date').val(data.Capture_Date);
        $('#ANPR_UpdateModal').modal('toggle');
      }
    })
  });
  //ANPR Record Update
  function ANPR_Update() {
    var anpr_id = $('#ANPR_Update_ID').val();
    var Plate = $('#ANPR_Update_Plate').val();
    var Capture_Date = $('#ANPR_Update_Date').val();
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=ANPR_Update",
      type: "POST",
      data: "anpr_id="+anpr_id+"Plate="+Plate+"Capture_Date="+Capture_Date
    })
    $('#anpr').load(' #anpr');
    $('#ANPR_UpdateModal').modal('toggle');
  }
  //Refresh ANPR (Blue button)
  $('#refreshANPR').click(function(){
    $('#anpr').load(' #anpr');
  })
//Modal autofocus
  $('.modal').on('shown.bs.modal', function() {
    $(this).find('[autofocus]').focus();
  });
//Tab Key opens "AddVehicleModal" Modal
  Mousetrap.bind('tab', function() {
    $('#addVehicleModal').modal('show');
  });
</script>
