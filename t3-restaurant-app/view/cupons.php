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
    require_once "header.php";
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../public/css/style.css">
        <title>Cupons</title>
    </head>

    <body>
        <div class="">
            <div>
                <h1 class="searchbox">Kuponlar</h1>
                <a href="add-cupon.php" class="searchbox"><button>Kupon Ekle</button></a>
            </div>
            <?php if (empty($cupons)) {
                echo "<p>Herhangi bir kupon bulunamadı.</p>";
            } else { ?>
                <div class="searchbox">
                    <input
                        type="search"
                        id="searchbox"
                        onchange="liveSearch()"
                        placeholder="Kupon Ara" />
                </div>
                <div class="dataDiv">
                    <p>ID</p>
                    <p>Restoran ID</p>
                    <p>Ad</p>
                    <p>İndirim</p>
                    <p>Kayıt</p>
                    <p>Sil</p>
                </div>
                <?php foreach ($cupons as $i => $cupon): ?>
                    <div class="customerDiv">
                        <div class="dataDiv t<?php echo $_SESSION['role']; ?>">
                            <p><?php echo $cupon['id']; ?></p>
                            <p><?php echo $cupon['restaurant_id'] ? $cupon['restaurant_id'] : "Genel"; ?></p>
                            <p><?php echo $cupon['name']; ?></p>
                            <p><?php echo $cupon['discount']; ?></p>
                            <p><?php echo $cupon['created_at']; ?></p>
                            <form action="../scripts/delete-cupon.php" method="post">
                                <input type="hidden" name="cupon_id" value="<?php echo $cupon['id']; ?>" />
                                <button style="margin-top: 1rem;" type="submit">X</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php } ?>
        </div>

        <a href="index.php" style="margin-top: 1.5rem;" class="searchbox"><button>Ana Sayfa</button></a>
        <?php require_once "footer.php"; ?>
        <script src="../public/js/customer-list.js"></script>
    </body>

    </html>
<?php } ?>