<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: ../view/index.php");
    exit();
}else if ($_SESSION['role'] != 2) {
    header("Location: ../view/index.php?message=403 Yetkisiz Giriş");
}
if (isset($_POST['c_id'])) {
    include "../controllers/customer-controller.php";
    $comment_id = $_POST['c_id'];
    DeleteComment($comment_id);
    header("Location: ../view/foods.php");
    exit();
} else {
    header("Location: ../view/foods.php?message=Eksik veya hatali bilgi girdiniz.");
    exit();
}
