<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: ../view/index.php");
    exit();
}else if ($_SESSION['role'] != 2) {
    header("Location: ../view/index.php?message=403 Yetkisiz Giriş");
}
if (isset($_POST['basket_id'])) {
    include "../controllers/customer-controller.php";
    $basket_id = $_POST['basket_id'];
    DeleteFromBasket($basket_id);
    header("Location: ../view/basket.php");
    exit();
} else {
    header("Location: ../view/basket.php?message=Eksik veya hatali bilgi girdiniz.");
    exit();
}
