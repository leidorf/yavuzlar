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
    $cupons = GetCupons();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cupons</title>
    </head>

    <body>
        <div class="container">
            <div>
                <h3>Kuponlar</h3>
                <a href="add-cupon.php"><button>Kupon Ekle</button></a>
            </div>
            <?php if (empty($cupons)) {
                echo "<p>Herhangi bir kupon bulunamadı.</p>";
            } else { ?>
                <?php foreach ($cupons as $i => $cupon): ?>
                    <p><?php echo $cupon['id']; ?></p>
                    <p><?php echo $cupon['restaurant_id']; ?></p>
                    <p><?php echo $cupon['name']; ?></p>
                    <p><?php echo $cupon['discount']; ?></p>
                    <p><?php echo $cupon['created_at']; ?></p>
                    <form action="../scripts/delete-cupon.php" method="post">
                        <input type="hidden" name="cupon_id" value="<?php echo $cupon['id']; ?>" />
                        <button type="submit">X</button>
                    </form>
                <?php endforeach ?>
            <?php } ?>
        </div>

        <a href="index.php"><button type="button">Ana Sayfa</button></a>
    </body>

    </html>
<?php } ?>