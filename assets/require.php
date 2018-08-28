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
