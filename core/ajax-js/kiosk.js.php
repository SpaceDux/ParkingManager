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

//TextBoxes {
$('#Kiosk_Plate').keyboard({
	layout:[
		[['1','1'],['2','2'],['3','3'],['4','4'],['5','5'],['6','6'],['7', '7'],['8','8'],['9','9'],['0','0']],
		[['A','A'],['B','B'],['C','C'],['D','D'],['E','E'],['F','F'],['G','G'],['H','H'],['I','I'],['J','J']],
		[['K','K'],['L','L'],['M','M'],['N','N'],['O','O'],['P','P'],['Q','Q'],['R','R'],['S','S'],['T','T']],
		[['U','U'],['V','V'],['W','W'],['X','X'],['Y','Y'],['Z','Z'],['del', 'DEL']]
	]
});
// } end of Textboxes
</script>
