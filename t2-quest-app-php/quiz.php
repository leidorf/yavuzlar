<?php
session_start();
if (!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
  header("Location: login.php?message=You are not logged in!");
  die();
} else {
  include "functions/functions.php";
  $questions = GetQuestionsForUser($_SESSION['id']);

?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Quiz</title>
  </head>

  <body>
    <div class="container">
      <?php if (count($questions) == 0) { ?>
        <h3>Çözülmemiş hiçbir soru kalmadı!</h3>
        <button id="homePageButton" onclick="goToHomePage()">Ana Sayfa</button>
      <?php } ?>
      <?php foreach ($questions as $i => $question):
        $question['answers'] = json_decode($question['answers'], true); ?>

        <div id="question<?php echo $i; ?>" class="questionContainer" style="display: <?php echo $i === 0 ? 'block' : 'none'; ?>;">
          <div class="infoDiv">
            <p class="infoText" id="difficultyText<?php echo $question['difficulty']; ?>">
              <?php switch ($question['difficulty']) {
                case 1:
                  echo 'Kolay';
                  break;
                case 2:
                  echo 'Orta';
                  break;
                case 3:
                  echo 'Zor';
                  break;
                default:
                  echo '';
                  break;
              } ?></p>
            <p class="infoText"><?php echo "Sorular: " . count($questions); ?></p>
          </div>
          <h3><?php echo $question['qname']; ?></h3>
          <h3><?php echo $question['question']; ?></h3>
          <?php foreach ($question['answers'] as $ii => $answer): ?>
            <button type="button" class="answerButton" onclick="checkAnswer(<?php echo $question['id']; ?>, <?php echo $ii; ?>, <?php echo $question['correct']; ?>, <?php echo $i; ?>, `<?php echo $question['qname']; ?>`)">
              <?php echo $answer; ?>
            </button>
          <?php endforeach; ?>
        </div>
      <?php endforeach ?>
    </div>
    <script src="./js/quiz.js"></script>
  </body>

  </html>
<?php } ?>