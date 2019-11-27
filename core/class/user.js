function user_LoggedIn()
{
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

function user_Login(email, password, callback)
{
  var bcrypt = require('bcryptjs');
  var connection = mysql.createConnection({
      host: config.MySQL.Host,
      user: config.MySQL.User,
      password: config.MySQL.Pass,
      database: config.MySQL.Database
  });
  connection.connect();

  connection.query("SELECT * FROM users WHERE Email = ? AND Status < 1 LIMIT 1", [email], function(error, result, fields) {
    if (error) throw error;
    if(result.length > 0) {
      var pass = result[0].Password;
      bcrypt.compare(password, pass, function(err, res) {
        if(err) throw err;
        if(res === true) {
          console.log("Passwords match, setting user session.");
          user_CreateSession(result[0].Uniqueref, result[0].FirstName+" "+result[0].LastName);
        } else {
          var responseData = {};
          responseData["Status"] = "0";
          responseData["Message"] = "Your password do not match our records.";
          console.log("Passwords don't match.");
          // Callback Handler
          if(typeof callback == 'function')
          {
            callback(responseData);
          }
        }
      });
    } else {
      var responseData = {};
      responseData["Status"] = "0";
      responseData["Message"] = "We can't find an account associated with that email address, please check & try again.";
      console.log("We can't find an account with that email address.");
    }
    // Callback Handler
    if(typeof callback == 'function')
    {
      callback(responseData);
    }
  });
}
