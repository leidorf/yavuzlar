<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: login.php?message=Lütfen giriş yapınız.");
    exit();
}
include "../controllers/customer-controller.php";
$foods = GetFoods();
require_once "header.php";
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
    <div class="">
        <h1 class="searchbox">Yemekler</h1>
        <?php if (empty($foods)) {
            echo "<p class='searchbox'>Hiçbir yemek bulunamadı.</p>";
        } else { ?>
            <div class="searchbox">
                <input
                    type="search"
                    id="searchbox"
                    onchange="liveSearch()"
                    placeholder="Yemek Ara" />
            </div>
            <div class="dataDiv">
                    <p>Ad</p>
                    <p>Açıklama</p>
                    <p>Fotoğraf</p>
                    <p>Fiyat</p>
                    <p>İndirim</p>
                </div>
            <?php foreach ($foods as $food): ?>
                <div class="customerDiv">
                    <div class="foodDiv">
                        <img class="food_photo" src="<?php echo $food["image_path"]; ?>" alt="Yemek Fotoğrafı" class="food_photo">
                        <p><?php echo $food["name"]; ?></p>
                        <p><?php echo $food["description"]; ?></p>
                        <p><?php echo $food["price"]; ?></p>
                        <p><?php echo $food["discount"]? "%". $food['discount']: "indirim yoq" ; ?></p>
                    </div>
                </div>
            <?php endforeach ?>
        <?php } ?>
    </div>
    <a href="index.php"><button type="button">Ana Sayfa</button></a>
    <?php require_once "footer.php"; ?>
    <script src="../public/js/customer-list.js"></script>
</body>

</html>