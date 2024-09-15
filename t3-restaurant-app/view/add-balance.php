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
    <title>Add Balance</title>
</head>

<body>
    <div class="container">
        <h3>Bakiyeniz: <?php echo $_SESSION['balance']; ?></h3>
        <form action="../scripts/add-balance-query.php" method="post">
            <p>Yüklemek istediğiniz miktarı giriniz</p>
            <input type="number" name="balance" min="0" />
            <button type="submit">Yükle</button>
        </form>
    </div>
    <a href="index.php"><button type="button">Ana Sayfa</button></a>
</body>

</html>