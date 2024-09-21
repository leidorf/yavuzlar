<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: login.php?message=Lütfen giriş yapınız.");
    exit();
} else if ($_SESSION['role'] != 0) {
    header("Location: index.php?message=403 Yetkisiz Giriş");
}
include "../controllers/admin-controller.php";
$user_id = $_GET['u_id'];
$datas = GetUserOrders($user_id);
require_once "header.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <title>Customer Orders</title>
</head>

<body>
    <div class="centerDiv">
        <h1>Kullanıcı Siparişleri</h1>
        <?php if (empty($datas[0]['order_items_id'])) {
            echo "<p>Kullanıcıya ait hiçbir sipariş bulunamadı.</p>";
        } else { ?>
            <div class="searchbox">
                <input type="search" id="searchbox" placeholder="Sipariş Ara" />
            </div>

            <table class="dataTable">
                <thead>
                    <tr>
                        <th>Sipariş No</th>
                        <th>Müşteri</th>
                        <th>Fotoğraf</th>
                        <th>Yemek</th>
                        <th>Açıklama</th>
                        <th>Fiyat</th>
                        <th>Sipariş</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datas as $data): ?>
                        <tr class="t<?php echo $_SESSION['role']; ?> dataElement dataTable">
                            <td>
                                <p><?php echo $data["order_id"]; ?></p>
                            </td>
                            <td>
                                <p><?php echo $data["users_username"]; ?></p>
                            </td>
                            <td>
                                <img class="food_photo" src="<?php echo $data["food_image_path"]; ?>" alt="Yemek Fotoğrafı">
                            </td>
                            <td>
                                <p><?php echo $data["food_name"]; ?></p>
                            </td>
                            <td>
                                <p class="description"><?php echo $data["food_description"]; ?></p>
                            </td>
                            <td>
                                <p><?php echo $data["order_items_quantity"] . " x " . $data["order_items_price"] . " = " . $data["order_items_quantity"] * $data["order_items_price"]; ?></p>
                            </td>
                            <td>
                                <p><?php switch ($data["order_order_status"]) {
                                        case 0:
                                            echo "Hazırlanıyor";
                                            break;
                                        case 1:
                                            echo "Yola Çıktı";
                                            break;
                                        case 2:
                                            echo "Teslim Edildi";
                                            break;
                                        default:
                                            echo "Hata!";
                                            break;
                                    } ?> </p>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        <?php } ?>
        <div class="centerDiv">
            <a href="index.php" style="margin-top: 1.5rem;" class=" b<?php echo $_SESSION['role']; ?>"><button>Ana Sayfa</button></a>
        </div>
    </div>
    <?php require_once "footer.php"; ?>
    <script src="../public/js/searchbox.js"></script>
</body>

</html>