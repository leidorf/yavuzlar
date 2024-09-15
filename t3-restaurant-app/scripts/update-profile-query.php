<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: ../view/index.php");
    exit();
}
if (isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['username'])) {
    include "../controllers/customer-controller.php";
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $username = $_POST['username'];
    UpdateProfile($name, $surname, $username);
    header("Location: ../view/profile.php");
    exit();
} else {
    header("Location: ../view/profile.php?message=Eksik bilgi girdiniz.");
    exit();
}
