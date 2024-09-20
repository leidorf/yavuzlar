<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: login.php?message=Lütfen giriş yapınız.");
    exit();
} else if ($_SESSION['role'] != 0) {
    header("Location: index.php?message=403 Yetkisiz Giriş");
} else {
    include "../controllers/admin-controller.php";
    $company_id = $_GET['c_id'];
    $datas = GetCompanyFoods($company_id);
    require_once "header.php";
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../public/css/style.css">
        <title>Company Foods</title>
    </head>

    <body>
        <div class="centerDiv">
            <h1>Firmanın Yemekleri</h1>
            <div>
                <?php if (empty($datas)) {
                    echo "<p class='centerDiv'>Firmaya ait herhangi bir yemek bulunamadı.</p>";
                } else { ?>
                    <div class="searchbox">
                        <input type="search" id="searchbox" placeholder="Yemek Ara" />
                        <div>
                            <label for="isBanned">&nbsp;Silindi mi?</label>
                            <input type="checkbox" id="isBanned" />
                        </div>
                    </div>
                    <table class="dataTable">
                        <thead>
                            <tr>
                                <th>R ID</th>
                                <th>C ID</th>
                                <th>Restoran</th>
                                <th>Açıklama</th>
                                <th>Fotoğraf</th>
                                <th>Kayıt</th>
                                <th>Y ID</th>
                                <th>Yemek</th>
                                <th>Açıklama</th>
                                <th>Fotoğraf</th>
                                <th>Fiyat</th>
                                <th>İndirim</th>
                                <th>Kayıt</th>
                                <th>Silinme</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($datas as $data): ?>
                                <?php if ($data['food_name']) { ?>
                                    <tr class="t<?php echo $_SESSION['role']; ?> dataElement dataTable" is-banned="<?php echo $data['food_deleted_at'] ? 'true' : 'false'; ?>">
                                        <td>
                                            <p><?php echo $data["restaurant_id"]; ?></p>
                                        </td>
                                        <td>
                                            <p><?php echo $data["restaurant_company_id"]; ?></p>
                                        </td>
                                        <td>
                                            <p><?php echo $data["restaurant_name"]; ?></p>
                                        </td>
                                        <td>
                                            <p><?php echo $data["restaurant_description"]; ?></p>
                                        </td>
                                        <td>
                                            <img src="<?php echo $data['restaurant_image_path'] ?>" alt="Restoran Logosu" class="company_logo" title="<?php echo $data["restaurant_image_path"]; ?>">
                                        </td>
                                        <td>
                                            <p><?php echo $data["restaurant_created_at"]; ?></p>
                                        </td>
                                        <td>
                                            <p><?php echo $data["food_id"]; ?></p>
                                        </td>
                                        <td>
                                            <p><?php echo $data["food_name"]; ?></p>
                                        </td>
                                        <td>
                                            <p><?php echo $data["food_description"]; ?></p>
                                        </td>
                                        <td>
                                            <img src="<?php echo $data['food_image_path'] ?>" alt="Yemek Fotoğrafı" class="food_photo" title="<?php echo $data["food_image_path"]; ?>">
                                        </td>
                                        <td>
                                            <p><?php echo $data["food_price"]; ?></p>
                                        </td>
                                        <td>
                                            <p><?php echo $data["food_discount"]; ?></p>
                                        </td>
                                        <td>
                                            <p><?php echo $data["food_created_at"]; ?></p>
                                        </td>
                                        <td>
                                            <p><?php echo $data["food_deleted_at"] ? "Silindi (" . $data["food_deleted_at"] . ")" : "Mevcut" ?></p>
                                        </td>
                                    </tr>
                            <?php }
                            endforeach ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
            <?php require_once "footer.php"; ?>
            <script src="../public/js/searchbox.js"></script>
    </body>

    </html>
<?php } ?>