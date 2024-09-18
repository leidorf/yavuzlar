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
    <div>
        <a href="restaurant-list.php"> <button type="button">←</button> </a>
        <h3><?php echo $restaurant['name']; ?> Restoranını Güncelle</h3>
        <img src="<?php echo $restaurant['image_path']; ?>" alt="Firma Logosu" class="company_logo">
        <form action="../scripts/update-restaurant-query.php" method="post" enctype="multipart/form-data">
            <div>
                <input type="hidden" name="restaurant_id" value="<?php echo $restaurant['id']; ?>" />
                <input type="text" value="<?php echo $restaurant['name']; ?>" placeholder="Restoran Adı" name="name" required />
                <input type="text" value="<?php echo $restaurant['description']; ?>" name="description" placeholder="Açıklama" required />
                <label for="image">Restoran Logosu:</label>
                <input type="file" value="<?php echo $restaurant['image_path']; ?>" name="image" accept="image/*" required />
            </div>
            <button type="submit">Güncelle</button>
        </form>
    </div>

</body>

</html>