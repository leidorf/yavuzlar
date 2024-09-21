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
$datas = GetBasket($_SESSION['user_id']);
require_once "header.php";
$totalPrice = 0;
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
                            <th>Fotoğraf</th>
                            <th>Yemek</th>
                            <th>Açıklama</th>
                            <th>Fiyat</th>
                            <th>İndirim</th>
                            <th>Sipariş Notu</th>
                            <th>Sayı</th>
                            <th>Sil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($datas as $data): ?>
                            <tr class="dataElement t<?php echo $_SESSION['role']; ?>">
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
                                    <p <?php echo $data['food_discount'] ? "class='highlight" . $_SESSION['role'] . "'>" . $data["food_price"] * (100 - $data['food_discount']) / 100 : ">" . $data['food_price']; ?></p>
                                </td>
                                <td>
                                    <p><?php echo $data['food_discount'] > 0 ? "%" . $data["food_discount"] . "!" : ""; ?></p>
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
                            <?php if ($data['food_discount'] > 0) {
                                $totalPrice += $data['basket_quantity'] * $data["food_price"] * (100 - $data['food_discount']) / 100;
                            } else {
                                $totalPrice += $data['basket_quantity'] * $data['food_price'];
                            } ?>
                    </tbody>
                </table>
            <?php /* if (GetCuponByRId($data['restaurant_id'])) { ?>
                    <p class="headerText notification"><?php echo $data['restaurant_name']; ?> Restoranında %<?php echo $cupon['discount']; ?> indirim!</p>
            <?php }
                        */ endforeach ?>
            </div>
            <div class="centerDiv ">
                <p>
                    Toplam Fiyat: <?php echo $totalPrice; ?>
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