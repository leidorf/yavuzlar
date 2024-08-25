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
    <title>Yavuzlar Quest App</title>
  </head>
  <body>
    <div class="container">
      <div>
        <h2>Yavuzlar Quest App</h2>
      </div>
      <a href="./quiz.php"><button id="startBtn">Başlat</button></a>
      <?php if($_SESSION["isAdmin"]){
        echo `
        <a href="./quest-list.php">
          <button>Soruları Düzenle</button>
        </a>`;
      } ?>
    </div>
  </body>
</html>
<?php
}else{
  header('Location: ./login.php?message=You are not logged in!');
  exit;
}
?>