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
    $restaurants = GetRestaurants();
    $cupon_id = $_GET['c_id'];
    $cupon = GetCuponById($cupon_id);
    require_once "header.php";
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../public/css/style.css">
        <title>Update Cupon <?php echo $cupon['name']; ?></title>
    </head>

    <body>
        <div class="container">
            <div class="login t<?php echo $_SESSION['role']; ?>">
                <h3><?php echo $cupon['name']; ?> Kuponunu Güncelle</h3>
                <form action="../scripts/update-cupon-query.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="cupon_id" value="<?php echo $cupon_id; ?>">
                    <div class="container_obj">
                        <label for="name">Kupon Adı</label><br>
                        <input type="text" name="name" placeholder="Kupon Adı" value="<?php echo $cupon['name']; ?>" required />
                    </div>
                    <div class="container_obj">
                        <label for="discount">İndirim</label><br>
                        <input type="number" min="1" max="100" name="discount" placeholder="İndirim" value="<?php echo $cupon['discount']; ?>" required />
                    </div>
                    <div class="container_obj">
                        <label for="restaurant">Restoran:</label><br>
                        <select name="restaurant">
                            <option value="" selected="selected">Genel</option>
                            <?php foreach ($restaurants as $restaurant): ?>
                                <option value="<?php echo $restaurant['id']; ?>"><?php echo $restaurant['name']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <button type="submit">Kaydet</button>
                </form>
            </div>
        </div>
        <?php require_once "footer.php"; ?>
    </body>

    </html>
<?php } ?>