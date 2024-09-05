<?php
session_start();

if (!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
  header('Location: ./login.php?message=You are not logged in!');
  exit();
} else if (!$_SESSION['isAdmin']) {
  header("Location: index.php?message=You are not admin!");
  exit();
} else {
  include "functions/functions.php";
  $questions = GetQuestions();
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
    <title>Quest List</title>
  </head>

  <body>
    <div class="container">
      <div class="addQuestForm">
        <div>
          <input
            type="search"
            id="searchbox"
            placeholder="Soru Ara" />
        </div>
        <br />
        <?php
        foreach ($questions as $question): ?>
          <div class="questionGroup">
            <div class="questionDiv">
              <p class="qText"><?php echo $question['qname'] ?></p>
              <a  href="edit-quest.php?id=<?php echo $question['id']; ?>">
                <button type="button" class="editBtn">⚙️</button>
              </a>
              <a href="delete-quest.php?id=<?php echo $question['id']; ?>">
                <button type="button" class="editBtn">❌</button>
              </a>
            </div>
          </div>
        <?php endforeach ?>
        <div class="buttonGroup">
          <a href="./index.php"><button>Ana Sayfa</button></a>
          <a href="./add-quest.php">
            <button>Soru Ekle</button>
          </a>
        </div>
      </div>
    </div>
    <script>

    </script>
    <script src="./js/quest-list.js"></script>
  </body>

  </html>
<?php
}
?>