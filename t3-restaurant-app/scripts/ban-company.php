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

    if (isset($_POST['company_id']) && !empty($_POST['company_id']) ) {
        $company_id = $_POST['company_id']; 
        BanCompany($company_id);
        header("Location: ../view/company-list.php");
        exit();
    } else {
        header("Location: ../view/company-list.php?message=Eksik bilgi girdiniz.");
        exit();
    }
}
