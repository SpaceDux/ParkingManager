$(document).ready(function(res) {
  anprFeed(function(res) {
    $('#ANPR_Feed').html(res);
  });
});
function anprFeed(callback)
{
  var data = [];
  getSite(session.getItem("Site"), function(res) {
    var parse = JSON.parse(res);
    var dbConfig = {
      server: parse.ANPR_IP,
      authentication: {
        type: "default",
        options: {
          userName: parse.ANPR_User,
          password: parse.ANPR_Password,
          database: parse.ANPR_DB,
          rowCollectionOnRequestCompletion: true
        }
      }
    };
    var Connection = require('tedious').Connection;
    const Request = require('tedious').Request;

    var connection = new Connection(dbConfig);
    connection.on('connect', function(err) {
      // If no error, then good to go...
      request = new Request("SELECT TOP 200 * FROM ANPR_REX WHERE Lane_ID = 1 AND Status < 10 ORDER BY Capture_Date DESC", function(err, rowCount, rows) {
       if (err) {
         console.log(err);
       } else {
         console.log(rowCount + ' rows');
       }
     });
     request.on('row', function(rows) {
       data.push('<table class="table table-dark"><thead><tr><th scope="col">#</th><th scope="col">First</th><th scope="col">Last</th><th scope="col">Handle</th></tr></thead><tbody>');
       rows.forEach(function(row) {
         data.push('<tr>'+
                       '<td>'+row.Plate+'</td>'+
                       '<td>LOL</td>'+
                     '</tr>');
       });

       callback(data);
    });

    connection.execSql(request);
    });
  });
}
