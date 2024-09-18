<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: ../view/login.php?message=Lütfen giriş yapınız.");
    exit();
} else if ($_SESSION['role'] != 0) {
    header("Location: ../view/index.php?message=403 Yetkisiz Giriş");
} else {
    if (isset($_POST['name']) && isset($_POST['discount']) && $_POST['discount'] > 0 && $_POST['discount'] <= 100) {
        include "../controllers/admin-controller.php";
        $restaurant_id = !empty($_POST['restaurant']) ? $_POST['restaurant'] : null;
        $name = $_POST['name'];
        $discount = $_POST['discount'];
        AddCupon($restaurant_id, $name, $discount);
        header("Location: ../view/cupons.php?Kupon başarıyla eklendi!");
        exit();
    }
    header("Location: ../view/cupons.php?Kupon eklenirken bir hata oluştu");
    exit();
}
