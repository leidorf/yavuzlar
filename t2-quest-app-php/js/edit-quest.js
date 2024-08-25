let answerCount;

//Id'ye gore soru icerigini ekrana yansitma fonksiyonu
document.addEventListener("DOMContentLoaded", function () {
  const urlId = new URLSearchParams(window.location.search);
  const questId = urlId.get("id");

  let questions = JSON.parse(localStorage.getItem("questions")) || [];
  let currentQuestionIndex = questions.findIndex((q) => q.id == questId);
  let currentQuestion = questions.find((q) => q.id == questId);

  answerCount = currentQuestion.answers.length;
  for (let i = 0; i < answerCount; i++) {
    document.getElementsByClassName("questionGroup")[i].style.display = "flex";
  }

  //Eski degerleri yukleme
  document.getElementById("qname").value = currentQuestion.qname;
  document.getElementById("difficulty").value = currentQuestion.difficulty;
  document.getElementById("question").value = currentQuestion.question;
  for (var i = 0; i < currentQuestion.answers.length; i++) {
    document.getElementById(`answer${i}`).value = currentQuestion.answers[i];
    document.getElementById(`correct${i}`).checked = currentQuestion.correct[i];
  }
  document.getElementById("editQuestForm").addEventListener("submit", function (event) {
    event.preventDefault();

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

    questions[currentQuestionIndex] = {
      id: questId,
      qname,
      question,
      answers,
      correct: correctAnswerValue,
      difficulty,
    };
    localStorage.setItem("questions", JSON.stringify(questions));
    goBack();
  });
});

//Geri donus butonu
function goBack() {
  window.location.href = "quest-list.html";
}
document.getElementById("goBackButton").addEventListener("click", goBack);

//Sorunun cevap sayisini arttirip azaltma fonksiyonlari
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
