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
    <link rel="stylesheet" href="../public/css/style.css">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="login t0" style="margin-top:5rem;">
            <h3>Yavuzlar Restoran Uygulaması</h3>
            <div style="margin-bottom: 2.5rem;">
                <img src="../public/images/login_logo.png" alt="Login Logo" class="login_logo">
                <form action="../scripts/login-query.php" method="post">
                    <div class="container_obj">
                        <label for="username">Kullanıcı Adı</label><br>
                        <input type="text" name="username" placeholder="Kullanıcı Adı" required />
                    </div>
                    <div class="container_obj">
                        <label for="password">Şifre</label><br>
                        <input type="password" name="password" placeholder="Şifre" required />
                    </div>
                    <button type="submit">Giriş Yap</button>
                </form>
            </div>
            <a href="register.php"><button style="background-color: var(--company);">Kayıt Ol</button></a>
        </div>
    </div>
</body>

</html>