<script type="text/javascript">
  //Payment Add Service
  $(document).on('click', '#Payment_Service_Save', function() {
    var Data = $("#Payment_Service_AddForm").serialize();
    $.ajax({
      url: "<?php echo URL?>/core/ajax/payment.ajax.php?handler=Payment_Add_Service",
      type: "POST",
      data: Data,
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
    var id = $(this).data('id');
    $.ajax({
      url: "<?php echo URL?>/core/ajax/payment.ajax.php?handler=Payment_Service_Update_GET",
      type: "POST",
      data: {id:id},
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
        $('#Service_Group_Update').val(data.service_group);
        $('#Service_ETPID_Update').val(data.service_etpid);
        $('#Service_Active_Update').val(data.service_active);
        $('#Service_Discount_Amount_Update').val(data.service_discount_amount);
        $('#Service_WiFi_Amount_Update').val(data.service_wifi_amount);
        $('#Payment_Service_UpdateModal').modal('toggle');
      }
    })
  });
  //Payment Service Update
  $(document).on('click', '#Payment_Service_Update', function() {
    var Data = $('#Payment_Service_UpdateForm').serialize();
    $.ajax({
      url: "<?php echo URL?>/core/ajax/payment.ajax.php?handler=Payment_Service_Update",
      data: Data,
      type: "POST",
      success:function() {
        $('#tables').load(' #tables');
        $('#Payment_Service_UpdateModal').modal('toggle');
        $('#Payment_Service_UpdateForm')[0].reset();
      }
    })
    event.preventDefault();
    return false;
  });
</script>
