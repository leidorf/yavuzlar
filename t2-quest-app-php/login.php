<?php
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
  header('Location: index.php?message=You are already logged in!');
  exit();
}
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
    <h2>Quest App</h2>
    <form action="login-query.php" method="post">
      <input class="loginInput" type="text" name="username" placeholder="Kullanıcı Adı" style="margin: 1rem 0px 1rem 0px;" required>
      <input class="loginInput" type="password" name="password" placeholder="Şifre" required>
      <button type="submit">Giriş Yap</button>
    </form>
  </div>
</body>

</html>