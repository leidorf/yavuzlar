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

    if (isset($_POST['restaurant_id']) && !empty($_POST['restaurant_id'])) {
        $restaurant_id = $_POST['restaurant_id'];
        DeleteRestaurant($restaurant_id);
        header("Location: ../view/restaurant-list.php");
        exit();
    } else {
        header("Location: ../view/restaurant-list.php?message=Eksik bilgi girdiniz.");
        exit();
    }
}
