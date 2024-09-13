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
    <title>Register</title>
</head>

<body>
    <div>
        <a href="login.php"> <button type="button">←</button> </a>
        <form action="../scripts/register-query.php" method="post">
            <input type="text" name="name" placeholder="İsim" required />
            <input type="text" name="surname" placeholder="Soyisim" required />
            <input type="text" name="username" placeholder="Kullanıcı Adı" required />
            <input type="password" name="password" placeholder="Şifre" required />
            <button type="submit">Kayıt Ol</button>
        </form>
    </div>

</body>

</html>