<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0"
    />
    <link
      rel="stylesheet"
      href="style.css"
    />
    <title>Add Quest</title>
  </head>
  <body>
    <div class="container">
      <h2 style="margin-bottom: 2.5rem">Soru Ekle</h2>
      <form
        class="addQuestForm"
        id="addQuestForm"
        action="add-quest-query.php"
        method="post"
        enctype="multipart/form-data"
      >
        <div>
          <input
            type="text"
            name="qname"
            id="qname"
            placeholder="Soru Adı"
            required
          />
        </div>
        <div class="labels"><span>Kolay</span><span style="font-size: medium">Soru Zorluğu</span> <span>Zor</span></div>
        <input
          type="range"
          min="1"
          max="3"
          value="2"
          class="slider"
          id="difficulty"
          name="difficulty"
        /><br />
        <input
          type="text"
          name="question"
          id="question"
          placeholder="Soru"
          required
        /><br />
        <div class="questionGroup">
          <input
            type="text"
            name="answers[]"
            id="answer0"
            placeholder="Cevap 1"
            required
          />
          <div>
            <input
              type="radio"
              name="correct"
              id="correct0"
              value="0"
              required
            />
            <p class="checkboxText">Doğru</p>
          </div>
        </div>
        <br />
        <div class="questionGroup">
          <input
            type="text"
            name="answers[]"
            id="answer1"
            placeholder="Cevap 2"
            required
          />
          <div>
            <input
              type="radio"
              name="correct"
              id="correct1"
              value="1"
              required
            />
            <p class="checkboxText">Doğru</p>
          </div>
        </div>
        <br />
        <div
          class="questionGroup"
          style="display: none"
        >
          <input
            type="text"
            name="answers[]"
            id="answer2"
            placeholder="Cevap 3"
          />
          <div>
            <input
              type="radio"
              name="correct"
              id="correct2"
              value="2"
              required
            />
            <p class="checkboxText">Doğru</p>
          </div>
        </div>
        <br />
        <div
          class="questionGroup"
          style="display: none"
        >
          <input
            type="text"
            name="answers[]"
            id="answer3"
            placeholder="Cevap 4"
            />
            <div>
              <input
              type="radio"
              name="correct"
              id="correct3"
              value="3"
              required
            />
            <p class="checkboxText">Doğru</p>
          </div>
        </div>
        <button
          type="button"
          class="answerButton"
          id="removeAnswerBtn"
          onclick="removeAnswer()"
        >
          -
        </button>
        <button
          type="button"
          class="answerButton"
          id="addAnswerBtn"
          onclick="addAnswer()"
        >
          +
        </button>
        <div class="buttonGroup">
          <button
            type="button"
            id="goBackButton"
            onclick="goBack()"
          >
            İptal
          </button>
          <button
            type="submit"
            id="submitButton"
          >
            Ekle
          </button>
        </div>
      </form>
    </div>
    <script src="./js/add-quest.js"></script>
  </body>
</html>
