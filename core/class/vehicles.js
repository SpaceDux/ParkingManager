// Vehicle Feeds on Document.load
$(document).ready(function() {
  vehicles_ANPR_Feed(function(callback) {
    $('#ANPR_Feed').html(callback);
  });
});
function vehicles_ANPR_Feed(callback, error)
{
  var moment = require('moment');

  getSite(session.getItem("Site"), function(res) {
   var parse = JSON.parse(res);
   var con = new mssql.ConnectionPool({user: parse.ANPR_User, password: parse.ANPR_Password, server: parse.ANPR_IP, database: parse.ANPR_DB});
   var req = new mssql.Request(con);
   con.connect(function(err) {
     if (err) {
       alert("MSSQL: "+err);
       callback('');
       return;
     }

     req.query("SELECT TOP 200 * FROM ANPR_REX WHERE Lane_ID = 1 AND Status < 10 ORDER BY Capture_Date DESC", function(err, data) {
       if (err) {
         alert("MSSQL: "+err);
         callback('');
         return;
       }
       if(data.rowsAffected[0] > 0) {
         var thead = '<table class="table table-dark table-hover table-bordered"><thead><tr><th>Plate</th><th>Patch</th><th>Arrival</th><th><i class="fa fa-cogs"></i></th></thead><tbody>';
         var tfoot = '</tbody></table>';
         var feed = '';
         data.recordset.forEach(function(row) {
           var capdate = moment(row.Capture_Date);
           var curTime = moment();
           var stay = curTime.diff(capdate, "hours");
           var patch = row.Patch;
           var distime =  moment(capdate).format("DD/HH:mm");
           if(patch !== null) {
             var correct_patch = patch.replace('D:\\ETP ANPR\\images\\', 'file://Z:/');
             var final_patch = correct_patch.replace(/\\/g, '/');
           } else {
             var final_patch = '';
           }
           if(stay >= 2 && stay < 4) {
             feed += '<tr class="table-warning" style="color:black;"><td>'+row.Plate+'</td>'+
             '<td><img style="max-width: 120px; max-height: 50px;" src="'+final_patch+'"></img></td>'+
             '<td>'+distime+'</td>'+
             '<td>'+
             '<div class="btn-group" role="group">'+
             '<button type="button" class="btn btn-danger"><i class="fa fa-cog"></i></button>'+
             '<button type="button" class="btn btn-danger"><i class="fa fa-pound-sign"></i></button>'+
             '<button type="button" class="btn btn-danger"><i class="fa fa-times"></i></button>'+
             '</div>'
             +'</td>';
           } else if(stay >= 4) {
             feed += '<tr class="table-danger" style="color:black;"><td>'+row.Plate+'</td>'+
             '<td><img style="max-width: 120px; max-height: 50px;" src="'+final_patch+'"></img></td>'+
             '<td>'+distime+'</td>'+
             '<td>'+
             '<div class="btn-group" role="group">'+
             '<button type="button" class="btn btn-danger"><i class="fa fa-cog"></i></button>'+
             '<button type="button" class="btn btn-danger"><i class="fa fa-pound-sign"></i></button>'+
             '<button type="button" class="btn btn-danger"><i class="fa fa-times"></i></button>'+
             '</div>'
             +'</td>';
           } else {
             feed += '<tr><td>'+row.Plate+'</td>'+
             '<td><img style="max-width: 120px; max-height: 50px;" src="'+final_patch+'"></img></td>'+
             '<td>'+distime+'</td>'+
             '<td>'+
             '<div class="btn-group" role="group">'+
             '<button type="button" class="btn btn-danger"><i class="fa fa-cog"></i></button>'+
             '<button type="button" class="btn btn-danger"><i class="fa fa-pound-sign"></i></button>'+
             '<button type="button" class="btn btn-danger"><i class="fa fa-times"></i></button>'+
             '</div>'
             +'</td>';
           }
         });
         callback(thead+feed+tfoot);
       } else {
         callback('<p><center>No records found.</center></p>');
       }
       con.close();
     });

   });

 });
}
