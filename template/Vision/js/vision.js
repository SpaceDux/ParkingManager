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
// Slide open the Payment Pane
function PaymentPane() {
  var pane = document.getElementById("PaymentPane");
  if (pane.style.left === "0px") {
     pane.style.left = "-90%";
     pane.style.transition = "0.1s ease-in-out";
  } else {
     pane.style.left = "0px";
     pane.style.transition = "0.1s ease-in-out";
  }
}
// Slide open the Payment Pane
function UpdateVehPane() {
  var pane = document.getElementById("UpdateVehPane");
  if (pane.style.left === "0px") {
     pane.style.left = "-90%";
     pane.style.transition = "0.1s ease-in-out";
  } else {
     pane.style.left = "0px";
     pane.style.transition = "0.1s ease-in-out";
  }
}
// Slide open the Payment Pane
function ListTransactionsPane() {
  var pane = document.getElementById("TransactionListPane");
  if (pane.style.left === "0px") {
     pane.style.left = "-90%";
     pane.style.transition = "0.1s ease-in-out";
  } else {
     pane.style.left = "0px";
     pane.style.transition = "0.1s ease-in-out";
  }
}
