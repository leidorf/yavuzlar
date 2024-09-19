<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: ../view/login.php?message=Lütfen giriş yapınız.");
    exit();
} else if ($_SESSION['role'] != 1) {
    header("Location: ../view/index.php?message=403 Yetkisiz Giriş");
} else {
    include "../controllers/company-controller.php";

    if (isset($_POST['food_id']) && !empty($_POST['food_id'])) {
        $food_id = $_POST['food_id'];
        ReaddFood($food_id);
        header("Location: ../view/food-list.php");
        exit();
    } else {
        header("Location: ../view/food-list.php?message=Eksik bilgi girdiniz.");
        exit();
    }
}
