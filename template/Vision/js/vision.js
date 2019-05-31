// Main Navigation Toggle for Mobile
function Navi_Tog() {
  $('.Navigation_Bar').toggleClass("Show");
}
// Slide open the Notifications Pane
function Notifications() {
  var pane = document.getElementById("NotificationPane");
  if (pane.style.right === "0px") {
     pane.style.right = "-350px";
     pane.style.transition = "0.2s ease-in-out";
  } else {
     pane.style.right = "0px";
     pane.style.transition = "0.2s ease-in-out";
  }
}
