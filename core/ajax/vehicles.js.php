<script type="text/javascript">
  $(document).ready(function() {
    // Get list of plates display via tbl
    function Vehicles_MyPlatesAsTbl() {
      $('#MYPLATES-TABLE').html('<img src="{URL}/template/{TPL}/img/loading.gif" style="margin: 0 auto;display: block;" alt="Loading"></img>');
      $.ajax({
        url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.Vehicles_MyPlatesAsTbl",
        method: "POST",
        dataType: "json",
        success:function(Response)
        {
          $('#MYPLATES-TABLE').html(Response);
        }
      });
      return false;
    }
    Vehicles_MyPlatesAsTbl();
  // Add plates via form on my accounts
  $(document).on('submit', '#AddPlates', function() {
    event.preventDefault();
    var Data = $(this).serialize();
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.Vehicles_AddPlate",
      data: Data,
      method: "POST",
      dataType: "json",
      success:function(Response) {
        if(Response.Result < 1) {
          $('#AddPlate_Error').html('<div class="alert alert-danger">'+Response.Message+'</div>');
        } else {
          Vehicles_MyPlatesAsTbl();
          $('#AddPlate_Error').html('<div class="alert alert-success">'+Response.Message+'</div>');
        }
      }
    })
    return false;
    });
  });
  // Duplicate to ensure its available to all funcs
  function Vehicles_MyPlatesAsTbl2() {
    $('#MYPLATES-TABLE').html('<img src="{URL}/template/{TPL}/img/loading.gif" style="margin: 0 auto;display: block;" alt="Loading"></img>');
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.Vehicles_MyPlatesAsTbl",
      method: "POST",
      dataType: "json",
      success:function(Response)
      {
        $('#MYPLATES-TABLE').html(Response);
      }
    });
    return false;
  }
  // Delete plate on click from my account
  function Vehicles_DeletePlate(Ref) {
    event.preventDefault();
    $.ajax({
      url: "{URL}/core/ajax/vehicles.handler.php?handler=Vehicles.Vehicles_DeletePlate",
      data: {Ref:Ref},
      method: "POST",
      dataType: "json",
      success:function(Response) {
        if(Response.Result < 1) {
          $('#AddPlate_Error').html('<div class="alert alert-danger">'+Response.Message+'</div>');
        } else {
          Vehicles_MyPlatesAsTbl2();
          $('#AddPlate_Error').html('<div class="alert alert-success">'+Response.Message+'</div>');
        }
      }
    })
    return false;
  }
</script>
