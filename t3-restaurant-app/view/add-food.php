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
    <title>Add Food for <?php echo $_SESSION['company_id']; ?></title>
</head>

<body>
    <div>
        <a href="food-list.php"> <button type="button">←</button> </a>
        <form action="../scripts/add-food-query.php" method="post" enctype="multipart/form-data">
            <h3>Yemek Ekle</h3>
            <div>
                <label for="name">Yemek Adı:</label>
                <input type="text" name="name" placeholder="Yemek Adı" required />

                <label for="description">Açıklama:</label>
                <input type="text" name="description" placeholder="Açıklama" required />

                <label for="image">Yemek Fotoğrafı:</label>
                <input type="file" name="image" accept="image/*" required>

                <label for="price">Yemek Fiyatı:</label>
                <input type="number" min="1" name="price" placeholder="Yemek Fiyatı" required />

                <label for="discount">İndirim:</label>
                <input type="number" min="0" max="100" name="discount" placeholder="İndirim" required />

                <label for="restaurant_id">Restoran:</label>
                <select name="restaurant_id" id="restaurant_id">
                    <?php foreach ($restaurants as $restaurant): ?>
                        <option value="<?php echo $restaurant['id']; ?>"><?php echo $restaurant['name']; ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <button type="submit">Ekle</button>
        </form>
    </div>
    <?php require_once "footer.php"; ?>
</body>

</html>