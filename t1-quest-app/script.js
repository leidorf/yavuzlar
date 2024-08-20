function goBack() {
  window.location.href = "quest-list.html";
}
document.getElementById("goBackButton").addEventListener("click", goBack);

document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("addQuestForm").addEventListener("submit", function (event) {
    event.preventDefault();

    const qname = document.getElementById("qname").value;
    const difficulty = document.getElementById("difficulty").value;
    const question = document.getElementById("question").value;
    const answer0 = document.getElementById("answer0").value;
    const answer1 = document.getElementById("answer1").value;
    const answer2 = document.getElementById("answer2").value;
    const answer3 = document.getElementById("answer3").value;
    const correct0 = document.getElementById("correct0").checked;
    const correct1 = document.getElementById("correct1").checked;
    const correct2 = document.getElementById("correct2").checked;
    const correct3 = document.getElementById("correct3").checked;

    const quest = {
      qname: qname,
      difficulty: difficulty,
      question: question,
      answer0: answer0,
      answer1: answer1,
      answer2: answer2,
      answer3: answer3,
      correct0: correct0,
      correct1: correct1,
      correct2: correct2,
      correct3: correct3,
    };

    document.getElementById("addQuestForm").reset();
  });
});

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