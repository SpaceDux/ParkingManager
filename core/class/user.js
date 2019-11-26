function user_LoggedIn()
{
  var session = sessionStorage;
  if(session.getItem("User_ID") != null) {
    return "TRUE";
  } else {
    return "FALSE";
    console.warn("Session is not set, user will now be redirected to Auth.");
  }
}
function user_CreateSession(id, name)
{
  sessionStorage.setItem("User_ID", id);
  sessionStorage.setItem("Name", name);
  window.location.replace("index.html");
}
function user_Login(email, password)
{
  var connection = mysql.createConnection({
      host: config.MySQL.Host,
      user: config.MySQL.User,
      password: config.MySQL.Pass,
      database: config.MySQL.Database
  });
  connection.connect();

  connection.query("SELECT * FROM users WHERE Email = ? AND Status < 1", [1, email], function(error, result, fields) {
    if (error) throw error;
    if(result.length < 1) {
      console.log("TRUE");
    } else {
      console.log("FALSE");
    }
  });
}
