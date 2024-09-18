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
$food_id = $_GET['f_id'];
$food = GetFoodById($food_id);
$restaurants = GetRestaurantByCId($_SESSION['company_id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <title>Update Food <?php echo $food_id; ?></title>
</head>

<body>
    <div>
        <a href="food-list.php"> <button type="button">←</button> </a>
        <h3><?php echo $food_id; ?> Numaralı Yemeği Güncelle</h3>
        <img src="<?php echo $food['image_path']; ?>" alt="Yemek Fotoğrafı" class="food_photo" >
        <form action="../scripts/update-food-query.php" method="post" enctype="multipart/form-data">
            <h3>Yemek Ekle</h3>
            <div>
                <input type="hidden" name="food_id" value="<?php echo $food_id; ?>">

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

</body>

</html>