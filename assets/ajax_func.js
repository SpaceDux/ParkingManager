<!-- Vehicle Exit Ajax -->
function exit(str) {
  var veh_id = str;
  $.ajax({
    url: URL."/core/ajax.php?p=exit",
    type: "POST",
    data: "veh_id"+veh_id
  })
  $('#tables').load(' #tables');
}
