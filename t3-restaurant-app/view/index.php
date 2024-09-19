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
    <title>Restaurant App</title>
</head>

<body>
    <div class="container">
        <div class="login t<?php echo $_SESSION['role']; ?>">

            <h2>Yavuzlar Restoran Uygulaması</h2>
            <h3>Hoşgeldin <?php echo $_SESSION['name'] . " " . $_SESSION['surname']; ?>! </h3>
            <div>
                <a href="profile.php"><button class="container_obj">Profil</button></a><br>

                <?php switch ($_SESSION['role']) {
                    case 0: ?>
                        <a href="customer-list.php"><button class="container_obj">Müşteriler</button></a>
                        <a href="company-list.php"><button class="container_obj">Firmalar</button></a>
                        <a href="cupons.php"><button class="container_obj">Kuponlar</button></a>
                    <?php break;
                    case 1: ?>
                        <a href="company.php"><button class="container_obj">Firma</button></a>
                        <a href="food-list.php"><button class="container_obj">Yemekler</button></a>
                        <a href="restaurant-list.php"><button class="container_obj">Restoranlar</button></a>
                    <?php break;
                    case 2: ?>
                        <a href="foods.php"><button class="container_obj">Yemekler</button></a>
                        <a href="orders.php"><button class="container_obj">Siparişler</button></a>
                <?php break;
                } ?>
                <form action="logout.php" method="post"><button>Çıkış Yap</button></form>
            </div>
        </div>
    </div>
    <?php
    require_once "footer.php";
    ?>
</body>

</html>