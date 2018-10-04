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
  //Payment Service Delete
  function Payment_Service_Delete(str) {
    event.preventDefault();
    var Service = str;
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=Payment_Service_Delete",
      type: "POST",
      data: "Service="+Service
    })
    $('#tables').load(' #tables');
  }
  //Delete User
  function User_Delete(str) {
    event.preventDefault();
    var User_ID = str;
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=User_Delete",
      type: "POST",
      data: {User_ID:User_ID}
    })
    $('#tables').load(' #tables');
  }
  //Force Logout
  function Force_Logout(str) {
    event.preventDefault();
    var User_ID = str;
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=Force_Logout",
      type: "POST",
      data: {User_ID:User_ID}
    })
    $('#tables').load(' #tables');
  }
  //Delete Vehicle TYPE
  function Vehicle_Service_Delete(str) {
    event.preventDefault();
    var id = str;
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=Vehicle_Service_Delete",
      type: "POST",
      data: {id:id},
      success: function() {
        $('#tables').load(' #tables');
      }
    });
  }
  //Search Functions
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
    var Service_Cash = $(".Service_Cash:checked").val();
    var Service_Card = $(".Service_Card:checked").val();
    var Service_Account = $(".Service_Account:checked").val();
    var Service_Snap = $(".Service_Snap:checked").val();
    var Service_Fuel = $(".Service_Fuel:checked").val();
    var Service_Campus = $("#Service_Campus option:selected").val();
    var Service_Meal = $("#Service_mealVoucher option:selected").val();
    var Service_Shower = $("#Service_showerVoucher option:selected").val();
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=Payment_Add_Service",
      type: "POST",
      data: "Service_Name="+Service_Name+"&Service_Price_Gross="+Service_Price_Gross+"&Service_Price_Net="+Service_Price_Net+"&Service_Expiry="+Service_Expiry+"&Service_Cash="+Service_Cash+"&Service_Card="+Service_Card+"&Service_Account="+Service_Account+"&Service_Snap="+Service_Snap+"&Service_Fuel="+Service_Fuel+"&Service_Campus="+Service_Campus+"&Service_Meal="+Service_Meal+"&Service_Shower="+Service_Shower,
      success:function() {
        $('#Payment_Service_AddModal').modal('toggle');
        $('#tables').load(' #tables');
        $('#Payment_Service_AddForm')[0].reset();
      }
    });
    event.preventDefault();
    return false;
  });
  //Payment Service Update GET
  $(document).on('click', '#Payment_Service_Update_Modal', function() {
    var service_id = $(this).data('id');
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=Payment_Service_Update_Get",
      type: "POST",
      data: {service_id:service_id},
      dataType: "json",
      success:function(data) {
        $('#Service_ID_Update').val(data.id);
        $('#Service_Name_Update').val(data.service_name);
        $('#Service_Price_Gross_Update').val(data.service_price_gross);
        $('#Service_Price_Net_Update').val(data.service_price_net);
        $('#Service_Expiry_Update').val(data.service_expiry);
        $('#Service_Cash_Update').val(data.service_cash);
        $('#Service_Card_Update').val(data.service_card);
        $('#Service_Account_Update').val(data.service_account);
        $('#Service_Snap_Update').val(data.service_snap);
        $('#Service_Fuel_Update').val(data.service_fuel);
        $('#Service_Campus_Update').val(data.service_campus);
        $('#Service_mealVoucher_Update').val(data.service_mealVoucher);
        $('#Service_showerVoucher_Update').val(data.service_showerVoucher);
        $('#Service_Vehicles_Update_Hidden').val(data.service_vehicles);
        $('#Payment_Service_UpdateModal').modal('toggle');
      }
    })
  });
  //Payment Service Record Update
  $(document).on('click', '#Payment_Service_Update', function(){
    $('#Service_Vehicles_Update_Hidden').val($('#Service_Vehicles_Update').val());
    var Service_ID = $('#Service_ID_Update').val();
    var Service_Name = $("#Service_Name_Update").val();
    var Service_Price_Gross = $("#Service_Price_Gross_Update").val();
    var Service_Price_Net = $("#Service_Price_Net_Update").val();
    var Service_Expiry = $("#Service_Expiry_Update").val();
    var Service_Cash = $("#Service_Cash_Update option:selected").val();
    var Service_Card = $("#Service_Card_Update option:selected").val();
    var Service_Account = $("#Service_Account_Update option:selected").val();
    var Service_Snap = $("#Service_Snap_Update option:selected").val();
    var Service_Fuel = $("#Service_Fuel_Update option:selected").val();
    var Service_Campus = $("#Service_Campus_Update option:selected").val();
    var Service_Meal = $("#Service_mealVoucher_Update option:selected").val();
    var Service_Shower = $("#Service_showerVoucher_Update option:selected").val();
    var Service_Vehicles = $("#Service_Vehicles_Update_Hidden").val();
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=Payment_Service_Update",
      type: "POST",
      data: "Service_ID="+Service_ID+"&Service_Name="+Service_Name+"&Service_Price_Gross="+Service_Price_Gross+"&Service_Price_Net="+Service_Price_Net+"&Service_Expiry="+Service_Expiry+"&Service_Cash="+Service_Cash+"&Service_Card="+Service_Card+"&Service_Account="+Service_Account+"&Service_Snap="+Service_Snap+"&Service_Fuel="+Service_Fuel+"&Service_Campus="+Service_Campus+"&Service_Meal="+Service_Meal+"&Service_Shower="+Service_Shower+"&Service_Vehicles="+Service_Vehicles,
      success: function(){
        $('#tables').load(' #tables');
        $('#Payment_Service_UpdateModal').modal('toggle');
        $('#Payment_Service_UpdateForm')[0].reset();
      }
    });
    event.preventDefault();
    return false;
  });
  //Vehicle Type Update GET
  $(document).on('click', '#Update_Vehicle_TypeBtn', function() {
    var type_id = $(this).data('id');
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=Vehicle_Service_Update_Get",
      type: "POST",
      data: {type_id:type_id},
      dataType: "json",
      success:function(data) {
        $('#Update_Type_ID').val(data.id);
        $('#Update_Type_Name').val(data.type_name);
        $('#Update_Type_Short').val(data.type_shortName);
        $('#Update_Type_ImageURL').val(data.type_imageURL);
        $('#Update_Type_Campus').val(data.campus);
        $('#Update_Vehicle_TypeModal').modal('toggle');
      }
    })
  });
  //User Register (Add)
  $(document).on('click', '#User_Save_New', function(){
    var User_Firstname_New = $("#User_Firstname_New").val();
    var User_Lastname_New = $("#User_Lastname_New").val();
    var User_Email_New = $("#User_Email_New").val();
    var User_Password_New = $("#User_Password_New").val();
    var User_Campus_New = $("#User_Campus_New option:selected").val();
    var User_ANPR_New = $("#User_ANPR_New option:selected").val();
    var User_Rank_New = $("#User_Rank_New option:selected").val();
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=User_Add",
      type: "POST",
      data: "User_Firstname_New="+User_Firstname_New+"&User_Lastname_New="+User_Lastname_New+"&User_Email_New="+User_Email_New+"&User_Password_New="+User_Password_New+"&User_ANPR_New="+User_ANPR_New+"&User_Rank_New="+User_Rank_New+"&User_Campus_New="+User_Campus_New,
      success:function() {
        event.preventDefault();
        $('#User_New').modal('toggle');
        //Reset form code here
        $('#tables').load(' #tables');
      }
    });
    return false;
  })
  //User Update GET
  $(document).on('click', '#User_Update', function(){
    var User_ID = $(this).data('id');
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=Update_User_Get",
      type: "POST",
      data: {User_ID:User_ID},
      dataType: "json",
      success:function(data) {
        $("#User_ID").val(data.id);
        $("#User_Firstname_Update").val(data.first_name);
        $("#User_Lastname_Update").val(data.last_name);
        $("#User_Email_Update").val(data.email);
        $("#User_Campus_Update").val(data.campus);
        $("#User_ANPR_Update").val(data.anpr);
        $("#User_Rank_Update").val(data.rank);
        $('#User_UpdateModal').modal('toggle');
      }
    });
  })
  //User Record Update
  $(document).on('click', '#User_Save_Update', function(){
    var User_ID = $('#User_ID').val();
    var User_Firstname_Update = $("#User_Firstname_Update").val();
    var User_Lastname_Update = $("#User_Lastname_Update").val();
    var User_Email_Update = $("#User_Email_Update").val();
    var User_Campus_Update = $("#User_Campus_Update option:selected").val();
    var User_ANPR_Update = $("#User_ANPR_Update option:selected").val();
    var User_Rank_Update = $("#User_Rank_Update option:selected").val();
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=Update_User",
      type: "POST",
      data: "User_ID="+User_ID+"&User_Firstname_Update="+User_Firstname_Update+"&User_Lastname_Update="+User_Lastname_Update+"&User_Email_Update="+User_Email_Update+"&User_Campus_Update="+User_Campus_Update+"&User_ANPR_Update="+User_ANPR_Update+"&User_Rank_Update="+User_Rank_Update,
      success:function() {
        event.preventDefault();
        $('#User_UpdateModal').modal('toggle');
        //Reset form code here
        $('#tables').load(' #tables');
      }
    });
    return false;
    event.preventDefault();
  });
  //Vehicle Type update record
  $(document).on('click', '#Update_Type_Save', function(){
    var id = $('#Update_Type_ID').val();
    var name = $('#Update_Type_Name').val();
    var short = $('#Update_Type_Short').val();
    var url = $('#Update_Type_ImageURL').val();
    var campus = $('#Update_Type_Campus').val();
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=Vehicle_Service_Update_Data",
      type: "POST",
      data: "id="+id+"&name="+name+"&short="+short+"&url="+url+"&campus="+campus,
      success:function(){
        $('#tables').load(' #tables');
        $('#Update_Vehicle_TypeModal').modal('toggle');
      }
    })
    event.preventDefault();
    return false;
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
