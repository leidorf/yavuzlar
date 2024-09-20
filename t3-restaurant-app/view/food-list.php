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
require_once "header.php";
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
    <div class="centerDiv">
        <div class="centerDiv">
            <h1><?php echo $company['name']; ?> Yemekleri</h1>
            <img src="<?php echo $company['logo_path'] ?>" alt="Firma Logosu" class="container_obj company_logo">
            <a href="./add-food.php" class="b<?php echo $_SESSION['role']; ?>"><button>Yemek Ekle</button></a>
        </div>
        <?php if (empty($datas)) {
            echo "<p class='searchbox'>Firmaya ait hiçbir yemek bulunamadı.</p>";
        } else { ?>
            <div class="searchbox">
                <input type="search" id="searchbox" placeholder="Yemek Ara" />
                <div>
                    <label for="isBanned">&nbsp;Silinmiş</label>
                    <input type="checkbox" id="isBanned" />
                </div>
            </div>
                <table class="dataTable container_obj">
                    <thead>
                        <tr>
                            <th>Restoran</th>
                            <th>Fotoğraf</th>
                            <th>Yemek</th>
                            <th>Açıklama</th>
                            <th>Fotoğraf</th>
                            <th>Fiyat</th>
                            <th>İndirim</th>
                            <th>Kayıt</th>
                            <th>Silinme</th>
                            <th>Güncelle</th>
                            <th>Sil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($datas as $data): if ($data['food_name']) { ?>
                                <tr class="t<?php echo $_SESSION['role']; ?> dataElement dataTable" is-banned="<?php echo $data['food_deleted_at'] ? 'true' : 'false'; ?>">
                                    <td>
                                        <p><?php echo $data["restaurant_name"]; ?></p>
                                    </td>
                                    <td>
                                        <img src="<?php echo $data["restaurant_image_path"]; ?>" alt="Restoran Fotoğrafı" class="company_logo">
                                    </td>
                                    <td>
                                        <p><?php echo $data['food_name']; ?></p>
                                    </td>
                                    <td>
                                        <p><?php echo $data['food_description']; ?></p>
                                    </td>
                                    <td>
                                        <img src="<?php echo $data["food_image_path"]; ?>" alt="Yemek Fotoğrafı" class="food_photo">
                                    </td>
                                    <td>
                                        <p><?php echo $data['food_price']; ?></p>
                                    </td>
                                    <td>
                                        <p><?php echo "%" . $data['food_discount']; ?></p>
                                    </td>
                                    <td>
                                        <p><?php echo $data['food_created_at']; ?></p>
                                    </td>
                                    <td>
                                        <p><?php echo $data['food_deleted_at'] ?  'Silindi (' . $data['food_deleted_at'] . ')' : "Mevcut"; ?></p>
                                    </td>
                                    <td>
                                        <a href="update-food.php?f_id=<?php echo $data['food_id']; ?>"><button>Yemeği Güncelle</button></a>
                                    </td>
                                    <?php if ($data['food_deleted_at']): ?>
                                        <td>
                                            <form action="../scripts/readd-food.php" method="post">
                                                <input type="hidden" name="food_id" value="<?php echo $data["food_id"]; ?>">
                                                <button type="submit">+</button>
                                            </form>
                                        </td>
                                    <?php endif ?>
                                    <td>
                                        <form action="../scripts/delete-food.php" method="post">
                                            <input type="hidden" name="food_id" value="<?php echo $data["food_id"]; ?>">
                                            <button type="submit">X</button>
                                        </form>
                                    </td>
                                </tr>
                        <?php }
                        endforeach ?>
                    </tbody>
                </table>
        <?php } ?>
        <div class="centerDiv">
            <a href="index.php" class="clearText b<?php echo $_SESSION['role']; ?>"><button type="button">Ana Sayfa</button></a>
        </div>
    </div>
    <?php require_once "footer.php"; ?>
    <script src="../public/js/searchbox.js"></script>
</body>

</html>