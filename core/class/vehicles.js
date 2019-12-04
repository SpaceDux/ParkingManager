$(document).ready(function(e) {
  anprFeed(function(res) {

  });
})
function anprFeed(callback)
{
  getSite(session.getItem("Site"), function(res) {
    var parse = JSON.parse(res);
    async () => {
      try {
        // make sure that any items are correctly URL encoded in the connection string
        await mssql.connect('mssql://'+parse.ANPR_User+':'+parse.ANPR_Password+'@'+parse.ANPR_IP+'/'+parse.ANPR_DB+'')
        const result = await mssql.query("SELECT TOP 100 * FROM ANPR_REX WHERE Lane_ID = 1 ORDER BY Capture_Date DESC");
        console.log(result);
        alert(result);

      } catch (err) {
        console.log(err);
      }
    }
  });
}
