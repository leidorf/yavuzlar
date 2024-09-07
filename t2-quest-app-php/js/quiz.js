let currentQuestionIndex = 0;
let questionsCount = document.querySelectorAll('.questionContainer').length;

function checkAnswer(questionId, selectedAnswer, correctAnswer, questionIndex) {
    let buttons = document.querySelectorAll(`#question${questionIndex} .answerButton`);
    
    buttons.forEach(button => button.disabled = true);

    if (selectedAnswer === correctAnswer) {
      buttons[selectedAnswer].style.border = "solid 2px #45aa45";
      buttons[selectedAnswer].style.boxShadow = "1px 1px 15px 5px #45aa45";
        updateScore(questionId, true);
    } else {
      buttons[selectedAnswer].style.border = "solid 2px #ee3545";
      buttons[selectedAnswer].style.boxShadow = "1px 1px 15px 5px #ee3545";
        updateScore(questionId, false);
    }

    document.getElementById('nextButton').style.display = 'block';
}

function nextQuestion() {
    document.getElementById(`question${currentQuestionIndex}`).style.display = 'none';
    currentQuestionIndex++;

    if (currentQuestionIndex < questionsCount) {
        document.getElementById(`question${currentQuestionIndex}`).style.display = 'block';
        document.getElementById('nextButton').style.display = 'none';
    } else {
        window.location.href = 'index.php';
    }
}

function updateScore(questionId, isCorrect) {
    fetch('update-score.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            questionId: questionId,
            isCorrect: isCorrect
        })
    });
}