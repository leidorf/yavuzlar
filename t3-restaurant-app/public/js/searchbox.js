//Veri arama
function liveSearch() {
  let listData = document.querySelectorAll(".dataElement");
  let search_query = document.getElementById("searchbox").value;

  for (var i = 0; i < listData.length; i++) {
    if (listData[i].innerText.toLowerCase().includes(search_query.toLowerCase())) {
      listData[i].style.display = "table-row";
      listData[i].classList.remove("is-hidden");
    } else {
      listData[i].style.display = "none";
      listData[i].classList.add("is-hidden");
    }
  }
}

//Veri arama gecikmesi
let typingTimer;
let typeInterval = 500;
let searchInput = document.getElementById("searchbox");

searchInput.addEventListener("keyup", () => {
  clearTimeout(typingTimer);
  typingTimer = setTimeout(liveSearch, typeInterval);
});

//Veri filtreleme
function isBanned() {
  let listData = document.querySelectorAll(".dataElement");
  let isBannedChecked = document.getElementById("isBanned").checked;
  for (var i = 0; i < listData.length; i++) {
    if (isBannedChecked) {
      if (listData[i].getAttribute("is-banned") === "true") {
        listData[i].style.display = "table-row";
        listData[i].classList.remove("is-hidden");
      } else {
        listData[i].style.display = "none";
        listData[i].classList.add("is-hidden");
      }
    } else {
      listData[i].style.display = "table-row";
      listData[i].classList.remove("is-hidden");
    }
  }
}
document.getElementById("isBanned").addEventListener("change", isBanned);
