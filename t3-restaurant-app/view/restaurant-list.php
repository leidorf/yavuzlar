<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: login.php?message=Lütfen giriş yapınız.");
    exit();
} else if ($_SESSION['role'] != 1) {
    header("Location: index.php?message=403 Yetkisiz Giriş");
}
include "../controllers/company-controller.php";
$restaurants = GetRestaurantByCId($_SESSION['company_id']);
require_once "header.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <title>Restaurants of Company</title>
</head>

<body>
    <div>
        <div class="centerDiv">
            <h1>Firmanın Restoranları</h1>
            <a href="./add-restaurant.php" class="t<?php echo $_SESSION['role']; ?>" ><button>Restoran Ekle</button></a>
        </div>
        <?php if (empty($restaurants)) {
            echo "<p>Firmaya ait hiçbir restoran bulunamadı.</p>";
        } else { ?>
            <div class="searchbox">
                <input
                    type="search"
                    id="searchbox"
                    onchange="liveSearch()"
                    placeholder="Restoran Ara" />
            </div>
            <?php foreach ($restaurants as $restaurant): ?>
                <div class="customerDiv">
                    <div class="dataDiv t<?php echo $_SESSION['role']; ?>">
                        <p><?php echo $restaurant["name"]; ?></p>
                        <p><?php echo $restaurant["description"]; ?></p>
                        <img src="<?php echo $restaurant["image_path"]; ?>" alt="Restoran Fotoğrafı" class="company_logo">
                        <p><?php echo $restaurant["created_at"]; ?></p>
                        <a href="update-restaurant.php?r_id=<?php echo $restaurant['id']; ?>"><button>Restoranı Güncelle</button></a>
                        <form action="../scripts/delete-restaurant.php" method="post">
                            <input type="hidden" name="restaurant_id" id="restaurant_id" value="<?php echo $restaurant['id']; ?>">
                            <button type="submit" style="margin-top: 1rem;" >X</button>
                        </form>
                    </div>
                </div>
            <?php endforeach ?>
        <?php } ?>
        <a href="index.php" style="margin-top: 1.5rem;" class="centerDiv b<?php echo $_SESSION['role']; ?>"><button>Ana Sayfa</button></a>
    </div>
    <?php require_once "footer.php"; ?>
    <script src="../public/js/customer-list.js"></script>
</body>

</html>