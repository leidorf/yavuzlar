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
    <title>Register</title>
</head>

<body>
    <div class="container">
        <div class="login" style="margin-top:5rem;">
            <h3>Kayıt Ol</h3>
            <img src="../public/images/login_logo.png" alt="Kayıt Logosu" class="login_logo">
            <form action="../scripts/register-query.php" method="post">
                <div style="margin-bottom:2.5rem;">
                    <div class="container_obj">
                        <label for="name">İsim</label><br>
                        <input type="text" name="name" placeholder="İsim" required />
                    </div>
                    <div class="container_obj">
                        <label for="surname">Soyisim</label><br>
                        <input type="text" name="surname" placeholder="Soyisim" required />
                    </div>
                    <div class="container_obj">
                        <label for="username">Kullanıcı Adı</label><br>
                        <input type="text" name="username" placeholder="Kullanıcı Adı" required />
                    </div>
                    <div class="container_obj">
                        <label for="password">Şifre</label><br>
                        <input type="password" name="password" placeholder="Şifre" required />
                    </div>
                    <button type="submit" class="secondary">Kayıt Ol</button>
                </div>
            </form>
            <a href="login.php"><button>Giriş Yap</button></a>
        </div>
    </div>
</body>

</html>