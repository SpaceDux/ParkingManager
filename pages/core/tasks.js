const {BrowserWindow} = require('electron').remote;
$(document).ready(function(){
  // Close Window (focused)
  $(document).on('click', '#Setting-Close', function(e) {
    var window = BrowserWindow.getFocusedWindow();
    window.close();
  });
  // Maximize Window (focused)
  $(document).on('click', '#Setting-Maxi', function(e) {
    var window = BrowserWindow.getFocusedWindow();
    if(window.isMaximized()) {
      window.unmaximize();
    } else{
      window.maximize();
    }
  });
  // Minimize Window (focused)
  $(document).on('click', '#Setting-Mini', function(e) {
    var window = BrowserWindow.getFocusedWindow();
    window.minimize();
  });
  console.log("ParkingManager Electron build & launch successfully.");
});
