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
    var veh_id = str;
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?p=exit",
      type: "POST",
      data: "veh_id="+veh_id
    })
    $('#tables').load(' #tables');
  }
//Modal autofocus
  $('.modal').on('shown.bs.modal', function() {
    $(this).find('[autofocus]').focus();
  });
//Tab Key opens + Modal
  Mousetrap.bind('tab', function() {
    $('#addVehicleModal').modal('show');
  });
