document.addEventListener("DOMContentLoaded", function () {
  let questions = JSON.parse(localStorage.getItem("questions")) || [];
  questions.sort(() => Math.random() - 0.5);

  const questionContainer = document.getElementById("questionContainer");
  const nextButton = document.getElementById("nextButton");

  let currentIndex = 0;
  let score = 0;
  let correctCounter = 0;

  function showQuestion(index) {
    if (index < questions.length) {
      const currentQuestion = questions[currentIndex];
      questionContainer.innerHTML = "";

      let qname = document.createElement("h3");
      qname.innerHTML = `Zorluk: ${currentQuestion.difficulty}/3<br/>${currentQuestion.qname}`;
      questionContainer.appendChild(qname);

      currentQuestion.answers.sort(() => Math.random() - 0.5);
      for (let i of currentQuestion.answers) {
        let answerButton = document.createElement("button");
        answerButton.classList.add("quizBtn");
        answerButton.innerText = i;

        answerButton.addEventListener("click", function () {
          const allButtons = document.querySelectorAll(".quizBtn");
          allButtons.forEach((button) => (button.disabled = true));
          if (i === currentQuestion.correct) {
            score += currentQuestion.difficulty * 10;
            correctCounter++;
            answerButton.style.border = "solid 2px #45aa45";
            answerButton.style.boxShadow = "1px 1px 15px 5px #45aa45";
          } else {
            answerButton.style.border = "solid 2px #ee3545";
            answerButton.style.boxShadow = "1px 1px 15px 5px #ee3545";
          }
          nextButton.style.display = "inline";
        });
        questionContainer.appendChild(answerButton);
      }
    } else {
      questionContainer.innerHTML = `<h2>Tebrikler!<br/>Sonucunuz:</h2><p style="font-weight:600;">${correctCounter}/${questions.length} Doğru<br/><br/>${score} Puan</p>`;

      let homeBtn = document.createElement("a");
      homeBtn.href = "index.html";
      homeBtn.innerHTML = `<button type="button">Ana Sayfa</button>`;

      questionContainer.appendChild(homeBtn);

      nextButton.style.display = "none";
    }
  }

  showQuestion(currentIndex);
  nextButton.addEventListener("click", function () {
    currentIndex++;
    showQuestion(currentIndex);
    nextButton.style.display = "none";
  });
});
