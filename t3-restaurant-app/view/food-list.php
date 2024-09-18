<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: login.php?message=Lütfen giriş yapınız.");
    exit();
} else if ($_SESSION['role'] != 1) {
    header("Location: index.php?message=403 Yetkisiz Giriş");
}
include "../controllers/admin-controller.php";
$company = GetCompanyById($_SESSION['company_id']);
$datas = GetCompanyFoods($_SESSION['company_id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <title>Foods of <?php echo $company['name']; ?></title>
</head>

<body>
    <div>
        <h3><?php echo $company['name']; ?> Adlı Firmanın Yemekleri</h3>
        <img src="<?php echo $company['logo_path'] ?>" alt="Firma Logosu" class="company_logo">
        <a href="./add-food.php"><button type="button">Yemek Ekle</button></a>
        <?php if (empty($datas)) {
            echo "<p>Firmaya ait hiçbir yemek bulunamadı.</p>";
        } else { ?>
            <div>
                <input
                    type="search"
                    id="searchbox"
                    onchange="liveSearch()"
                    placeholder="Yemek Ara" />
                <div>
                    <label for="isBanned">Silindi mi?</label>
                    <input type="checkbox" id="isBanned" />
                </div>
            </div>
            <?php foreach ($datas as $data): ?>
                <?php if ($data['food_name']) { ?>
                    <div class="customerDiv food_div" is-banned="<?php echo $company['deleted_at'] ? 'true' : 'false'; ?>">
                        <p><?php echo $data["restaurant_name"]; ?></p>
                        <img src="<?php echo $data["restaurant_image_path"]; ?>" alt="Restoran Fotoğrafı" class="company_logo">
                        <p><?php echo $data['food_name']; ?></p>
                        <p><?php echo $data['food_description']; ?></p>
                        <img src="<?php echo $data["food_image_path"]; ?>" alt="Yemek Fotoğrafı" class="food_photo">
                        <p><?php echo $data['food_price']; ?></p>
                        <p><?php echo $data['food_discount']; ?></p>
                        <p><?php echo $data['food_created_at']; ?></p>
                        <a href="update-food.php?f_id=<?php echo $data['food_id']; ?>"><button>Yemeği Güncelle</button></a>
                        <p><?php echo $data['food_deleted_at'] ?  'Silindi (' . $data['food_deleted_at'] . ')' : "Mevcut"; ?></p>
                        <form action="../scripts/delete-food.php" method="post">
                            <input type="hidden" name="food_id" value="<?php echo $data["food_id"]; ?>">
                            <button type="submit">X</button>
                        </form>
                    </div>
            <?php }
            endforeach ?>
        <?php } ?>
        <a href="index.php"><button type="button">Ana Sayfa</button></a>
    </div>
    <script src="../public/js/customer-list.js"></script>
</body>

</html>