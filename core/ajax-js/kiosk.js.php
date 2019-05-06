<script type="text/javascript">
//Cancel
$(document).on('click', '#Cancel_Parking_S1_EN', function() {
  $('#Parking_Form_EN')[0].reset();
  $('#Parking_Page_EN').addClass("Hide");
  $('#Language_Select').removeClass("Hide");

  $('.Info').html("");
});
$(document).on('click', '#Cancel_Parking_S2_EN', function() {
  $('#Parking_Form_EN')[0].reset();
  $('#Parking_Page_EN').addClass("Hide");
  $('#Stage2_EN').addClass("Hide");
  $('#Language_Select').removeClass("Hide");

  $('.Info').html("");
});
$(document).on('click', '#Cancel_Parking_S3_EN', function() {
  $('#Parking_Form_EN')[0].reset();
  $('#Parking_Page_EN').addClass("Hide");
  $('#Stage3_EN').addClass("Hide");
  $('#Language_Select').removeClass("Hide");

  $('.Info').html("");
});
$(document).on('click', '#Cancel_Parking_S4_EN', function() {
  $('#Parking_Form_EN')[0].reset();
  $('#Parking_Page_EN').addClass("Hide");
  $('#Stage4_EN').addClass("Hide");
  $('#Language_Select').removeClass("Hide");

  $('.Info').html("");
});
$(document).on('click', '#Cancel_Parking_S5_EN', function() {
  $('#Parking_Form_EN')[0].reset();
  $('#Parking_Page_EN').addClass("Hide");
  $('#Stage5_EN').addClass("Hide");
  $('#Language_Select').removeClass("Hide");

  $('.Info').html("");
});
$(document).on('click', '#Cancel_Parking_S6_EN', function() {
  $('#Parking_Form_EN')[0].reset();
  $('#Parking_Page_EN').addClass("Hide");
  $('#Stage6_EN').addClass("Hide");
  $('#Language_Select').removeClass("Hide");

  $('.Info').html("");
});
$(document).on('click', '#Cancel_Parking_S7_EN', function() {
  $('#Parking_Form_EN')[0].reset();
  $('#Parking_Page_EN').addClass("Hide");
  $('#Stage7_EN').addClass("Hide");
  $('#Language_Select').removeClass("Hide");

  $('.Info').html("");
});

//Parking Page NEXT
$(document).on('click', '#Next_Parking_S1_EN', function() {
  var Plate = $('#Kiosk_Plate').val();
  if(Plate == "") {
    $('#Kiosk_Plate').addClass("Warning");
  } else {
    $.ajax({
      url: "<?php echo URL ?>/core/ajax/kiosk.ajax.php?handler=Kiosk_Search",
      type: "POST",
      data: {Plate:Plate},
      dataType: "json",
      success:function(data) {
        if(data != "FALSE") {
          // Determines IS ANPR
          if(data.Type == "1") {
            console.log(data);
            $('#Kiosk_System').val(data.Type);
            $('#Kiosk_ID').val(data.id);
            $('#Stage1_EN').addClass("Hide");
            $('#Stage2_EN').removeClass("Hide");
            $('#Kiosk_Plate').removeClass("Warning");
          // Determines IS PM, allow renewal payment
          } else if(data.Type == "2") {
            console.log(data);
            $('#Kiosk_System').val(data.Type);
            $('#Kiosk_ID').val(data.id);
            $('#Stage1_EN').addClass("Hide");
            $('#Stage2_EN').removeClass("Hide");
            $('#Kiosk_Plate').removeClass("Warning");
          } else if (data.Type == "3") {
            //Renewal
            console.log(data);
            $('#Kiosk_System').val(data.Type);
            $('#Kiosk_ID').val(data.id);
            $('#Stage1_EN').addClass("Hide");
            $('#Stage2_EN').removeClass("Hide");
            $('#Kiosk_Plate').removeClass("Warning");
          } else {
            $('.Info').html("<B>Sorry, we can't find your vehicle in our system, please check and ensure your information is correct, if this issue persists please seek assistance from a member of staff.</B>");
          }
        }
      }
    })
  }
});
$(document).on('click', '#Next_Parking_S2_EN', function() {
  $('#Stage2_EN').addClass("Hide");
  $('#Stage3_EN').removeClass("Hide");
  $('#Kiosk_Plate').removeClass("Warning");
  $('.Info').html("");
});
$(document).on('click', '#Next_Parking_S3_EN', function() {
  $('#Stage3_EN').addClass("Hide");
  $('#Stage4_EN').removeClass("Hide");
  $('#Payment_Types_EN').html('<img src="<?php echo URL?>/assets/img/loading2.gif" style="width: 300px;margin: 0 auto;display:block;"></img>');
  var Data = $('#Parking_Form_EN').serialize();
  $.ajax({
    url: "<?php echo URL ?>/core/ajax/kiosk.ajax.php?handler=Kiosk_GET_PaymentTypes",
    type: "POST",
    data: Data,
    dataType: "text",
    success:function(res) {
      $('#Payment_Types_EN').html(res);
    }
  })
});
$(document).on('click', '#Next_Parking_S4_EN', function() {
  var radios = $('input[name="Kiosk_PayType"]:checked').val();
  if(radios == null) {
    $('.Info').html('<div class="alert alert-danger" role="alert"><b>OOPS: </b>Please select a payment type.</div>');
  } else {
    $('#Stage4_EN').addClass("Hide");
    $('#Payment_Services_EN').html('<img src="<?php echo URL?>/assets/img/loading2.gif" style="width: 300px;margin: 0 auto;display:block;"></img>');
    var Data = $('#Parking_Form_EN').serialize();
    $.ajax({
      url: "<?php echo URL ?>/core/ajax/kiosk.ajax.php?handler=Kiosk_GET_PaymentServices",
      type: "POST",
      data: Data,
      dataType: "text",
      success:function(res) {
        $('#Payment_Services_EN').html(res);
      }
    })
    $('.Info').html("");
    $('#Stage5_EN').removeClass("Hide");
  }
});
$(document).on('click', '#Next_Parking_S5_EN', function() {
  var radios = $('input[name="Kiosk_Service"]:checked').val();
  if(radios == null) {
    $('.Info').html('<div class="alert alert-danger" role="alert"><b>OOPS: </b>Please select the service you require.</div>');
  } else {
    $('#Stage5_EN').addClass("Hide");
    var Data = $('#Parking_Form_EN').serialize();
    $('#Confirm_EN').html('<img src="<?php echo URL?>/assets/img/loading2.gif" style="width: 300px;margin: 0 auto;display:block;"></img>');
    $.ajax({
      url: "<?php echo URL ?>/core/ajax/kiosk.ajax.php?handler=Kiosk_ConfirmInfo",
      type: "POST",
      data: Data,
      dataType: "text",
      success:function(res) {
        $('#Confirm_EN').html(res);
      }
    });
    $('.Info').html("");
    $('#Stage6_EN').removeClass("Hide");
  }
});
$(document).on('click', '#Next_Parking_S6_EN', function() {
  var Data = $('#Parking_Form_EN').serialize();
  if($('input[name="Kiosk_PayType"]:checked').val() == "5") {
    $('#Stage6_EN').addClass("Hide");
    $('#Stage7_EN').removeClass("Hide");
    $('#Kiosk_FuelCard').focus();
  } else {
    $.ajax({
      url: "<?php echo URL ?>/core/ajax/kiosk.ajax.php?handler=Kiosk_Begin_Parking_Transaction",
      type: "POST",
      data: Data,
      dataType: "text",
      success:function(res) {
        $('#Stage6_EN').addClass("Hide");
        $('#Accepted_EN').removeClass("Hide");
        setTimeout(function() {
          $('#Parking_Form_EN')[0].reset();
          $('#Parking_Page_EN').addClass("Hide");
          $('#Accepted_EN').addClass("Hide");
          $('#Language_Select').removeClass("Hide");
          $('.Info').html("");
        }, 10000);
      }
    });
  }
});

//Time
setInterval(function() {
  $('#Time').load(' #Time');
}, 30000);

// Language Tiles {
$(document).on('click', '#English', function() {
  $('#Tiles_EN').removeClass("Hide");
  $('#Language_Select').addClass("Hide");
});
// } end of Language tiles

// Tiles {
$(document).on('click', '#Parking_Tile_EN', function() {
  $('#Tiles_EN').addClass("Hide");
  $('#Parking_Page_EN').removeClass("Hide");
  $('#Stage1_EN').removeClass("Hide");
});
//Wash
$(document).on('click', '#Wash_Tile_EN', function() {
  alert("YOU CLICKED WASH");
});
//Exchange
$(document).on('click', '#Exchange_Tile_EN', function() {
  alert("YOU CLICKED EXCHANGE");
});
// } end of Tiles

// Custom Pages {
$('#Parking_Form_EN').on('submit', function() {
  event.preventDefault();
});
// Functions {
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
// }

//TextBoxes {
$('#Kiosk_Plate').keyboard({
	layout:[
		[['1','1'],['2','2'],['3','3'],['4','4'],['5','5'],['6','6'],['7', '7'],['8','8'],['9','9'],['0','0'],['del','DEL']],
		[['Q','Q'], ['W','W'], ['E','E'],['R','R'],['T','T'],['Y','Y'],['U','U'],['I','I'],['O','O'],['P','P']],
		[['A','A'],['S','S'],['D','D'],['F','F'],['G','G'],['H','H'],['J','J'],['K','K'],['L','L']],
		[['Z','Z'],['X','X'],['C','C'],['V','V'],['B','B'],['N','N'],['M', 'M']]
	]
});

// } end of Textboxes
</script>
