<?php
session_start();
include "../controllers/auth-controller.php";
if(isset($_POST['username']) && isset($_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    if(Login($username,$password)){
        header("Location: ../view/index.php");
        exit();
    }else{
        header("Location: ../view/login.php?message=Hatalı kullanıcı adı veya şifre");
        exit();
    }
}else{
    header("Location: ../view/index.php?message=Kullanıcı adı veya şifre boş bırakılamaz");
    exit();
}