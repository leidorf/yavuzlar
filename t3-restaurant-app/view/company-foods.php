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
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Company Foods</title>
    </head>

    <body>
        <div class="container">
            <h3>Firmanın Yemekleri</h3>
            <div>
                <?php if (empty($datas)) {
                    echo "<p>Firmaya ait herhangi bir yemek bulunamadı.</p>";
                } else { ?>
                    <?php foreach ($datas as $i => $data): ?>
                        <p><?php echo $data["restaurant_id"]; ?></p>
                        <p><?php echo $data["restaurant_company_id"]; ?></p>
                        <p><?php echo $data["restaurant_name"]; ?></p>
                        <p><?php echo $data["restaurant_description"]; ?></p>
                        <p><?php echo $data["restaurant_image_path"]; ?></p>
                        <p><?php echo $data["restaurant_created_at"]; ?></p>
                        <p><?php echo $data["food_id"]; ?></p>
                        <p><?php echo $data["food_name"]; ?></p>
                        <p><?php echo $data["food_description"]; ?></p>
                        <p><?php echo $data["food_image_path"]; ?></p>
                        <p><?php echo $data["food_price"]; ?></p>
                        <p><?php echo $data["food_discount"]; ?></p>
                        <p><?php echo $data["food_created_at"]; ?></p>
                        <p><?php echo $data["food_deleted_at"]; ?></p>
                    <?php endforeach ?>
                <?php } ?>
            </div>
        </div>
    </body>

    </html>
<?php } ?>