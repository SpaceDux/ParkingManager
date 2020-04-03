const {BrowserWindow} = require('electron').remote;
// const session = sessionStorage;
const config = require('../core/manage/config.json');
const mysql = require('mysql');
// Load Class Files
// $.getScript("../core/class/user.js", function() {
//   console.log("User Class has loaded successfully.");
// });
// Window Controller
$(document).ready(function() {
  // Close Window (focused)
  $(document).on('click', '#Setting-Close', function(e) {
    try {
      var window = BrowserWindow.getFocusedWindow();
      window.close();
      console.log("Window has been successfully closed.");
    } catch(err) {
      console.error("Window can not be closed - "+err);
    }
  });
  // Maximize Window (focused)
  $(document).on('click', '#Setting-Maxi', function(e) {
    try {
      var window = BrowserWindow.getFocusedWindow();
      if(window.isMaximized()) {
        window.unmaximize();
        console.log("Window has been successfully unmaximized.");
      } else{
        window.maximize();
        console.log("Window has been successfully maximized.");
      }
    } catch(err) {
      console.error("Window can not be maximized/unmaximized - "+err);
    }
  });
  // Minimize Window (focused)
  $(document).on('click', '#Setting-Mini', function(e) {
    try {
      var window = BrowserWindow.getFocusedWindow();
      window.minimize();
      console.log("Window has been successfully minimized.");
    } catch(err) {
      console.error("Window can not be minimized - "+err);
    }
  });
});
