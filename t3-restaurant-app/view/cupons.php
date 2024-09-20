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
        <div class="centerDiv">
            <div class="centerDiv">
                <h1>Kuponlar</h1>
                <a href="add-cupon.php" class=" cleanText"><button>Kupon Ekle</button></a>
            </div>
            <?php if (empty($cupons)) {
                echo "<p>Herhangi bir kupon bulunamadı.</p>";
            } else { ?>
                <div class="searchbox">
                    <input type="search" id="searchbox" placeholder="Kupon Ara" />
                </div>
                <table class="dataTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Restoran ID</th>
                            <th>Ad</th>
                            <th>İndirim</th>
                            <th>Kayıt</th>
                            <th>Güncelle</th>
                            <th>Sil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cupons as $cupon): ?>
                            <tr class="t<?php echo $_SESSION['role']; ?> dataElement dataTable">
                                <td>
                                    <p><?php echo $cupon['id']; ?></p>
                                </td>
                                <td>
                                    <p><?php echo $cupon['restaurant_id'] ?: "Genel"; ?></p>
                                </td>
                                <td>
                                    <p><?php echo $cupon['name']; ?></p>
                                </td>
                                <td>
                                    <p><?php echo "%" . $cupon['discount']; ?></p>
                                </td>
                                <td>
                                    <p><?php echo $cupon['created_at']; ?></p>
                                </td>
                                <td>
                                    <a href="update-cupon.php?c_id=<?php echo $cupon['id']; ?>"><button>Güncelle</button></a>
                                </td>
                                <td>
                                    <form action="../scripts/delete-cupon.php" method="post">
                                        <input type="hidden" name="cupon_id" value="<?php echo $cupon['id']; ?>" />
                                        <button type="submit">X</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>

        <a href="index.php" style="margin-top: 1.5rem;" class="searchbox cleanText"><button>Ana Sayfa</button></a>
        <?php require_once "footer.php"; ?>
        <script src="../public/js/searchbox.js"></script>
    </body>

    </html>
<?php } ?>