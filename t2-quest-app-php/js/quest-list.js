//Canlı soru arama
function liveSearch() {
  let listItem = document.querySelectorAll(".questionDiv");
  let search_query = document.getElementById("searchbox").value;

  for (var i = 0; i < questions.length; i++) {
    if (listItem[i].innerText.toLowerCase().includes(search_query.toLowerCase())) {
      listItem[i].classList.remove("is-hidden");
    } else {
      listItem[i].classList.add("is-hidden");
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
