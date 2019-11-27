function user_LoggedIn()
{
  if(session.getItem("User_ID") != null) {
    return "TRUE";
  } else {
    return "FALSE";
    console.warn("Session is not set, user will now be redirected to Auth.");
  }
}
// Begin User Authetication.
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

  connection.query("SELECT * FROM users WHERE Email = ? LIMIT 1", [email], function(error, result, fields) {
    if (error) throw error;
    if(result.length > 0) {
      if(result[0].Status < 1) {
        var pass = result[0].Password;
        bcrypt.compare(password, pass, function(err, res) {
          if(err) throw err;
          if(res === true) {
            // Return Response Callback
            var responseData = {};
            responseData["Status"] = "1";
            responseData["Message"] = "Successfully logged in. You will be redirected in 3 seconds...";
            console.log("Passwords match, Setting user session.");
            // Set session
            sessionStorage.setItem("User_ID", result[0].Uniqueref);
            sessionStorage.setItem("Name", result[0].FirstName+' '+result[0].LastName);
            setTimeout(function() {
              window.location.replace("index.html");
            }, 3000);
            // Callback Handler
            if(typeof callback == 'function')
            {
              callback(responseData);
            }
          } else {
            var responseData = {};
            responseData["Status"] = "0";
            responseData["Message"] = "Your password does not match our records.";
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
        responseData["Message"] = "Your account has been suspended. Please contact management.";
        console.warn("Your account has been suspended. Please contact management.");
        // Callback Handler
        if(typeof callback == 'function')
        {
          callback(responseData);
        }
      }
    } else {
      var responseData = {};

      responseData["Status"] = "0";
      responseData["Message"] = "We can't find an account associated with that email address, please check & try again.";
      console.log("We can't find an account with that email address.");
      // Callback Handler
      if(typeof callback == 'function')
      {
        callback(responseData);
      }
    }
  });
}
// User Info
function user_getInfo(id, callback)
{
  var connection = mysql.createConnection({
      host: config.MySQL.Host,
      user: config.MySQL.User,
      password: config.MySQL.Pass,
      database: config.MySQL.Database
  });

  connection.query("SELECT * FROM users WHERE Uniqueref = ? LIMIT 1", [id], function(error, result, fields) {
    if(error) throw error;
    if(result.length > 0) {
      callback(JSON.stringify(result[0]));
    }
  });
  connection.end();
}
