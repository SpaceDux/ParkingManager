function LoggedIn()
{
  var session = sessionStorage;
  if(session.getItem("User_ID") != null) {
    return "TRUE";
  } else {
    return "FALSE";
    console.warn("Session is not set, user will now be redirected to Auth.");
  }
}
function CreateSession()
{
  sessionStorage.setItem("User_ID", "1");
  sessionStorage.setItem("Name", "Ryan Williams");
  window.location.replace("index.html");
}
