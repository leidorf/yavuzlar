<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: ../view/index.php");
    exit();
} else if ($_SESSION['role'] != 2) {
    header("Location: ../view/index.php?message=403 Yetkisiz Giriş");
}
include "../controllers/customer-controller.php";
$user_id = $_SESSION['user_id'];
ConfirmBasket($user_id);
header("Location: ../view/orders.php");
exit();
