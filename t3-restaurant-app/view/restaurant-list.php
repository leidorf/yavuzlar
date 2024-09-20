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
    <div class="centerDiv">
        <div class="centerDiv">
            <h1>Firmanın Restoranları</h1>
            <a href="./add-restaurant.php" class="t<?php echo $_SESSION['role']; ?>"><button>Restoran Ekle</button></a>
        </div>
        <?php if (empty($restaurants)) {
            echo "<p>Firmaya ait hiçbir restoran bulunamadı.</p>";
        } else { ?>
            <div class="searchbox">
                <input type="search" id="searchbox" placeholder="Yemek Ara" />
            </div>

            <table class="dataTable">
                <thead>
                    <tr>
                        <th>Restoran</th>
                        <th>Açıklama</th>
                        <th>Fotoğraf</th>
                        <th>Kayıt</th>
                        <th>Güncelle</th>
                        <th>Sil</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($restaurants as $restaurant): ?>
                        <tr class="t<?php echo $_SESSION['role']; ?> dataElement dataTable">
                            <td>
                                <p><?php echo $restaurant["name"]; ?></p>
                            </td>
                            <td>
                                <p><?php echo $restaurant["description"]; ?></p>
                            </td>
                            <td>
                                <img src="<?php echo $restaurant["image_path"]; ?>" alt="Restoran Fotoğrafı" class="company_logo">
                            </td>
                            <td>
                                <p><?php echo $restaurant["created_at"]; ?></p>
                            </td>
                            <td>
                                <a href="update-restaurant.php?r_id=<?php echo $restaurant['id']; ?>"><button>Güncelle</button></a>
                            </td>
                            <td>
                                <form action="../scripts/delete-restaurant.php" method="post">
                                    <input type="hidden" name="restaurant_id" id="restaurant_id" value="<?php echo $restaurant['id']; ?>">
                                    <button type="submit">X</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        <?php } ?>
        <div class="centerDiv">
            <a href="index.php" style="margin-top: 1.5rem;" class=" b<?php echo $_SESSION['role']; ?>"><button>Ana Sayfa</button></a>
        </div>
    </div>
    <?php require_once "footer.php"; ?>
    <script src="../public/js/searchbox.js"></script>
</body>

</html>