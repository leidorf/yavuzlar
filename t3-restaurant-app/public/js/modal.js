var modal = document.getElementById("modal");
var btns = document.querySelectorAll(".modalBtn");
var span = document.getElementsByClassName("close")[0];
var dataIdInput = document.getElementById("data_id");

btns.forEach(function (btn) {
  btn.onclick = function () {
    var dataId = btn.getAttribute("data_id");
    dataIdInput.value = dataId;
    modal.style.display = "block";
  };
});
span.onclick = function () {
  modal.style.display = "none";
};
window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};
