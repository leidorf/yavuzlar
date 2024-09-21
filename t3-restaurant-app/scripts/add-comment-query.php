<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: ../view/index.php");
    exit();
} else if ($_SESSION['role'] != 2) {
    header("Location: ../view/index.php?message=403 Yetkisiz Giriş");
}
if (isset($_POST['restaurant_id']) && isset($_POST['title']) && isset($_POST['description']) && isset($_POST['score']) && $_POST['score'] >= 0 && $_POST['score'] <= 10) {
    include "../controllers/customer-controller.php";
    $restaurant_id = $_POST['restaurant_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $score = $_POST['score'];
    AddComment($restaurant_id, $title, $description, $score);
    header("Location: ../view/restaurant.php?r_id=" . $restaurant_id);
    exit();
} else {
    header("Location: ../view/restaurant.php?r_id=" . $restaurant_id . "?message=Eksik veya hatali bilgi girdiniz.");
    exit();
}
