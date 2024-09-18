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
    <title>Restaurant App</title>
</head>

<body>
    <div style="width: 50px; height: 50px; background-color:
        <?php switch ($_SESSION['role']) {
            case 0:
                echo "red";
                break;
            case 1:
                echo "yellow";
                break;
            case 2:
                echo "green";
                break;
        } ?>"></div>
    <div class="container">
        <img src="../public/images/logo.png" alt="Yavuzlar Logo" style="background-color: black;" />
        <h3>Yavuzlar Restoran Uygulaması</h3>
        <h4>Hoşgeldin <?php echo $_SESSION['name'] . " " . $_SESSION['surname']; ?>! </h4>
        <a href="profile.php"><button type="button">Profil</button></a>


        <?php switch ($_SESSION['role']) {
            case 0: ?>
                <div>
                    <a href="customer-list.php"><button type="button">Müşteri Listesi</button></a>
                    <a href="company-list.php"><button type="button">Firma Listesi</button></a>
                    <a href="cupons.php"><button type="button">Kuponlar</button></a>
                </div>
            <?php break;
            case 1: ?>
                <a href="food-list.php"><button type="button">Firmanın Yemekleri</button></a>
                <a href="restaurant-list.php"><button type="button">Firma Restoranları</button></a>
            <?php break;
            case 2: ?>
                <a href="foods.php"><button type="button">Yemekler</button></a>
                <a href="orders.php"><button type="button">Siparişler</button></a>
        <?php break;
        } ?>
        <div>
            <form action="logout.php" method="post"><button type="submit">Çıkış Yap</button></form>
        </div>
    </div>
</body>

</html>