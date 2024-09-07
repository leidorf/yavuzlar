let currentQuestionIndex = 0;
let questionsCount = document.querySelectorAll(".questionContainer").length;

function checkAnswer(questionId, selectedAnswer, correctAnswer, questionIndex, qname) {
  let buttons = document.querySelectorAll(`#question${questionIndex} .answerButton`);

  buttons.forEach((button) => (button.disabled = true));

  if (selectedAnswer === correctAnswer) {
    buttons[selectedAnswer].style.border = "solid 2px #45aa45";
    buttons[selectedAnswer].style.boxShadow = "1px 1px 15px 5px #45aa45";
  } else {
    buttons[selectedAnswer].style.border = "solid 2px #ee3545";
    buttons[selectedAnswer].style.boxShadow = "1px 1px 15px 5px #ee3545";
  }
  setTimeout(() => {
    updateScore(questionId, selectedAnswer === correctAnswer, qname);
  }, 1250);
}

function updateScore(questionId, isCorrect, qname) {
  const form = document.createElement("form");
  form.method = "POST";
  form.action = "update-score.php";

  const questionInput = document.createElement("input");
  questionInput.type = "hidden";
  questionInput.name = "questionId";
  questionInput.value = questionId;
  form.appendChild(questionInput);

  const correctInput = document.createElement("input");
  correctInput.type = "hidden";
  correctInput.name = "isCorrect";
  correctInput.value = isCorrect ? 1 : 0;
  form.appendChild(correctInput);

  const qnameInput = document.createElement("input");
  qnameInput.type = "hidden";
  qnameInput.name = "qname";
  qnameInput.value = qname;
  form.appendChild(qnameInput);

  document.body.appendChild(form);
  form.submit();
}

function goToHomePage() {
  window.location.href = "index.php";
}
document.getElementById("homePageButton").addEventListener("click", goToHomePage);
