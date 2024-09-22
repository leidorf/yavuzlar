<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: login.php?message=Lütfen giriş yapınız.");
    exit();
} else if ($_SESSION['role'] != 2) {
    header("Location: ../view/index.php?message=403 Yetkisiz Giriş");
}
include "../controllers/customer-controller.php";
include "../controllers/admin-controller.php";
$datas = GetBasket($_SESSION['user_id']);
require_once "header.php";
$total_price = 0;
$applied_discount = 0;
$cupon = isset($_SESSION['cupon']) ? $_SESSION['cupon'] : null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <title>Basket</title>
</head>

<body>
    <div>
        <h1 class="searchbox">Sepet</h1>
        <?php if (empty($datas)) {
            echo "<p class='searchbox'>Sepetiniz boş.</p>";
        } else { ?>
            <div class="searchbox">
                <input type="search" id="searchbox" placeholder="Yemek Ara" />
            </div>
            <div class="centerDiv">

                <table class="dataTable">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Yemek</th>
                            <th></th>
                            <th>Fiyat</th>
                            <th>İndirim</th>
                            <th>Restoran</th>
                            <th>Sipariş Notu</th>
                            <th>Adet</th>
                            <th>Sil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($datas as $data): ?>
                            <tr class="dataElement dataTable t<?php echo $_SESSION['role']; ?>">
                                <td>
                                    <img class="food_photo" src="<?php echo $data["food_image_path"]; ?>" alt="Yemek Fotoğrafı">
                                </td>
                                <td>
                                    <p><?php echo $data["food_name"]; ?></p>
                                </td>
                                <td>
                                    <p style="text-wrap:nowrap;" class="description"><?php echo $data["food_description"]; ?></p>
                                </td>
                                <td>
                                    <p class="<?php echo $data['food_discount'] ? "highlight" . $_SESSION['role'] : ""; ?>">
                                        <?php
                                        $price = $data['food_discount'] ? $data['food_price'] * (100 - $data['food_discount']) / 100 : $data['food_price'];
                                        if ($cupon) {
                                            if ($cupon['restaurant_id'] === null || $cupon['restaurant_id'] == $data['food_restaurant_id']) {
                                                $discount_amount = $price * ($cupon['discount'] / 100);
                                                $price -= $discount_amount;
                                                $applied_discount += $discount_amount * $data['basket_quantity'];
                                            }
                                        }
                                        echo $price; ?>
                                    </p>
                                </td>
                                <td>
                                    <p><?php echo $data['food_discount'] > 0 ? "%" . $data["food_discount"] . "!" : ""; ?></p>
                                </td>
                                <td>
                                    <p><?php echo GetRestaurantName($data['food_restaurant_id']); ?></p>
                                </td>
                                <td>
                                    <p style="text-wrap:nowrap;" class="modalBtn description" data_id="<?php echo $data['basket_id']; ?>"><?php echo $data["basket_note"]; ?></p>
                                </td>
                                <td class="quantityContainer">
                                    <form action="../scripts/edit-quantity.php" method="post">
                                        <input type="hidden" name="basket_id" value="<?php echo $data['basket_id']; ?>">
                                        <input type="hidden" name="value" value="-1">
                                        <button type="submit" class="editQuantity">-</button>
                                    </form>
                                    <p><?php echo $data["basket_quantity"]; ?></p>
                                    <form action="../scripts/edit-quantity.php" method="post">
                                        <input type="hidden" name="basket_id" value="<?php echo $data['basket_id']; ?>">
                                        <input type="hidden" name="value" value="1">
                                        <button type="submit" class="editQuantity">+</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="../scripts/delete-basket-item.php" method="post">
                                        <input type="hidden" name="basket_id" value="<?php echo $data['basket_id']; ?>">
                                        <button type="submit" style="background-color: var(--admin);">X</button>
                                    </form>
                                </td>
                            </tr>
                        <?php
                            $total_price += $price * $data['basket_quantity'];
                        endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="centerDiv ">
                <form action="../scripts/apply-cupon.php" method="post">
                    <label for="c_name">Kupon Giriniz:</label>
                    <input type="text" name="c_name">
                    <button type="submit">Uygula</button>
                </form>
                <p>
                    Toplam Fiyat: <?php echo $total_price; ?>
                </p>
                <form action="../scripts/confirm-basket.php" method="post">
                    <button type="submit">Onayla</button>
                </form>
            </div>
    </div>
<?php } ?>
</div>
<div class="centerDiv">
    <a href="index.php" class="b<?php echo $_SESSION['role']; ?>"><button>Ana Sayfa</button></a>
</div>
<div id="modal" class="modal">
    <div class="modal-content centerDiv">
        <h3>Notu Güncelle</h3>
        <form action="../scripts/edit-note.php" method="post" class="centerDiv">
            <input hidden id="data_id" name="basket_id" value="">
            <input name="note" class="container_obj" type="text" placeholder="Notu güncelleyin">
            <button type="submit" class="normal container_obj">Düzenle</button>
        </form>
        <button class="close red">İptal</button>
    </div>
</div>
<?php require_once "footer.php"; ?>
</body>
<script src="../public/js/searchbox.js"></script>
<script src="../public/js/modal.js"></script>

</html>