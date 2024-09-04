//Local Storage'a sorulari ekleme
/* document.addEventListener("DOMContentLoaded", function () {
  let questions = JSON.parse(localStorage.getItem("questions")) || [];

  document.getElementById("addQuestForm").addEventListener("submit", function (event) {
    event.preventDefault();

    const id = questions.length > 0 ? questions[questions.length - 1].id + 1 : 0;
    const qname = document.getElementById("qname").value;
    const difficulty = document.getElementById("difficulty").value;
    const question = document.getElementById("question").value;
    const answers = [];
    let correctAnswerValue = null;

    for (let i = 0; i < 4; i++) {
      const answerInput = document.getElementById(`answer${i}`);
      const isCorrect = document.getElementById(`correct${i}`).checked;

      if (answerInput && answerInput.value) {
        answers.push(answerInput.value);
      }
      if (isCorrect) {
        correctAnswerValue = answerInput.value;
      }
    }

    const questionData = {
      id,
      qname,
      question,
      answers,
      correct: correctAnswerValue,
      difficulty,
    };

    questions.push(questionData);
    localStorage.setItem("questions", JSON.stringify(questions));
    goBack();
  });
}); */

//Geri donus butonu
function goBack() {
  window.location.href = "quest-list.php";
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