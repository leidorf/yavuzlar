<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: login.php?message=Lütfen giriş yapınız.");
    exit();
}
include "../controllers/customer-controller.php";
$foods = GetFoods();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <title>Foods</title>
</head>

<body>
    <div class="container">
        <h3>Yemekler</h3>
        <?php if (empty($foods)) {
            echo "<p>Hiçbir yemek bulunamadı.</p>";
        } else { ?>
            <div>
                <input
                    type="search"
                    id="searchbox"
                    onchange="liveSearch()"
                    placeholder="Yemek Ara" />
            </div>
            <?php foreach ($foods as $food): ?>
                <div class="customerDiv">
                    <div class="food_div">
                        <p><?php echo $food["name"]; ?></p>
                        <p><?php echo $food["description"]; ?></p>
                        <img class="food_photo" src="<?php echo $food["image_path"]; ?>" alt="Yemek Fotoğrafı" class="food_photo">
                        <p><?php echo $food["price"]; ?></p>
                        <p><?php echo $food["discount"]; ?></p>
                    </div>
                </div>
            <?php endforeach ?>
        <?php } ?>
    </div>
    <a href="index.php"><button type="button">Ana Sayfa</button></a>
    <script src="../public/js/customer-list.js"></script>
</body>

</html>