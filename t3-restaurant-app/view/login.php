<?php
include "../controllers/auth-controller.php";
if (IsUserLoggedIn()) {
    header("Location: index.php");
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <form action="../scripts/login-query.php" method="post">
        <input type="text" name="username" placeholder="Kullanıcı Adı" required />
        <input type="password" name="password" required />
        <button type="submit">Giriş Yap</button>
    </form>
    <button type="button" onclick="goToSignIn()">Kayıt Ol</button>

</body>
<script>
    function goToSignIn() {
        window.location.href = "signin.php";
    }
</script>

</html>