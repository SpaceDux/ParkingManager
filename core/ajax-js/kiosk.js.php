<script type="text/javascript">
//Cancel
$(document).on('click', '#Cancel_Parking_S1_EN', function() {
  $('#Parking_Form_EN')[0].reset();
  $('#Parking_Page_EN').addClass("Hide");
  $('#Language_Select').removeClass("Hide");
});
$(document).on('click', '#Cancel_Parking_S2_EN', function() {
  $('#Parking_Form_EN')[0].reset();
  $('#Parking_Page_EN').addClass("Hide");
  $('#Stage2_EN').addClass("Hide");
  $('#Language_Select').removeClass("Hide");
});
$(document).on('click', '#Cancel_Parking_S3_EN', function() {
  $('#Parking_Form_EN')[0].reset();
  $('#Parking_Page_EN').addClass("Hide");
  $('#Stage3_EN').addClass("Hide");
  $('#Language_Select').removeClass("Hide");
});
$(document).on('click', '#Cancel_Parking_S4_EN', function() {
  $('#Parking_Form_EN')[0].reset();
  $('#Parking_Page_EN').addClass("Hide");
  $('#Stage4_EN').addClass("Hide");
  $('#Language_Select').removeClass("Hide");
});
$(document).on('click', '#Cancel_Parking_S5_EN', function() {
  $('#Parking_Form_EN')[0].reset();
  $('#Parking_Page_EN').addClass("Hide");
  $('#Stage5_EN').addClass("Hide");
  $('#Language_Select').removeClass("Hide");
});
$(document).on('click', '#Cancel_Parking_S6_EN', function() {
  $('#Parking_Form_EN')[0].reset();
  $('#Parking_Page_EN').addClass("Hide");
  $('#Stage6_EN').addClass("Hide");
  $('#Language_Select').removeClass("Hide");
});

//Parking Page NEXT
$(document).on('click', '#Next_Parking_S1_EN', function() {
  var Plate = $('#Kiosk_Plate').val();
  if(Plate == "") {
    $('#Kiosk_Plate').addClass("Warning");
  } else {
    $('#Stage1_EN').addClass("Hide");
    $('#Stage2_EN').removeClass("Hide");
  }
});
$(document).on('click', '#Next_Parking_S2_EN', function() {
  $('#Stage2_EN').addClass("Hide");
  $('#Stage3_EN').removeClass("Hide");
});
$(document).on('click', '#Next_Parking_S3_EN', function() {
  $('#Stage3_EN').addClass("Hide");
  $('#Stage4_EN').removeClass("Hide");
});
$(document).on('click', '#Next_Parking_S4_EN', function() {
  $('#Stage4_EN').addClass("Hide");
  $('#Stage5_EN').removeClass("Hide");
});
$(document).on('click', '#Next_Parking_S5_EN', function() {
  $('#Stage5_EN').addClass("Hide");
  $('#Stage6_EN').removeClass("Hide");
});
$(document).on('click', '#Next_Parking_S6_EN', function() {
  $('#Stage5_EN').addClass("Hide");
  $('#Stage6_EN').removeClass("Hide");
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
// }

// Functions {

$('#Kiosk_Plate').on('focus', function() {
  var Plate = $(this).val();
  if(Plate.length >= 4) {
    // $('#Kiosk_Search_Results').html('<img src="<?php echo URL?>/assets/img/loading.gif" style="margin-left: 40%;align: middle;max-width: 20%; max-height: 20%;"></img>');
    $.ajax({
      url: '<?php echo URL ?>/core/ajax/kiosk.ajax.php?handler=Kiosk_Plate_Search',
      method: "POST",
      data: {Plate:Plate},
      dataType: "json",
      success:function(result) {
        if(result.Type == "ANPR") {
          var Plate = result.Plate;
          $('#Kiosk_PM_Key').val("");
          $('#Kiosk_ANPR_Key').val(result.Uniqueref);

          $('#Kiosk_Search_Results').html('<h1>Success!</h1><p>We have found your vehicle <u><b>'+Plate+'</b></u><br>Press NEXT too continue.');
        } else if (result.Type == "PM") {
          var Plate = result.Plate;
          $('#Kiosk_ANPR_Key').val("");
          $('#Kiosk_PM_Key').val(result.Uniqueref);
          $('#Kiosk_Search_Results').html('<h1>Success!</h1><p>We have found your vehicle <u><b>'+Plate+'</b></u><br>Press NEXT too continue.');
        }
      }
    })
  } else if(Plate.length < 4) {
    $('#Kiosk_Search_Results').html('');
  }
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
