<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: ../view/index.php");
    exit();
} else if ($_SESSION['role'] != 2) {
    header("Location: ../view/index.php?message=403 Yetkisiz Giriş");
}
if (isset($_POST['basket_id']) && isset($_POST['note'])) {
    include "../controllers/customer-controller.php";
    $basket_id = $_POST['basket_id'];
    $note = $_POST['note'];
    EditNote($basket_id, $note);
    header("Location: ../view/basket.php");
    exit();
} else {
    header("Location: ../view/basket.php?message=Eksik veya hatali bilgi girdiniz.");
    exit();
}
