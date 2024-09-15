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
    <title>Profile</title>
</head>

<body>
    <div class="container">
        <h3>Profil</h3>
        <div>
            <h4>Ad: <?php echo $_SESSION['name']; ?></h4>
            <h4>Soyad: <?php echo $_SESSION['surname']; ?></h4>
            <h4>Kullanıcı Adı: <?php echo $_SESSION['username']; ?></h4>
            <h4>Bakiyeniz: <?php echo $_SESSION['balance']; ?></h4>
            <h4>Kayıt Tarihi: <?php echo  $_SESSION['created_at']; ?></h4>
        </div>
        <div>
            <a href="update-profile.php"><button type="button">Profili Güncelle</button></a>
            <a href="update-password.php"><button type="button">Şifreyi Güncelle</button></a>
            <a href="add-balance.php"><button type="button">Bakiye Ekle</button></a>
        </div>

    </div>

    <a href="index.php"><button type="button">Ana Sayfa</button></a>
</body>

</html>