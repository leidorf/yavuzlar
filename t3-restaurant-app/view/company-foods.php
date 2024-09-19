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
        <div class="">
            <h1 class="centerDiv">Firmanın Yemekleri</h1>
            <div>
                <?php if (empty($datas)) {
                    echo "<p class='centerDiv'>Firmaya ait herhangi bir yemek bulunamadı.</p>";
                } else { ?>
                    <div class="searchbox">
                        <input
                            type="search"
                            id="searchbox"
                            onchange="liveSearch()"
                            placeholder="Müşteri Ara" />
                        <div>
                            <label for="isBanned">&nbsp;Silindi mi?</label>
                            <input type="checkbox" id="isBanned" />
                        </div>
                    </div>
                    <div class="dataDiv">
                        <p>R ID</p>
                        <p>C ID</p>
                        <p>R Adı</p>
                        <p>R Açıklama</p>
                        <p>R Foto</p>
                        <p>R Kayıt</p>
                        <p>Y ID</p>
                        <p>Y Adı</p>
                        <p>Y Açıklama</p>
                        <p>Y Foto</p>
                        <p>Fiyat</p>
                        <p>İndirim</p>
                        <p>Kayıt</p>
                        <p>Silinme</p>
                    </div>
                    <?php foreach ($datas as $i => $data):
                        if ($data['food_name']) {
                    ?>
                            <div class="customerDiv">
                                <div class="dataDiv t<?php echo $_SESSION['role']; ?>">
                                    <p><?php echo $data["restaurant_id"]; ?></p>
                                    <p><?php echo $data["restaurant_company_id"]; ?></p>
                                    <p><?php echo $data["restaurant_name"]; ?></p>
                                    <p><?php echo $data["restaurant_description"]; ?></p>
                                    <img src="<?php echo $data['restaurant_image_path'] ?>" alt="Restoran Logosu" class="company_logo" title="<?php echo $data["restaurant_image_path"]; ?>">
                                    <p><?php echo $data["restaurant_created_at"]; ?></p>
                                    <p><?php echo $data["food_id"]; ?></p>
                                    <p><?php echo $data["food_name"]; ?></p>
                                    <p><?php echo $data["food_description"]; ?></p>
                                    <img src="<?php echo $data['food_image_path'] ?>" alt="Yemek Fotoğrafı" class="food_photo" title="<?php echo $data["food_image_path"]; ?>">
                                    <p><?php echo $data["food_price"]; ?></p>
                                    <p><?php echo $data["food_discount"]; ?></p>
                                    <p><?php echo $data["food_created_at"]; ?></p>
                                    <p><?php echo $data["food_deleted_at"] ? "Silindi (" . $data["food_deleted_at"] . ")" : "Mevcut" ?></p>
                                </div>
                            </div>
                    <?php }
                    endforeach ?>
                <?php } ?>
            </div>
        </div>
        <?php require_once "footer.php"; ?>
        <script src="../public/js/customer-list.js"></script>
    </body>

    </html>
<?php } ?>