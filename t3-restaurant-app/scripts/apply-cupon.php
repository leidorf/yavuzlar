<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: ../view/index.php");
    exit();
} else if ($_SESSION['role'] != 2) {
    header("Location: ../view/index.php?message=403 Yetkisiz Giriş");
}
if (isset($_POST['c_name'])) {
    include "../controllers/customer-controller.php";
    $c_name = $_POST['c_name'];
    $user_id = $_SESSION['user_id'];
    $cupon = GetCuponByName($c_name);
    if (!$cupon) {
        header("Location: ../view/basket.php?message=Kupon bulunamadı");
        exit();
    }
    $_SESSION['cupon'] = [
        'name' => $cupon['name'],
        'discount' => $cupon['discount'],
        'restaurant_id' => $cupon['restaurant_id']
    ];
    header("Location: ../view/basket.php?message=Kupon uygulandı!");
    exit();
} else {
    header("Location: ../view/basket.php?message=Eksik veya hatali bilgi girdiniz.");
    exit();
}
