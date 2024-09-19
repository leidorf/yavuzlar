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
    require_once "header.php";
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Cupon</title>
    </head>

    <body>
        <div>
            <a href="cupons.php"> <button type="button">←</button> </a>
            <form action="../scripts/add-cupon-query.php" method="post" enctype="multipart/form-data">
                <h3>Kupon Ekle</h3>
                <div>
                    <input type="text" name="name" placeholder="Kupon Adı" required />
                    <label for="discount">İndirim:</label>
                    <input type="number" min="1" max="100" name="discount" placeholder="İndirim" required />
                    <label for="restaurant">Restoran:</label>
                    <select name="restaurant">
                        <option value="" selected="selected">BOŞ</option>
                        <?php foreach ($restaurants as $restaurant): ?>
                            <option value="<?php echo $restaurant['id']; ?>"><?php echo $restaurant['name']; ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <button type="submit">Kaydet</button>
            </form>
        </div>
        <?php require_once "footer.php"; ?>
    </body>

    </html>
<?php } ?>