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
    <title>Add Food for <?php echo $_SESSION['company_id']; ?></title>
</head>

<body>
    <div class="container">
        <div class="login t<?php echo $_SESSION['role']; ?>">
            <form action="../scripts/add-food-query.php" method="post" enctype="multipart/form-data">
                <h1>Yemek Ekle</h1>
                <div>
                    <div class="container_obj">
                        <label for="name">Yemek Adı:</label><br>
                        <input type="text" name="name" placeholder="Yemek Adı" required />
                    </div>

                    <div class="container_obj">
                        <label for="description">Açıklama:</label><br>
                        <input type="text" name="description" placeholder="Açıklama" required />
                    </div>

                    <div class="container_obj">
                        <label for="image">Yemek Fotoğrafı:</label><br>
                        <input type="file" name="image" accept="image/*" required>
                    </div>

                    <div class="container_obj">
                        <label for="price">Yemek Fiyatı:</label><br>
                        <input type="number" min="1" name="price" placeholder="Yemek Fiyatı" required />
                    </div>

                    <div class="container_obj">
                        <label for="discount">İndirim:</label><br>
                        <input type="number" min="0" max="100" name="discount" placeholder="İndirim" required />
                    </div>

                    <div class="container_obj">
                        <label for="restaurant_id">Restoran:</label><br>
                        <select name="restaurant_id" id="restaurant_id">
                            <?php foreach ($restaurants as $restaurant): ?>
                                <option value="<?php echo $restaurant['id']; ?>"><?php echo $restaurant['name']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <button type="submit">Ekle</button>
            </form>
        </div>
    </div>
    <?php require_once "footer.php"; ?>
</body>

</html>