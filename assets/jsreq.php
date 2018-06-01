<!-- Menu Hide JS -->
<script type="text/javascript">
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
</script>
<!-- Chart JS -->
<script type="text/javascript">
var ctx = document.getElementById("lastChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
        datasets: [{
            label: 'This week',
            data: [200, 222, 100, 244, 66, 87, 110],
            borderWidth: [0],
            backgroundColor: [
                'rgba(255, 255, 255, 0.6)',
                'rgba(255, 255, 255, 0.6)',
                'rgba(255, 255, 255, 0.6)',
                'rgba(255, 255, 255, 0.6)',
                'rgba(255, 255, 255, 0.6)',
                'rgba(255, 255, 255, 0.6)',
                'rgba(255, 255, 255, 0.6)'
            ],
            borderColor: [
                'rgba(255, 255, 255, 1)',
                'rgba(255, 255, 255, 1)',
                'rgba(255, 255, 255, 1)',
                'rgba(255, 255, 255, 1)',
                'rgba(255, 255, 255, 1)',
                'rgba(255, 255, 255, 1)',
                'rgba(255, 255, 255, 1)'
            ],
        },
        {
          label: 'Last week',
          data: [123, 199, 97, 222, 88, 55, 32],
          borderWidth: [0],
          backgroundColor: [
              'rgba(104,104,104, 0.6)',
              'rgba(104,104,104, 0.6)',
              'rgba(104,104,104, 0.6)',
              'rgba(104,104,104, 0.6)',
              'rgba(104,104,104, 0.6)',
              'rgba(104,104,104, 0.6)',
              'rgba(104,104,104, 0.6)'
          ],
          borderColor: [
              'rgba(104,104,104, 1)',
              'rgba(104,104,104, 1)',
              'rgba(104,104,104, 1)',
              'rgba(104,104,104, 1)',
              'rgba(104,104,104, 1)',
              'rgba(104,104,104, 1)',
              'rgba(104,104,104, 1)'
          ]
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>
<!-- Focus on Modal -->
<script type="text/javascript">
$('.modal').on('shown.bs.modal', function() {
  $(this).find('[autofocus]').focus();
});
</script>
<!-- Ajax work -->
<script type="text/javascript">
//add vehicle modal data
function saveData(){
  var company = $('#addCompany').val();
  var reg = $('#addRegistration').val();
  var trlno = $('#addTrl').val();
  var type = $("#addType:checked").val();
  var timein = $('#addTimein').val();
  $.ajax({
  url: "<?php echo $url ?>/core/ajax.func.php?p=add",
  type: "POST",
  data: "company="+company+"&reg="+reg+"&trlno="+trlno+"&type="+type+"&timein="+timein
  })
  return false;
}
//Stop modal refreshing page on submit
$("#addVehicleForm").on("submit", function(e) {
  $("#addVehicleForm")[0].reset();
  $('#addVehicleModal').modal('toggle');
  $('#tables').load(' #tables');
});
//Add payments modal data
$('.payBtn').click(function(){
    var get_id=$(this).data('id');
    $('#veh_id').attr('value', get_id);
})
$('.payBtn2').click(function(){
    var get_id=$(this).data('id');
    $('#veh_id2').attr('value', get_id);
})
 function addPayments() {
  var veh_id = $('#veh_id').val();
  var tid = $('#tid').val();
  var tot = $('#tot').val();
  $.ajax({
   url: "<?php echo $url ?>/core/ajax.func.php?p=addPayment",
   type: "POST",
   data: "veh_id="+veh_id+"&tid="+tid+"&tot="+tot
  })
}
 function addPaymentsRenew() {
  var veh_id = $('#veh_id2').val();
  var tid = $('#tid2').val();
  var tot = $('#tot2').val();
  $.ajax({
   url: "<?php echo $url ?>/core/ajax.func.php?p=addPaymentRenew",
   type: "POST",
   data: "veh_id="+veh_id+"&tid="+tid+"&tot="+tot
  })
}
//Stop modal refresh on submit
$("#addPaymentForm").on("submit", function(e) {
  $("#addPaymentForm")[0].reset();
  $('#addPaymentModal').modal('toggle');
  $('#tables').load(' #tables');
});
$("#addPaymentFormRenew").on("submit", function(e) {
  $("#addPaymentFormRenew")[0].reset();
  $('#addPaymentModalRenew').modal('toggle');
  $('#tables').load(' #tables');
});
//Quick Exit
function quickExit(str) {
 var veh_id = str;
 $.ajax({
  url: "<?php echo $url ?>/core/ajax.func.php?p=quickExit",
  type: "POST",
  data: "veh_id="+veh_id
 })
 $('#tables').load(' #tables');
}
function markRenewal(str) {
 var veh_id = str;
 $.ajax({
  url: "<?php echo $url ?>/core/ajax.func.php?p=markRenewal",
  type: "POST",
  data: "veh_id="+veh_id
 })
 $('#tables').load(' #tables');
}
function setFlag(str) {
 var veh_id = str;
 $.ajax({
  url: "<?php echo $url ?>/core/ajax.func.php?p=setFlag",
  type: "POST",
  data: "veh_id="+veh_id
 })
 $('#tables').load(' #tables');
}
function unsetFlag(str) {
 var veh_id = str;
 $.ajax({
  url: "<?php echo $url ?>/core/ajax.func.php?p=unsetFlag",
  type: "POST",
  data: "veh_id="+veh_id
 })
 $('#tables').load(' #tables');
}
</script>
