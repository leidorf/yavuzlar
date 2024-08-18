const goBackButton = document.getElementById("goBackButton");

function goBackFunc() {
  window.location.href = "./quest-list.html";
}

goBackButton.addEventListener("click", goBackFunc);
