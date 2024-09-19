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
$restaurant_id = $_GET['r_id'];
$restaurant = GetRestaurantById($restaurant_id);
require_once "header.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <title>Update <?php echo $restaurant['name']; ?></title>
</head>

<body>
    <div class="container">
        <div class="login t<?php echo $_SESSION['role']; ?>">
            <h1><?php echo $restaurant['name']; ?> Restoranını Güncelle</h1>
            <img src="<?php echo $restaurant['image_path']; ?>" alt="Firma Logosu" class="medPhoto">
            <form action="../scripts/update-restaurant-query.php" method="post" enctype="multipart/form-data">
                <div class="container_obj">
                    <input type="hidden" name="restaurant_id" value="<?php echo $restaurant['id']; ?>" />
                </div>
                <div class="container_obj">
                    <label for="name">Ad</label><br>
                    <input type="text" value="<?php echo $restaurant['name']; ?>" placeholder="Restoran Adı" name="name" required />
                </div>
                <div class="container_obj">
                    <label for="description">Açıklama</label><br>
                    <input type="text" value="<?php echo $restaurant['description']; ?>" name="description" placeholder="Açıklama" required />
                </div>
                <div class="container_obj">
                    <label for="image">Restoran Logosu:</label><br>
                    <input type="file" value="<?php echo $restaurant['image_path']; ?>" name="image" accept="image/*" required />
                </div>
                <button type="submit">Güncelle</button>
            </form>
        </div>
    </div>
    <?php require_once "footer.php"; ?>
</body>

</html>