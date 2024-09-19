<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: login.php?message=Lütfen giriş yapınız.");
    exit();
}
require_once "header.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <title>Add Balance</title>
</head>

<body>
    <div class="container">
        <div class="login t<?php echo $_SESSION['role']?>">
            <h1 class="searchbox">Bakiye Yükle</h1>
            <h3>Bakiyeniz: <?php echo $_SESSION['balance']; ?></h3>
            <form action="../scripts/add-balance-query.php" method="post">
                <p>Yüklemek istediğiniz miktarı giriniz</p>
                <input type="number" name="balance" min="0" style="margin-bottom: 1.5rem;" /><br>
                <button type="submit">Yükle</button>
            </form>
        </div>
    </div>
    <?php require_once "footer.php" ?>
</body>

</html>