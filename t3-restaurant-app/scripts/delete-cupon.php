<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: ../view/login.php?message=Lütfen giriş yapınız.");
    exit();
} else if ($_SESSION['role'] != 0) {
    header("Location: ../view/index.php?message=403 Yetkisiz Giriş");
} else {
    include "../controllers/admin-controller.php";

    if (isset($_POST['cupon_id']) && !empty($_POST['cupon_id'])) {
        $cupon_id = $_POST['cupon_id'];
        DeleteCupon($cupon_id);
        header("Location: ../view/cupons.php");
        exit();
    } else {
        header("Location: ../view/cupons.php?message=Eksik bilgi girdiniz.");
        exit();
    }
}
