//Id'ye gore soru icerigini ekrana yansitma fonksiyonu
document.addEventListener("DOMContentLoaded",function(){

});









//Geri donus butonu
function goBack() {
    window.location.href = "quest-list.html";
  }
  document.getElementById("goBackButton").addEventListener("click", goBack);

//Sorunun cevap sayisini arttirip azaltma fonksiyonlari
let answerCount = 2;

function addAnswer() {
  if (answerCount < 4) {
    document.getElementsByClassName("questionGroup")[answerCount].style.display = "flex";
    answerCount++;
  }
  if (answerCount > 2) {
    document.getElementById("removeAnswerBtn").style.display = "inline";
  }
  if (answerCount >= 4) {
    document.getElementById("addAnswerBtn").style.display = "none";
  }
}

document.getElementById("removeAnswerBtn").style.display = "none";

function removeAnswer() {
  if (answerCount > 2) {
    answerCount--;
    document.getElementsByClassName("questionGroup")[answerCount].style.display = "none";
  }
  if (answerCount <= 2) {
    document.getElementById("removeAnswerBtn").style.display = "none";
  }
  if (answerCount < 4) {
    document.getElementById("addAnswerBtn").style.display = "inline";
  }
}