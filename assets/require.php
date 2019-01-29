<?php
  //Pull all together
  //Vehicles CLASS
  require(__DIR__."..\../core/ajax-js/vehicles.js.php");
  //PM
  require(__DIR__."..\../core/ajax-js/pm.js.php");
?>
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
  function EOD_SettlementToggle() {
    event.preventDefault();
    var Date1 = $('#TL_DateStart').val();
    var Date2 = $('#TL_DateEnd').val();
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=EOD_Settlement",
      type: "POST",
      data: "Date1="+Date1+"&Date2="+Date2
    })
  }
  //Change USer PW
  function Change_User_Password(str) {
    event.preventDefault();
    $('#User_Change_PW').modal('toggle');
    $('#User_ID_ChangePW').val(str);
  }
  //AJAX for Fleet Delete
  function Account_Fleet_Delete(str) {
    event.preventDefault();
    var Key = str;
    var Acc_ID = $('#Account_ID').val();
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=Account_Fleet_Delete",
      type: "POST",
      data: {Key:Key}
    })
  }
  //AJAX account suspend
  function Account_Suspend(str) {
    event.preventDefault();
    var Key = str;
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=Account_Suspend",
      type: "POST",
      data: {Key:Key},
      success:function() {
        $('#tables').load(' #tables');
      }
    })
  }
  //AJAX account delete
  function Account_Delete(str) {
    event.preventDefault();
    var Key = str;
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=Account_Delete",
      type: "POST",
      data: {Key:Key},
      success:function() {
        $('#tables').load(' #tables');
      }
    })
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
  //Delete Payment Trigger
  function Payment_Delete(str) {
    event.preventDefault();
    $('#Delete_Payment_Modal').modal('toggle');
    $('#Payment_ID').val(str);
  }
  //Payment Ticket Reprint
  function Reprint_Ticket(str) {
    event.preventDefault();
    var id = str;
    $.ajax({
      url: "<?php echo URL ?>/ajax-handler.php?handler=Reprint_Ticket",
      type: "POST",
      data: {id:id}
    })
  }
  //ANPR Exit Log
  function ANPR_Exit_Log() {
    event.preventDefault();
    $('#ANPR_Exit_Log').modal('toggle');
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
    //PM Payments Search
    $('#PM_PaymentSearch').keyup(function(){
      var PMKey = $(this).val();
      if(PMKey == '') {
        $('#return').empty();
      } else {
        $('#return').html('');
        $.ajax({
         url: "<?php echo URL?>/ajax-handler.php?handler=PM_PaymentSearch",
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
      data: "Plate="+Plate+"&Date="+Capture_Date,
      success:function() {
        $('#ANPR_AddForm')[0].reset();
      }
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
    var Service_Cash = $("#Service_Cash").val();
    var Service_Card = $("#Service_Card").val();
    var Service_Account = $("#Service_Account").val();
    var Service_Snap = $("#Service_SNAP").val();
    var Service_Fuel = $("#Service_Fuel").val();
    var Service_Campus = $("#Service_Campus").val();
    var Service_Ticket = $("#Service_Ticket_Name").val();
    var Service_Meal_Amount = $("#Service_Meal_Amount").val();
    var Service_Shower_Amount = $("#Service_Shower_Amount").val();
    var Service_Group = $("#Service_Group").val();
    var Service_Vehicles = $("#Service_Vehicles").val();
    var Service_Vehicles_Any = $("#Service_Vehicles_Any").val();
    var Service_ETPID = $("#Service_ETPID").val();
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=Payment_Add_Service",
      type: "POST",
      data: "Service_Name="+Service_Name+"&Service_Ticket="+Service_Ticket+"&Service_Price_Gross="+Service_Price_Gross+"&Service_Price_Net="+Service_Price_Net+"&Service_Expiry="+Service_Expiry+"&Service_Cash="+Service_Cash+"&Service_Card="+Service_Card+"&Service_Account="+Service_Account+"&Service_Snap="+Service_Snap+"&Service_Fuel="+Service_Fuel+"&Service_Campus="+Service_Campus+"&Service_Meal_Amount="+Service_Meal_Amount+"&Service_Shower_Amount="+Service_Shower_Amount+"&Service_Group="+Service_Group+"&Service_Vehicles="+Service_Vehicles+"&Service_Vehicles_Any="+Service_Vehicles_Any+"&Service_ETPID="+Service_ETPID,
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
        $('#Service_Ticket_Name_Update').val(data.service_ticket_name);
        $('#Service_Price_Gross_Update').val(data.service_price_gross);
        $('#Service_Price_Net_Update').val(data.service_price_net);
        $('#Service_Expiry_Update').val(data.service_expiry);
        $('#Service_Cash_Update').val(data.service_cash);
        $('#Service_Card_Update').val(data.service_card);
        $('#Service_Account_Update').val(data.service_account);
        $('#Service_SNAP_Update').val(data.service_snap);
        $('#Service_Fuel_Update').val(data.service_fuel);
        $('#Service_Campus_Update').val(data.service_campus);
        $('#Service_Vehicles_Update').val(data.service_vehicles);
        $('#Service_Meal_Amount_Update').val(data.service_meal_amount);
        $('#Service_Shower_Amount_Update').val(data.service_shower_amount);
        $('#Service_Vehicles_Update').val(data.service_vehicles);
        $('#Service_Vehicles_Any_Update').val(data.service_anyvehicle);
        $('#Service_Group_Update').val(data.service_group);
        $('#Service_ETPID_Update').val(data.service_etpid);
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
    var Service_Cash = $("#Service_Cash_Update").val();
    var Service_Card = $("#Service_Card_Update").val();
    var Service_Account = $("#Service_Account_Update").val();
    var Service_Snap = $("#Service_SNAP_Update").val();
    var Service_Fuel = $("#Service_Fuel_Update").val();
    var Service_Campus = $("#Service_Campus_Update").val();
    var Service_Vehicles = $("#Service_Vehicles_Update").val();
    var Service_Meal_Amount = $("#Service_Meal_Amount_Update").val();
    var Service_Shower_Amount = $("#Service_Shower_Amount_Update").val();
    var Service_Ticket = $("#Service_Ticket_Name_Update").val();
    var Service_Any = $("#Service_Vehicles_Any_Update").val();
    var Service_Group = $("#Service_Group_Update").val();
    var Service_ETPID = $("#Service_ETPID_Update").val();
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=Payment_Service_Update",
      type: "POST",
      data:"Service_ID="+Service_ID+"&Service_Name="+Service_Name+"&Service_Ticket="+Service_Ticket+"&Service_Price_Gross="+Service_Price_Gross+"&Service_Price_Net="+Service_Price_Net+"&Service_Expiry="+Service_Expiry+"&Service_Cash="+Service_Cash+"&Service_Card="+Service_Card+"&Service_Account="+Service_Account+"&Service_Snap="+Service_Snap+"&Service_Fuel="+Service_Fuel+"&Service_Campus="+Service_Campus+"&Service_Vehicles="+Service_Vehicles+"&Service_Meal_Amount="+Service_Meal_Amount+"&Service_Shower_Amount="+Service_Shower_Amount+"&Service_Any="+Service_Any+"&Service_Group="+Service_Group+"&Service_ETPID="+Service_ETPID,
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
  //Payment Service CASH Dropdown
  $(document).on('change', '#NT_Vehicle_Type', function(){
    var veh_id = $(this).val();
    if(veh_id == 'unselected') {
      $('#Cash_Dropdown').empty();
    } else {
      $('#Cash_Dropdown').html('');
      $.ajax({
        url: "<?php echo URL ?>/ajax-handler.php?handler=Payment_Service_Cash_Dropdown_Get",
        type: "POST",
        data: {vehicle_type:veh_id},
        dataType: "text",
        success:function(data) {
          $('#Cash_Dropdown').html(data);
        }
      })
    }
  });
  //Payment Service CARD Dropdown
  $(document).on('change', '#NT_Vehicle_Type', function(){
    var veh_id = $(this).val();
    if(veh_id == 'unselected') {
      $('#Card_Dropdown').empty();
    } else {
      $('#Card_Dropdown').html('');
      $.ajax({
        url: "<?php echo URL?>/ajax-handler.php?handler=Payment_Service_Card_Dropdown_Get",
        type: "POST",
        data: {vehicle_type:veh_id},
        dataType: "text",
        success:function(data) {
          $('#Card_Dropdown').html(data);
        }
      })
    }
  });
  //Payment Service ACCOUNT Dropdown
  $(document).on('change', '#NT_Vehicle_Type', function(){
    var veh_id = $(this).val();
    if(veh_id == 'unselected') {
      $('#Account_Dropdown').empty();
    } else {
      $('#Account_Dropdown').html('');
      $.ajax({
        url: "<?php echo URL?>/ajax-handler.php?handler=Payment_Service_Account_Dropdown_Get",
        type: "POST",
        data: {vehicle_type:veh_id},
        dataType: "text",
        success:function(data) {
          $('#Account_Dropdown').html(data);
        }
      })
    }
  });
  //Payment Service SNAP Dropdown
  $(document).on('change', '#NT_Vehicle_Type', function(){
    var veh_id = $(this).val();
    if(veh_id == 'unselected') {
      $('#SNAP_Dropdown').empty();
    } else {
      $('#SNAP_Dropdown').html('');
      $.ajax({
        url: "<?php echo URL?>/ajax-handler.php?handler=Payment_Service_SNAP_Dropdown_Get",
        type: "POST",
        data: {vehicle_type:veh_id},
        dataType: "text",
        success:function(data) {
          $('#SNAP_Dropdown').html(data);
        }
      })
    }
  });
  //Payment Service Fuel Dropdown
  $(document).on('change', '#NT_Vehicle_Type', function(){
    var veh_id = $(this).val();
    if(veh_id == 'unselected') {
      $('#Fuel_Dropdown').empty();
    } else {
      $('#Fuel_Dropdown').html('');
      $.ajax({
        url: "<?php echo URL?>/ajax-handler.php?handler=Payment_Service_Fuel_Dropdown_Get",
        type: "POST",
        data: {vehicle_type:veh_id},
        dataType: "text",
        success:function(data) {
          $('#Fuel_Dropdown').html(data);
        }
      })
    }
  });
  //Renewal
  //Payment Service CASH Dropdown
  $(document).on('change', '#T_Vehicle_Type', function(){
    var veh_id = $(this).val();
    if(veh_id == 'unselected') {
      $('#Cash_Dropdown').empty();
    } else {
      $('#Cash_Dropdown').html('');
      $.ajax({
        url: "<?php echo URL ?>/ajax-handler.php?handler=Payment_Service_Cash_Dropdown_Get",
        type: "POST",
        data: {vehicle_type:veh_id},
        dataType: "text",
        success:function(data) {
          $('#Cash_Dropdown').html(data);
        }
      })
    }
  });
  //Payment Service CARD Dropdown
  $(document).on('change', '#T_Vehicle_Type', function(){
    var veh_id = $(this).val();
    if(veh_id == 'unselected') {
      $('#Card_Dropdown').empty();
    } else {
      $('#Card_Dropdown').html('');
      $.ajax({
        url: "<?php echo URL?>/ajax-handler.php?handler=Payment_Service_Card_Dropdown_Get",
        type: "POST",
        data: {vehicle_type:veh_id},
        dataType: "text",
        success:function(data) {
          $('#Card_Dropdown').html(data);
        }
      })
    }
  });
  //Payment Service ACCOUNT Dropdown
  $(document).on('change', '#T_Vehicle_Type', function(){
    var veh_id = $(this).val();
    if(veh_id == 'unselected') {
      $('#Account_Dropdown').empty();
    } else {
      $('#Account_Dropdown').html('');
      $.ajax({
        url: "<?php echo URL?>/ajax-handler.php?handler=Payment_Service_Account_Dropdown_Get",
        type: "POST",
        data: {vehicle_type:veh_id},
        dataType: "text",
        success:function(data) {
          $('#Account_Dropdown').html(data);
        }
      })
    }
  });
  //Payment Service SNAP Dropdown
  $(document).on('change', '#T_Vehicle_Type', function(){
    var veh_id = $(this).val();
    if(veh_id == 'unselected') {
      $('#SNAP_Dropdown').empty();
    } else {
      $('#SNAP_Dropdown').html('');
      $.ajax({
        url: "<?php echo URL?>/ajax-handler.php?handler=Payment_Service_SNAP_Dropdown_Get",
        type: "POST",
        data: {vehicle_type:veh_id},
        dataType: "text",
        success:function(data) {
          $('#SNAP_Dropdown').html(data);
        }
      })
    }
  });
  //Payment Service Fuel Dropdown
  $(document).on('change', '#T_Vehicle_Type', function(){
    var veh_id = $(this).val();
    if(veh_id == 'unselected') {
      $('#Fuel_Dropdown').empty();
    } else {
      $('#Fuel_Dropdown').html('');
      $.ajax({
        url: "<?php echo URL?>/ajax-handler.php?handler=Payment_Service_Fuel_Dropdown_Get",
        type: "POST",
        data: {vehicle_type:veh_id},
        dataType: "text",
        success:function(data) {
          $('#Fuel_Dropdown').html(data);
        }
      })
    }
  });
  //Process Payments
  //Cash
  $(document).on('click', '#NT_Process_Cash', function(){
    event.preventDefault();
    var ANPRKey = $('#NT_ANPRKey').val();
    var Plate = $('#NT_Vehicle_Plate').val();
    var Company = $('#NT_Company_Name').val();
    var Trailer = $('#NT_Vehicle_Trailer').val();
    var Type = $('#NT_Vehicle_Type').val();
    var Service = $('#NT_Payment_Service_Cash').val();
    if(Plate == "") {
      alert("A Vehicle registration is required!");
    } else if(Company == "") {
      alert("Company Name is required!");
    } else if(Type === "unchecked") {
      alert("Vehicle Type is required!");
    } else if (Service === "unchecked") {
      alert("Payment Service is required!");
    } else {
      //temp until response written
      jQuery(this).attr("id","DONE");
      $.ajax({
        url: "<?php echo URL?>/ajax-handler.php?handler=Transaction_Proccess_Cash",
        type: "POST",
        data: "ANPRKey="+ANPRKey+"&Plate="+Plate+"&Company="+Company+"&Trailer="+Trailer+"&Vehicle_Type="+Type+"&Service="+Service,
        success:function() {
          $('#Print_Ticket_Modal').modal({backdrop: 'static', keyboard: false, focus: true, show: true});
        }
      });
    }
  });
  //Card
  $(document).on('click', '#NT_Process_Card', function(){
    event.preventDefault();
    var ANPRKey = $('#NT_ANPRKey').val();
    var Plate = $('#NT_Vehicle_Plate').val();
    var Company = $('#NT_Company_Name').val();
    var Trailer = $('#NT_Vehicle_Trailer').val();
    var Type = $('#NT_Vehicle_Type').val();
    var Service = $('#NT_Payment_Service_Card').val();
    if(Plate == "") {
      alert("A Vehicle registration is required!");
    } else if(Company == "") {
      alert("Company Name is required!");
    } else if(Type === "unchecked") {
      alert("Vehicle Type is required!");
    } else if (Service === "unchecked") {
      alert("Payment Service is required!");
    } else {
      //temp until response written
      jQuery(this).attr("id","DONE");
      $.ajax({
        url: "<?php echo URL?>/ajax-handler.php?handler=Transaction_Proccess_Card",
        type: "POST",
        data: "ANPRKey="+ANPRKey+"&Plate="+Plate+"&Company="+Company+"&Trailer="+Trailer+"&Vehicle_Type="+Type+"&Service="+Service,
        success:function() {
          $('#Print_Ticket_Modal').modal({backdrop: 'static', keyboard: false, focus: true, show: true});
        }
      });
    }
  });
  //Account
  $(document).on('click', '#NT_Process_Account', function(){
    event.preventDefault();
    var ANPRKey = $('#NT_ANPRKey').val();
    var Plate = $('#NT_Vehicle_Plate').val();
    var Company = $('#NT_Company_Name').val();
    var Trailer = $('#NT_Vehicle_Trailer').val();
    var Type = $('#NT_Vehicle_Type').val();
    var Service = $('#NT_Payment_Service_Account').val();
    var Account_ID = $('#PM_Account_Select').val();
    if(Plate == "") {
      alert("A Vehicle registration is required!");
    } else if(Type === "unchecked") {
      alert("Vehicle Type is required!");
    } else if (Service === "unchecked") {
      alert("Payment Service is required!");
    } else if (Account_ID === "unchecked") {
      alert("Please select an Account");
    } else {
      //temp until response written
      jQuery(this).attr("id","DONE");
      $.ajax({
        url: "<?php echo URL?>/ajax-handler.php?handler=Transaction_Proccess_Account",
        type: "POST",
        data: "ANPRKey="+ANPRKey+"&Plate="+Plate+"&Company="+Company+"&Trailer="+Trailer+"&Vehicle_Type="+Type+"&Service="+Service+"&Account="+Account_ID,
        success:function() {
          $('#Print_Ticket_Modal').modal({backdrop: 'static', keyboard: false, focus: true, show: true});
        }
      });
    }
  });
  //SNAP
  $(document).on('click', '#NT_Process_SNAP', function(){
    event.preventDefault();
    var ANPRKey = $('#NT_ANPRKey').val();
    var Plate = $('#NT_Vehicle_Plate').val();
    var Company = $('#NT_Company_Name').val();
    var Trailer = $('#NT_Vehicle_Trailer').val();
    var Type = $('#NT_Vehicle_Type').val();
    var Service = $('#NT_Payment_Service_SNAP').val();
    if(Plate == "") {
      alert("A Vehicle registration is required!");
    } else if(Company == "") {
      alert("Company Name is required!");
    } else if(Type === "unchecked") {
      alert("Vehicle Type is required!");
    } else if (Service === "unchecked") {
      alert("Payment Service is required!");
    } else {
      //temp until response written
      jQuery(this).attr("id","DONE");
      $.ajax({
        url: "<?php echo URL?>/ajax-handler.php?handler=Transaction_Proccess_SNAP",
        type: "POST",
        data: "ANPRKey="+ANPRKey+"&Plate="+Plate+"&Company="+Company+"&Trailer="+Trailer+"&Vehicle_Type="+Type+"&Service="+Service,
        success:function(response) {
          if(response==1) {
            $('#Print_Ticket_Modal').modal({backdrop: 'static', keyboard: false, focus: true, show: true});
          } else {
            $('#WarningModal').modal({backdrop: 'static', keyboard: true, focus: true, show: true});
            $('#WarningInfo').html("SNAP have refused the transaction, please ensure all information is correct and try again, or seek alternative payment method.");
            $("#DONE").attr("id","NT_Process_SNAP");
          }
        }
      });
    }
  });
  //Fuel
  $(document).on('click', '#NT_Process_Fuel', function(){
    event.preventDefault();
    var ANPRKey = $('#NT_ANPRKey').val();
    var Plate = $('#NT_Vehicle_Plate').val();
    var Company = $('#NT_Company_Name').val();
    var Trailer = $('#NT_Vehicle_Trailer').val();
    var Type = $('#NT_Vehicle_Type').val();
    var Service = $('#NT_Payment_Service_Fuel').val();
    var FuelCardNo = $('#NT_FuelCard_Number').val();
    var CardExpiry = $('#NT_FuelCard_Date').val();
    if(Plate == "") {
      alert("A Vehicle registration is required!");
    } else if(Company == "") {
      alert("Company Name is required!");
    } else if(Type === "unchecked") {
      alert("Vehicle Type is required!");
    } else if (Service === "unchecked") {
      alert("Payment Service is required!");
    } else if (FuelCardNo === "") {
      alert("Please provide a valid card number");
    } else if (CardExpiry === "") {
      alert("Please provide a valid Expiry");
    } else {
      //temp until response written
      jQuery(this).attr("id","DONE");
      $.ajax({
        url: "<?php echo URL?>/ajax-handler.php?handler=Transaction_Proccess_Fuel",
        type: "POST",
        data: "ANPRKey="+ANPRKey+"&Plate="+Plate+"&Company="+Company+"&Trailer="+Trailer+"&Vehicle_Type="+Type+"&Service="+Service+"&FuelCardNo="+FuelCardNo+"&CardExpiry="+CardExpiry,
        success:function(response) {
          if(response==1) {
            $('#Print_Ticket_Modal').modal({backdrop: 'static', keyboard: false, focus: true, show: true});
          } else {
            $('#WarningModal').modal({backdrop: 'static', keyboard: true, focus: true, show: true});
            $('#WarningInfo').html("SNAP have refused the transaction, please ensure all information is correct and try again, or seek alternative payment method.");
            $("#DONE").attr("id","NT_Process_Fuel");
          }
        }
      });
    }
  });
  //Renewal
  //Cash
  $(document).on('click', '#T_Process_Cash', function(){
    event.preventDefault();
    var LogID = $('#NT_LogID').val();
    var ANPRKey = $('#NT_ANPRKey').val();
    var PayRef = $('#NT_PayRef').val();
    var Plate = $('#NT_Vehicle_Plate').val();
    var Company = $('#NT_Company_Name').val();
    var Trailer = $('#NT_Vehicle_Trailer').val();
    var Type = $('#NT_Vehicle_Type').val();
    var Service = $('#NT_Payment_Service_Cash').val();
    var Expiry = $('#NT_Expiry').val();
    if(Plate == "") {
      alert("A Vehicle registration is required!");
    } else if(Company == "") {
      alert("Company Name is required!");
    } else if(Type === "unchecked") {
      alert("Vehicle Type is required!");
    } else if (Service === "unchecked") {
      alert("Payment Service is required!");
    } else {
      jQuery(this).attr("id","DONE");
      $.ajax({
        url: "<?php echo URL?>/ajax-handler.php?handler=Transaction_Proccess_Cash_Renewal",
        type: "POST",
        data: "LogID="+LogID+"&ANPRKey="+ANPRKey+"&PayRef="+PayRef+"&Plate="+Plate+"&Company="+Company+"&Trailer="+Trailer+"&Vehicle_Type="+Type+"&Service="+Service+"&Expiry="+Expiry,
        success:function() {
          $('#Print_Ticket_Modal').modal({backdrop: 'static', keyboard: false, focus: true, show: true});
        }
      });
    }
  });
  //Card
  $(document).on('click', '#T_Process_Card', function(){
    event.preventDefault();
    var LogID = $('#NT_LogID').val();
    var ANPRKey = $('#NT_ANPRKey').val();
    var PayRef = $('#NT_PayRef').val();
    var Plate = $('#NT_Vehicle_Plate').val();
    var Company = $('#NT_Company_Name').val();
    var Trailer = $('#NT_Vehicle_Trailer').val();
    var Type = $('#NT_Vehicle_Type').val();
    var Service = $('#NT_Payment_Service_Card').val();
    var Expiry = $('#NT_Expiry').val();
    if(Plate == "") {
      alert("A Vehicle registration is required!");
    } else if(Company == "") {
      alert("Company Name is required!");
    } else if(Type === "unchecked") {
      alert("Vehicle Type is required!");
    } else if (Service === "unchecked") {
      alert("Payment Service is required!");
    } else {
      jQuery(this).attr("id","DONE");
      $.ajax({
        url: "<?php echo URL?>/ajax-handler.php?handler=Transaction_Proccess_Card_Renewal",
        type: "POST",
        data: "LogID="+LogID+"&ANPRKey="+ANPRKey+"&PayRef="+PayRef+"&Plate="+Plate+"&Company="+Company+"&Trailer="+Trailer+"&Vehicle_Type="+Type+"&Service="+Service+"&Expiry="+Expiry,
        success:function() {
          $('#Print_Ticket_Modal').modal({backdrop: 'static', keyboard: false, focus: true, show: true});
        }
      });
    }
  });
  //Account
  $(document).on('click', '#T_Process_Account', function(){
    event.preventDefault();
    var LogID = $('#NT_LogID').val();
    var ANPRKey = $('#NT_ANPRKey').val();
    var PayRef = $('#NT_PayRef').val();
    var Plate = $('#NT_Vehicle_Plate').val();
    var Company = $('#NT_Company_Name').val();
    var Trailer = $('#NT_Vehicle_Trailer').val();
    var Type = $('#NT_Vehicle_Type').val();
    var Service = $('#NT_Payment_Service_Account').val();
    var Account_ID = $('#PM_Account_Select').val();
    var Expiry = $('#NT_Expiry').val();
    if(Plate == "") {
      alert("A Vehicle registration is required!");
    } else if(Type === "unchecked") {
      alert("Vehicle Type is required!");
    } else if (Service === "unchecked") {
      alert("Payment Service is required!");
    } else if (Account_ID === "unchecked") {
      alert("Please select an Account");
    } else {
      //Temp
      jQuery(this).attr("id","DONE");
      $.ajax({
        url: "<?php echo URL?>/ajax-handler.php?handler=Transaction_Proccess_Account_Renewal",
        type: "POST",
        data: "LogID="+LogID+"&ANPRKey="+ANPRKey+"&PayRef="+PayRef+"&Plate="+Plate+"&Company="+Company+"&Trailer="+Trailer+"&Vehicle_Type="+Type+"&Service="+Service+"&Account="+Account_ID+"&Expiry="+Expiry,
        success:function() {
          $('#Print_Ticket_Modal').modal({backdrop: 'static', keyboard: false, focus: true, show: true});
        }
      });
    }
  });
  //Snap
  $(document).on('click', '#T_Process_SNAP', function(){
    event.preventDefault();
    var LogID = $('#NT_LogID').val();
    var ANPRKey = $('#NT_ANPRKey').val();
    var PayRef = $('#NT_PayRef').val();
    var Plate = $('#NT_Vehicle_Plate').val();
    var Company = $('#NT_Company_Name').val();
    var Trailer = $('#NT_Vehicle_Trailer').val();
    var Type = $('#NT_Vehicle_Type').val();
    var Service = $('#NT_Payment_Service_SNAP').val();
    var Expiry = $('#NT_Expiry').val();
    if(Plate == "") {
      alert("A Vehicle registration is required!");
    } else if(Company == "") {
      alert("Company Name is required!");
    } else if(Type === "unchecked") {
      alert("Vehicle Type is required!");
    } else if (Service === "unchecked") {
      alert("Payment Service is required!");
    } else {
      //temp
      jQuery(this).attr("id","DONE");
      $.ajax({
        url: "<?php echo URL?>/ajax-handler.php?handler=Transaction_Proccess_SNAP_Renewal",
        type: "POST",
        data: "LogID="+LogID+"&ANPRKey="+ANPRKey+"&PayRef="+PayRef+"&Plate="+Plate+"&Company="+Company+"&Trailer="+Trailer+"&Vehicle_Type="+Type+"&Service="+Service+"&Expiry="+Expiry,
        success:function(response) {
          if(response==1) {
            $('#Print_Ticket_Modal').modal({backdrop: 'static', keyboard: false, focus: true, show: true});
          } else {
            $('#WarningModal').modal({backdrop: 'static', keyboard: true, focus: true, show: true});
            $('#WarningInfo').html("SNAP have refused the transaction, please ensure all information is correct and try again, or seek alternative payment method.");
            $("#DONE").attr("id","T_Process_SNAP");
          }
        }
      });
    }
  });
  //Fuel
  $(document).on('click', '#T_Process_Fuel', function(){
    event.preventDefault();
    var LogID = $('#NT_LogID').val();
    var ANPRKey = $('#NT_ANPRKey').val();
    var PayRef = $('#NT_PayRef').val();
    var Plate = $('#NT_Vehicle_Plate').val();
    var Company = $('#NT_Company_Name').val();
    var Trailer = $('#NT_Vehicle_Trailer').val();
    var Type = $('#NT_Vehicle_Type').val();
    var Service = $('#NT_Payment_Service_Fuel').val();
    var Expiry = $('#NT_Expiry').val();
    var FuelCardNo = $('#NT_FuelCard_Number').val();
    var CardExpiry = $('#NT_FuelCard_Date').val();
    if(Plate == "") {
      alert("A Vehicle registration is required!");
    } else if(Company == "") {
      alert("Company Name is required!");
    } else if(Type === "unchecked") {
      alert("Vehicle Type is required!");
    } else if (Service === "unchecked") {
      alert("Payment Service is required!");
    } else if (FuelCardNo === "") {
      alert("Please provide a valid card number");
    } else if (CardExpiry === "") {
      alert("Please provide a valid Expiry");
    } else {
      //temp
      jQuery(this).attr("id","DONE");
      $.ajax({
        url: "<?php echo URL?>/ajax-handler.php?handler=Transaction_Proccess_Fuel_Renewal",
        type: "POST",
        data: "LogID="+LogID+"&ANPRKey="+ANPRKey+"&PayRef="+PayRef+"&Plate="+Plate+"&Company="+Company+"&Trailer="+Trailer+"&Vehicle_Type="+Type+"&Service="+Service+"&Expiry="+Expiry+"&FuelCardNo="+FuelCardNo+"&CardExpiry="+CardExpiry,
        success:function(response) {
          if(response==1) {
            $('#Print_Ticket_Modal').modal({backdrop: 'static', keyboard: false, focus: true, show: true});
          } else {
            $('#WarningModal').modal({backdrop: 'static', keyboard: true, focus: true, show: true});
            $('#WarningInfo').html("SNAP have refused the transaction, please ensure all information is correct and try again, or seek alternative payment method.");
            $("#DONE").attr("id","T_Process_Fuel");
          }
        }
      });
    }
  });
  //Account Edit Record Display
  $(document).on('click', '#Account_UpdateButton', function() {
    var Account_ID = $(this).data('id');
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=Account_Update_Get",
      type: "POST",
      data: {Acc_ID:Account_ID},
      dataType: "json",
      success:function(data) {
        $('#Update_Account_ID').val(data.id);
        $('#Update_Account_Name_Short').val(data.account_shortName);
        $('#Update_Account_Name').val(data.account_name);
        $('#Update_Account_Tel').val(data.account_contact_no);
        $('#Update_Account_Email').val(data.account_contact_email);
        $('#Update_Account_Billing_Email').val(data.account_billing_email);
        $('#Update_Account_Campus').val(data.campus);
        $('#Update_Account_Share').val(data.account_shared);
        $('#Update_AccountModal').modal('toggle');
      }
    })
  });
  //Account Record Update Save
  $(document).on('click', '#Update_Account_Save', function(){
    event.preventDefault();
    var Account_ID = $('#Update_Account_ID').val();
    var Name = $('#Update_Account_Name').val();
    var Short = $('#Update_Account_Name_Short').val();
    var Tel = $('#Update_Account_Tel').val();
    var Email = $('#Update_Account_Email').val();
    var Billing = $('#Update_Account_Billing_Email').val();
    var Campus = $('#Update_Account_Campus').val();
    var Share = $('#Update_Account_Share').val();
      $.ajax({
        url: "<?php echo URL?>/ajax-handler.php?handler=Account_Update_Save",
        type: "POST",
        data: "Acc_ID="+Account_ID+"&Name="+Name+"&Tel="+Tel+"&Email="+Email+"&Billing="+Billing+"&Site="+Campus+"&Share="+Share+"&short="+Short,
        success:function() {
          $('#Update_AccountModal').modal('toggle');
      }
    });
  });
  //Account Fleet View
  $(document).on('click', '#Account_UpdateFleetButton', function() {
    var Account_ID = $(this).data('id');
    $('#Account_ID').val(Account_ID);
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=Account_Fleet_Update_Get",
      type: "POST",
      data: {Acc_ID:Account_ID},
      dataType: "text",
      success:function(data) {
        $('#fleets').html(data);
        $('#Update_Account_FleetModal').modal('toggle');
      }
    })
  });
  //String Breakup for fuel card
  $(document).on('keyup', '#NT_Process_FuelStrip', function() {
    var FuelString = $(this).val();
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=ETP_CardBreak",
      type: "POST",
      data: {FuelString:FuelString},
      dataType: "json",
      success:function(data) {
        $("#NT_FuelCard_Number").val(data.cardno);
        $("#NT_FuelCard_Date").val(data.expiry);
      }
    })
  });
  //Save Account Info
  $(document).on('click', '#New_Account_Save', function(){
    event.preventDefault();
    var name = $('#New_Account_Name').val();
    var short = $('#New_Account_Name_Short').val();
    var tel = $('#New_Account_Tel').val();
    var email = $('#New_Account_Email').val();
    var billing = $('#New_Account_Billing_Email').val();
    var site = $('#New_Account_Campus').val();
    var shared = $('#New_Account_Share').val();
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=Account_Register",
      type: "POST",
      data: "name="+name+"&tel="+tel+"&email="+email+"&billing="+billing+"&site="+site+"&shared="+shared+"&short="+short,
      success:function() {
        document.getElementById("New_AccountModalForm").reset();
        $('#New_AccountModal').modal('toggle');
        $('#tables').load(' #tables');
      }
    })
  })
  //Account Record Update Save (AND AUTO-Re-Query data)
  $(document).on('submit', '#Update_AccountFleet', function(){
    event.preventDefault();
    var Account_ID = $('#Account_ID').val();
    var Plate = $('#Update_Account_Fleet_Plate').val();
      $.ajax({
        url: "<?php echo URL?>/ajax-handler.php?handler=Account_Fleet_Add",
        type: "POST",
        data: "Acc_ID="+Account_ID+"&Plate="+Plate,
        success:function() {
          $.ajax({
            url: "<?php echo URL?>/ajax-handler.php?handler=Account_Fleet_Update_Get",
            type: "POST",
            data: {Acc_ID:Account_ID},
            dataType: "text",
            success:function(data) {
              $('#fleets').html(data);
              document.getElementById("Update_AccountFleet").reset();
            }
          })
        }
    });
  });
  //Delete PAYMENT
  $(document).on('click', '#Payment_Delete_Submit', function() {
    event.preventDefault();
    var Payment_ID = $('#Payment_ID').val();
    var text = $('#Payment_Delete_Comment').val();
      if(text === "") {
        alert("Please provide a valid comment");
      } else {
        $.ajax({
          url: "<?php echo URL?>/ajax-handler.php?handler=Payment_Delete",
          type: "POST",
          data: "Pay_ID="+Payment_ID+"&Comment="+text,
          success:function() {
            document.getElementById("DeletePaymentForm").reset();
          }
        });
      }
  });
  //Print Ticket Modal Controller
  $(document).on('click', '#NT_Print_Ticket_Yes', function() {
    event.preventDefault();
    var ANPRKey = $('#NT_ANPRKey').val();
    var Plate = $('#NT_Vehicle_Plate').val();
    var DateIN = $('#NT_Date').val();
    var Company = $('#NT_Company_Name').val();
    $.ajax({
      url: "<?php echo URL?>/ajax-handler.php?handler=NT_Print_Ticket",
      type: "POST",
      data: "ANPRKey="+ANPRKey+"&Plate="+Plate+"&Date="+DateIN+"&Company="+Company,
      success:function() {
        window.location.replace("<?php echo URL?>/main");
      }
    });
  });
  //Print Ticket Modal Controller
  $(document).on('click', '#NT_Print_Ticket_No', function() {
    event.preventDefault();
    window.location.replace("<?php echo URL?>/main");
  });
  //Account Report Generate
  $(document).on('click', '#GenerateAccountReport', function() {
    event.preventDefault();
    var Account = $("#PM_Account_Select").val();
    var DateStart = $("#DateFrom").val();
    var DateEnd = $("#DateToo").val();
    if(Account == "unchecked") {
      alert("Please select an account");
    } else if(DateStart == "") {
      alert("Please pick a start date");
    } else if(DateEnd == "") {
      alert("Please pick an end date");
    } else {
      $.ajax({
        url: "<?php echo URL?>/ajax-handler.php?handler=Account_Report",
        type: "POST",
        data: "Account="+Account+"&DateStart="+DateStart+"&DateEnd="+DateEnd,
        success:function(data) {
          $('#result').html(data);
        }
      })
    }
  });
  //Account Report Generate
  $(document).on('click', '#Report_DownloadXLSX', function() {
    event.preventDefault();
    var Account = $("#PM_Account_Select").val();
    var DateStart = $("#DateFrom").val();
    var DateEnd = $("#DateToo").val();
    if(Account == "unchecked") {
      alert("Please select an account");
    } else if(DateStart == "") {
      alert("Please pick a start date");
    } else if(DateEnd == "") {
      alert("Please pick an end date");
    } else {
      $.ajax({
        url: "<?php echo URL?>/ajax-handler.php?handler=Report_DownloadXLSX",
        type: "POST",
        data: "Account="+Account+"&DateStart="+DateStart+"&DateEnd="+DateEnd,
        success:function(data) {
          $('#result').load(data);
        }
      })
    }
  });
  //Trans Log Generate
  $(document).on('click', '#TL_ViewSales', function() {
    event.preventDefault();
    var DateStart = $("#TL_DateStart").val();
    var DateEnd = $("#TL_DateEnd").val();
    var postData = $("#TL_Form").serialize();
    if(DateStart == "") {
      alert("Please pick a start date");
    } else if(DateEnd == "") {
      alert("Please pick an end date");
    } else {
      $.ajax({
        url: "<?php echo URL?>/ajax-handler.php?handler=Payment_Transaction_Log",
        type: "POST",
        data: postData,
        success:function(data) {
          $('#result').html(data);
        }
      })
    }
  });
  //Add Time to add ANPR modal
  $(document).on('click', '#AddANPRModal', function() {
    var d = new Date();
    var date = d.getFullYear()+'-'+(d.getMonth()+1)+'-'+d.getDate();
    var h = addZero(d.getHours());
    var m = addZero(d.getMinutes());
    var s = addZero(d.getSeconds());
    var datetime = date+' '+h+':'+m+':'+s;
    $('#ANPR_Add_Date').val(datetime);
  });
  //Change PW
  $(document).on('click', '#User_Change_PW_Confirm', function(){
    var data = $('#User_Change_PW_Form').serialize();
    var Pass1 = $('#User_New_Password').val();
    var Pass2 = $('#User_New_Password_Confirm').val();
    if(Pass1 === Pass2) {
      $.ajax({
        url: "<?php echo URL?>/ajax-handler.php?handler=Change_User_Password",
        type: "POST",
        data: data,
        success:function() {
          $('#User_Change_PW').modal('toggle');
        }
      })
    } else {
      alert("Are you sure those passwords match? Try again");
    }
  });
  //Update Exit
  $('#exitButton').click(function(){
    window.location.reload();
  })
  //Update Flag
  $('#flagButton').click(function(){
    window.location.reload();
  })
  //Update Delete
  $('#deleteButton').click(function(){
    window.location.reload();
  })
//Modal autofocus
  $('.modal').on('shown.bs.modal', function() {
    $(this).find('[autofocus]').focus();
  });
  //FOR DATE TIME ISSUE
  function addZero(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
  }
  //automate Exit x1min
  setInterval(function(){
    $.ajax({
      url: "<?php echo URL?>/ajax-handler?handler=Automation_Exit",
      type: "POST",
      success:function() {
        $('#tables').load(' #tables');
      }
    })
  }, 30000);

</script>
