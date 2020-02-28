function Navi_Tog() {
  var pane = document.getElementById("Menu");
  if (pane.hasClass("Show")) {
     pane.style.display = "block";
  } else {
    pane.style.display = "none";
  }
}
