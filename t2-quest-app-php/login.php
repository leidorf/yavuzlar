<?php
session_start();

if(!isset($_SESSION['id']) && !isset($_SESSION['username'])){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
      <h3>Giriş Yap</h3>
      <form action="loginQuery.php" method="POST">
        <input class="loginInput" type="text" name="username" placeholder="Kullanıcı Adı" style="margin: 1rem 0px 1rem 0px;">
        <input class="loginInput" type="password" name="password" placeholder="Şifre" >
        <button type="submit">Giriş Yap</button>
      </form>
    </div>
</body>
</html><?php
}else{
  header('Location: index.php?message=You are logged in!');
  exit;
}
?>