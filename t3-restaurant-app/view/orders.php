<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: login.php?message=Lütfen giriş yapınız.");
    exit();
}
include "../controllers/customer-controller.php";
require_once "header.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <title>Orders</title>
</head>

<body>
    <div class="">
        <h1 class="searchbox">Siparişler</h1>
        <?php
        if (empty($orders)) {
            echo "<p class='searchbox'>Geçmişe dair herhangi bir sipariş bulunamadı.</p>";
        } else { ?>
            <div>
                <input
                    type="search"
                    id="searchbox"
                    onchange="liveSearch()"
                    placeholder="Müşteri Ara" />
            </div>
            <?php foreach ($orders as $order): ?>
                <div class="customerDiv">
                    <div class="dataDiv">

                    </div>
                </div>
            <?php endforeach ?>
        <?php } ?>
    </div>
    <a href="index.php"><button type="button">Ana Sayfa</button></a>
    <?php require_once "footer.php"; ?>
</body>

</html>