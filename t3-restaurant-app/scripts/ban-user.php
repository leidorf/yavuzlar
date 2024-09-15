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

    if (isset($_POST['id']) && !empty($_POST['id']) && is_integer($_POST['id']) ) {
        $user_id = $_POST['id']; 
        BanUser($user_id);
        header("Location: ../view/customer-list.php");
        exit();
    } else {
        header("Location: ../view/profile.php?message=Eksik bilgi girdiniz.");
        exit();
    }
}
