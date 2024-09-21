<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: ../view/login.php?message=Lütfen giriş yapınız.");
    exit();
} else if ($_SESSION['role'] != 1) {
    header("Location: ../view/index.php?message=403 Yetkisiz Giriş");
} else {
    if (isset($_POST['o_id']) && ($_POST['value'] == 1 || $_POST['value'] == -1)) {
        include "../controllers/company-controller.php";
        $order_id = $_POST['o_id'];
        $value = $_POST['value'];
        UpdateOrderStatus($order_id, $value);
        header("Location: ../view/customer-orders.php");
    }
    header("Location: ../view/customer-orders.php?message=Eksik veya hatalı bilgi girdiniz.");
    exit();
}
