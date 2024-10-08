<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: ../view/index.php");
    exit();
} else if ($_SESSION['role'] != 2) {
    header("Location: ../view/index.php?message=403 Yetkisiz Giriş");
}
if (isset($_POST['food_id']) && isset($_POST['note'])) {
    include "../controllers/customer-controller.php";
    $food_id = $_POST['food_id'];
    $user_id = $_SESSION['user_id'];
    $note = $_POST['note'];
    AddtoBasket($user_id, $food_id, $note);
    header("Location: ../view/foods.php");
    exit();
} else {
    header("Location: ../view/foods.php?message=Eksik veya hatali bilgi girdiniz.");
    exit();
}
