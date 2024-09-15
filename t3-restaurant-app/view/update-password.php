<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: login.php?message=Lütfen giriş yapınız.");
    exit();
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Password</title>
</head>

<body>
    <div>
        <a href="login.php"> <button type="button">←</button> </a>
        <form action="../scripts/update-password-query.php" method="post">
            <div>
                <label for="current_password">Mevcut Şifre:</label>
                <input type="password" name="current_password" required />
            </div>

            <div>
                <label for="new_password">Yeni Şifre:</label>
                <input type="password" name="new_password" required />
            </div>

            <div>
                <label for="confirm_new_password">Yeni Şifreyi Tekrarlayın:</label>
                <input type="password" name="confirm_new_password" required />
            </div>

            <button type="submit">Şifreyi Güncelle</button>
        </form>
    </div>

</body>

</html>