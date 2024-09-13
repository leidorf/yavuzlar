<?php
session_start();
include "../controllers/auth-controller.php";
if (IsUserLoggedIn()) {
    header("Location: ../view/index.php");
    exit();
}
if (isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['username']) && isset($_POST['password'])) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    Register($name, $surname, $username, $password);
    header("Location: ../view/login.php");
    exit();
} else {
    header("Location: ../view/login.php?message=Eksik bilgi girdiniz.");
    exit();
}
