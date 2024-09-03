//Soruları listeleme ve gerekli butonları olusturma
let questions = [];

document.addEventListener("DOMContentLoaded", function () {
  questions = JSON.parse(localStorage.getItem("questions")) || [];
  if (questions.length < 1) {
    document.getElementById("searchbox").placeholder = "Arama Yapmadan Önce Soru Ekleyin";
    document.getElementById("searchbox").disabled = true;
  }

  const questionList = document.getElementById("question-list");

  questions.forEach((question) => {
    const questionDiv = document.createElement("div");

    questionList.style.padding = "0";
    questionDiv.classList.add("questionDiv");

    const listItem = document.createElement(`li`);
    const editBtn = document.createElement("button");
    const deleteBtn = document.createElement("button");

    editBtn.innerText = "Düzenle";
    deleteBtn.innerText = "Sil";

    listItem.classList.add("qText");
    editBtn.classList.add("editBtn");
    deleteBtn.classList.add("editBtn");

    editBtn.addEventListener("click", function () {
      window.location.href = `edit-quest.php?id=${question.id}`;
    });

    deleteBtn.addEventListener("click", () => deleteQuestion(question.id));

    document.body.append(editBtn);
    document.body.append(deleteBtn);

    listItem.textContent = question.qname;
    listItem.id = question.id;

    questionDiv.appendChild(listItem);
    questionDiv.appendChild(editBtn);
    questionDiv.appendChild(deleteBtn);

    questionList.appendChild(questionDiv);
  });
});

//Soru silme fonksiyonu
function deleteQuestion(id) {
  let questions = JSON.parse(localStorage.getItem("questions")) || [];

  for (let i = 0; i < questions.length; i++) {
    if (questions[i].id == id) {
      questions.splice(i, 1);
      break;
    }
  }

  localStorage.setItem("questions", JSON.stringify(questions));
  window.location.reload();
}

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
