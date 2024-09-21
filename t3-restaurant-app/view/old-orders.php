<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: login.php?message=Lütfen giriş yapınız.");
    exit();
}
include "../controllers/customer-controller.php";
$orders = GetOrders($_SESSION['user_id']);
require_once "header.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <title>Old Orders</title>
</head>

<body>
    <div class="centerDiv">
        <h1>Eski Siparişleriniz</h1>
        <a href="orders.php" class="container_obj b<?php echo $_SESSION['role']; ?>"><button>Siparişler</button></a>
        <?php
        $completed_orders = array_filter($orders, function ($order) {
            return $order['order_status'] == 2;
        });
        if (empty($completed_orders)) {
            echo "<p>Geçmişe dair herhangi bir eski sipariş bulunamadı.</p>";
        } else {
        ?>
            <div class="searchbox">
                <input type="search" id="searchbox" placeholder="Sipariş Ara" />
            </div>
            <table class="dataTable">
                <thead>
                    <tr>
                        <th>Sipariş Durumu</th>
                        <th>Toplam Fiyat</th>
                        <th>Sipariş Tarihi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): if ($order['order_status'] == 2) { ?>
                            <tr class="dataElement t<?php echo $_SESSION['role']; ?>">
                                <td>
                                    <p><?php switch ($order["order_status"]) {
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
                                        }
                                        ?></p>
                                </td>
                                <td>
                                    <p><?php echo $order["total_price"]; ?></p>
                                </td>
                                <td>
                                    <p><?php echo $order["created_at"]; ?></p>
                                </td>
                            </tr>
                    <?php }
                    endforeach ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
    <div class="centerDiv">
        <a href="index.php"><button>Ana Sayfa</button></a>
    </div>
    <?php require_once "footer.php"; ?>
</body>

</html>