<script type="text/javascript">
  // Choose a site through dropdown menu, allocate space
  $(document).on('submit', '#Booking_BookSiteModalForm', function() {
    event.preventDefault();

    var Site = $('#Booking_BookSite').val();
    if(Site == 0) {
      $('#Booking_BookSiteModalForm_Error').html('<div class="alert alert-danger">Please select a site.</div>')
    } else {
      $.ajax({
        url: "{URL}/core/ajax/booking.handler.php?handler=Booking.Booking_AllocateBayTemp",
        data: {Site:Site},
        method: "POST",
        dataType: "json",
        success:function(Response) {
          if(Response.Result < 1) {
            $('#Booking_BookSiteModalForm_Error').html('<div class="alert alert-danger">'+Response.Message+'</div>');
          } else {
            $('#Booking_BookSiteModal').modal('hide');
            $('#Booking_BookModal_Note').html('<div class="alert alert-success">'+Response.Message+'</div>');
            $('#Booking_BookModal').modal('show');
          }
        }
      });
    }
    return false;
  })
  // Send Booking to server
  $(document).on('submit', '#Booking_BookModalForm', function() {
    event.preventDefault();
    var Data = $('#Booking_BookModalForm').serialize();
    $.ajax({
      url: "{URL}/core/ajax/booking.handler.php?handler=Booking.Booking_Create_Booking",
      data: Data,
      method: "POST",
      dataType: "json",
      success:function(Response) {
        if(Response.Result < 1) {
          $('#Booking_BookModal_Error').html('<div class="alert alert-danger">'+Response.Message+'</div>');
        } else {
          $('#Booking_BookModal').modal('hide');
          $('#Booking_Confirmation_Note').html('<div class="alert alert-success">'+Response.Message+'</div>');
          $('#Booking_BookTCSModal').modal('show');
        }
      }
    });
    return false;
  })
  // Cancel a booking
  function Booking_Cancel(Ref)
  {
    event.preventDefault();
    $('#Booking_CancelModal').modal('show');
    $('#Booking_Cancelled_Note').html('<p>Are you sure you want to cancel this booking?</p>');

    $('#Booking_CancelModal_YES').on('click', function() {
      $.ajax({
        url: "{URL}/core/ajax/booking.handler.php?handler=Booking.Booking_CancelBooking",
        data: {Ref:Ref},
        method: "POST",
        dataType: "json",
        success:function(Response) {
          if(Response.Result < 1) {
            $('#Booking_Cancelled_Note').html('<div class="alert alert-danger">'+Response.Message+'</div>');
          } else {
            $('#Booking_CancelModal').modal('hide');
            $('#Booking_CancelledConfirm_Note').html('<div class="alert alert-success">'+Response.Message+'</div>');
            $('#Booking_CancelConfirmModal').modal('show');
          }
        }
      });
    })
  }
  // Cancel booking midway, reopen bay
  function Booking_MidwayCancel()
  {
    $.ajax({
      url: "{URL}/core/ajax/booking.handler.php?handler=Booking.Booking_MidwayCancel",
      method: "POST",
      dataType: "json",
      success:function(Response) {
        if(Response.Result < 1) {
          $('#Booking_Confirmation_Note').html('<div class="alert alert-danger">'+Response.Message+'</div>');
        } else {
          $('#Booking_BookModal').modal('hide');
          // $('#Booking_Cancelled_Note').html('<div class="alert alert-success">'+Response.Message+'</div>');
          // $('#Booking_CancelModal').modal('show');
        }
      }
    });
  }
</script>
