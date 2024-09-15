//Canlı soru arama
function liveSearch() {
  let listCustomer = document.querySelectorAll(".customerDiv");
  let search_query = document.getElementById("searchbox").value;

  for (var i = 0; i < listCustomer.length; i++) {
    if (listCustomer[i].innerText.toLowerCase().includes(search_query.toLowerCase())) {
      listCustomer[i].style.display = "inline";
      listCustomer[i].classList.remove("is-hidden");
    } else {
      listCustomer[i].style.display = "none";
      listCustomer[i].classList.add("is-hidden");
    }
  }
}

//Soru arama gecikmesi
let typingTimer;
let typeInterval = 500;
let searchInput = document.getElementById("searchbox");

searchInput.addEventListener("keyup", () => {
  clearTimeout(typingTimer);
  typingTimer = setTimeout(liveSearch, typeInterval);
});

//Müşteri filtreleme
function isBanned() {
  let listCustomer = document.querySelectorAll(".customerDiv");
  let isBannedChecked = document.getElementById("isBanned").checked;
  for (var i = 0; i < listCustomer.length; i++) {
    if (isBannedChecked) {
      if (listCustomer[i].getAttribute("is-banned") === "true") {
        listCustomer[i].style.display = "inline";
        listCustomer[i].classList.remove("is-hidden");
      } else {
        listCustomer[i].style.display = "none";
        listCustomer[i].classList.add("is-hidden");
      }
    } else {
      listCustomer[i].style.display = "inline";
      listCustomer[i].classList.remove("is-hidden");
    }
  }
}
document.getElementById("isBanned").addEventListener("change", isBanned);
