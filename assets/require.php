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
  //Ajax ANPR Barrier controls
  function ANPR_Barrier(str) {
    event.preventDefault();
    var barrier = str
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=ANPR_Barrier",
      type: "POST",
      data: "barrier="+barrier
    });
  }
  //Search
  $(document).ready(function() {
    //ANPR Search
    $('#ANPR_Search').keyup(function(){
      var ANPRKey = $(this).val();
      if(ANPRKey == '') {
        $('#return').empty();
      } else {
        $('#return').html('');
        $.ajax({
         url: "<?php echo URL?>/ajax-handler.php?handler=ANPR_Search",
         type: "POST",
         data: {ANPRKey:ANPRKey},
         dataType: "text",
         success:function(data) {
           $('#return').html(data);
         }
        })
      }
    });
    //PM Search
    $('#PM_SearchLogs').keyup(function(){
      var PMKey = $(this).val();
      if(PMKey == '') {
        $('#return').empty();
      } else {
        $('#return').html('');
        $.ajax({
         url: "<?php echo URL?>/ajax-handler.php?handler=PM_Search",
         type: "POST",
         data: {PMKey:PMKey},
         dataType: "text",
         success:function(data) {
           $('#return').html(data);
         }
        })
      }
    });
  });
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
  $(document).on('click', '#saveANPR', function(){
    var anpr_id = $('#ANPR_Update_ID').val();
    var Plate = $('#ANPR_Update_Plate').val();
    var Capture_Date = $('#ANPR_Update_Date').val();
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=ANPR_Update",
      type: "POST",
      data: "anpr_id="+anpr_id+"&Plate="+Plate+"&Capture_Date="+Capture_Date
    });
    event.preventDefault();
    $('#anpr').load(' #anpr');
    $('#ANPR_UpdateModal').modal('toggle');
  });
  //ANPR Add Vehicle
  $(document).on('click', '#addANPR', function() {
    var Plate = $("#ANPR_Add_Plate").val();
    var Capture_Date = $("#ANPR_Add_Date").val();
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=ANPR_Add",
      type: "POST",
      data: "Plate="+Plate+"&Date="+Capture_Date
    });
    event.preventDefault();
    $('#anpr').load(' #anpr');
    $('#ANPR_AddModal').modal('toggle');
  });
  //Payment Add Service
  $(document).on('click', '#Payment_Service_Save', function() {
    var Service_Name = $("#Service_Name").val();
    var Service_Price_Gross = $("#Service_Price_Gross").val();
    var Service_Price_Net = $("#Service_Price_Net").val();
    var Service_Expiry = $("#Service_Expiry").val();
    var Service_Cash = $("#Service_Cash:checked").val();
    var Service_Card = $("#Service_Card:checked").val();
    var Service_Account = $("#Service_Account:checked").val();
    var Service_Snap = $("#Service_Snap:checked").val();
    var Service_Fuel = $("#Service_Fuel:checked").val();
    var Service_Campus = $("#Service_Campus:checked").val();
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=Payment_Add_Service",
      type: "POST",
      data: "Service_Name="+Service_Name+"&Service_Price_Gross="+Service_Price_Gross+"&Service_Price_Net="+Service_Price_Net+"&Service_Expiry="+Service_Expiry+"&Service_Cash="+Service_Cash+"&Service_Card="+Service_Card+"&Service_Account="+Service_Account+"&Service_Snap="+Service_Snap+"&Service_Fuel="+Service_Fuel+"&Service_Campus="+Service_Campus
    });
    event.preventDefault();
    $('#tables').load(' #tables');
    //$('#Payment_Service_AddModal').modal('toggle');
  });
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
    $('#ANPR_AddModal').modal('show');
  });
</script>
