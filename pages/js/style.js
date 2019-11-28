var dropdown = document.getElementsByClassName("Dropdown-Btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}
function Navi_Tog() {
  var pane = document.getElementById("Navi");
  if (pane.style.left === "0px") {
     pane.style.left = "-240px";
     pane.style.transition = "0.2s ease-in-out";
  } else {
     pane.style.left = "0px";
     pane.style.transition = "0.2s ease-in-out";
  }
}
