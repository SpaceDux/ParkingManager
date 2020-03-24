// Get Site information via Uniqueref
function getSite(id, callback)
{
  var connection = mysql.createConnection({
      host: config.MySQL.Host,
      user: config.MySQL.User,
      password: config.MySQL.Pass,
      database: config.MySQL.Database
  });
  connection.query("SELECT * FROM sites WHERE Uniqueref = ? LIMIT 1", [id], function(error, result, fields) {
    if(error) throw error;
    if(result.length > 0) {
      callback(JSON.stringify(result[0]));
    }
  });
  connection.end();
}
// Full window loading
window.addEventListener("load", function() {
  document.getElementsByClassName('Loader');
  $('.Loader').addClass('Hidden');
});
// Change page
function settings_pageContent(page)
{
  $('.Loader-page').removeClass('Hidden');
  // Selected page
  if(page == "home") {
    // run required, begin preload.
    $('#PageDisplay').load("../pages/content/home-page.html");
    // Run functions
    // Get ANPR
    vehicles_ANPR_Feed(function(callback) {
      $('#ANPR_Feed').html(callback);
      // Get all vehicles
      
      $('.Loader-page').addClass('Hidden');
    });
  }
}
