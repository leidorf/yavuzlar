<?php
session_start();

if(isset($_SESSION['id']) && isset($_SESSION['username'])){

?>
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
    <title>Quest List</title>
  </head>
  <body>
    <div class="container">
      <div class="addQuestForm">
        <div>
          <input
            type="search"
            id="searchbox"
            placeholder="Soru Ara"
          />
        </div>
        <br />
        <div class="questionGroup">
          <ul id="question-list"></ul>
        </div>
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
}else{
  header('Location: ./login.php?message=You are not logged in!');
  exit;
}
?>