<?php
session_start();
if (!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
  header("Location: login.php?message=You are not logged in!");
  die();
} else if (!$_SESSION['isAdmin']) {
  header("Location: index.php?message=You are not admin!");
  exit();
} else {
  include "functions/functions.php";
  $questionId = $_GET['id'];
  $question = GetQuestionById($questionId);
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="style.css" />
    <title>Edit Quest</title>
  </head>

  <body>
    <div class="container">
      <h2 style="margin-bottom: 2.5rem">Soruyu Düzenle</h2>
      <form
        class="editQuestForm"
        id="editQuestForm"
        action="edit-quest-query.php?id=<?php echo $questionId; ?>"
        method="post">
        <div>
          <input
            type="text"
            name="qname"
            id="qname"
            placeholder="Soru Adı"
            value="<?php echo $question['qname']; ?>"
            required />
        </div>
        <div class="labels"><span>Kolay</span><span style="font-size: medium">Soru Zorluğu</span> <span>Zor</span></div>
        <input
          type="range"
          min="1"
          max="3"
          value="<?php echo $question['difficulty']; ?>"
          class="slider"
          id="difficulty"
          name="difficulty" /><br />
        <input
          type="text"
          name="question"
          id="question"
          placeholder="Soru"
          value="<?php echo $question['question']; ?>"
          required /> <br />
        <?php foreach ($question['answers'] as $index => $answer) { ?>
          <div class="questionGroup">
            <input type="text" name="answers[]" id="answer<?php echo $index; ?>" placeholder="Cevap <?php echo $index + 1; ?>" value="<?php echo $question['answers'][$index];?>" <?php if(!$index>2){echo "required";}?>/>
            <div>
              <input type="radio" name="correct" id="correct<?php echo $index; ?>" value="<?php echo $index; ?>"
                <?php if ($question['correct'] == $index) {
                  echo 'checked';
                } ?> required />
              <p class="checkboxText">Doğru</p>
            </div>
          </div>
          <br />
        <?php } ?>

        <!-- Ek cevap ekleme -->
        <?php for ($i = count($question['answers']); $i < 4; $i++) { ?>
          <div class="questionGroup">
            <input type="text" name="answers[]" id="answer<?php echo $i; ?>" placeholder="Cevap <?php echo $i + 1; ?>" />
            <div>
              <input type="radio" name="correct" id="correct<?php echo $i; ?>" value="<?php echo $i; ?>"/>
              <p class="checkboxText">Doğru</p>
            </div>
          </div>
          <br />
        <?php } ?>
        <button
          type="button"
          class="answerButton"
          id="removeAnswerBtn"
          onclick="removeAnswer()">
          -
        </button>
        <button
          type="button"
          class="answerButton"
          id="addAnswerBtn"
          onclick="addAnswer()">
          +
        </button>
        <div class="buttonGroup">
          <button
            type="button"
            id="goBackButton"
            onclick="goBack()">
            İptal
          </button>
          <button
            type="submit"
            id="submitButton">
            Düzenle
          </button>
        </div>
      </form>
    </div>
    <script src="./js/edit-quest.js"></script>
  </body>

  </html>
<?php
}
?>