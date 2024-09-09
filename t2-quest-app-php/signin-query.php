<?php
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    header('Location: index.php?message=You are already logged in!');
    exit();
}
include "functions/functions.php";

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = htmlclean($_POST['username']);
    $password = htmlclean($_POST['password']);
    SignIn($username,$password);
    header("Location: login.php");
    exit();
} else {
    header("Location: login.php?message=Eksik bilgi girdiniz.");
    exit();
}
