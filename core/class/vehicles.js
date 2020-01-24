function ANPR_Feed(callback)
{
  getSite(session.getItem("Site"), function(res) {
   var parse = JSON.parse(res);
   var con = new mssql.ConnectionPool({user: parse.ANPR_User, password: parse.ANPR_Password, server: parse.ANPR_IP, database: parse.ANPR_DB});
   var req = new mssql.Request(con);
   con.connect(function(err) {
     if (err) {
       alert("MSSQL: "+err);
       return;
     }

     req.query("SELECT TOP 200 * FROM ANPR_REX WHERE Lane_ID = 1 AND Status < 10 ORDER BY Capture_Date ASC", function(err, data) {
       if (err) {
         alert("MSSQL: "+err);
         return;
       }
       console.log("ANPR Rows: "+data.rowsAffected[0]);
       var thead = '<table class="table table-dark table-hover table-bordered"><thead><tr><th>Plate</th><th>Patch</th><th>Arrival</th><th>COG</th></thead><tbody>';
       var tfoot = '</tbody></table>';
       var feed = '';
       console.log(data);
       data.recordset.forEach(function(row) {
         feed += '<tr><td>'+row.Plate+'</td>'+
         // '<td><img src="'+row.Patch+'"></img></td>'+
         '<td><img src=""></img></td>'+
         '<td>'+row.Capture_Date+'</td>'+
         '<td>OPT</td>';
       });
       callback(thead+feed+tfoot);
       con.close();
     });

   });

 });
}
