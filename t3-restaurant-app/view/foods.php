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
    <div>
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
            <div class="foodSection">
                <?php foreach ($foods as $food): ?>
                    <div class="customerDiv">
                        <div class="foodDiv t<?php echo $_SESSION['role']; ?>">
                            <div class="imageContainer">
                                <img class="food_photo" src="<?php echo $food["image_path"]; ?>" alt="Yemek Fotoğrafı" class="food_photo">
                                <?php if ($food['discount']) { ?>
                                    <span class="discount"><?php echo "%" . $food["discount"] . "!"; ?></span>
                                <?php } ?>
                            </div>
                            <p><?php echo $food["name"]; ?></p>
                            <span class="description" ><?php echo $food["description"]; ?></span>
                            <p <?php echo $food['discount'] ? "class='highlight" . $_SESSION['role'] . "'>" . $food["price"] * (100 - $food['discount']) / 100 : ">" . $food['price']; ?></p>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php } ?>
    </div>
    <a href="index.php" class="centerDiv b<?php echo $_SESSION['role']; ?>"><button>Ana Sayfa</button></a>
    <?php require_once "footer.php"; ?>
    <script src="../public/js/customer-list.js"></script>
</body>

</html>