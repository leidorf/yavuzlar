<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: ../view/index.php");
    exit();
}
if (isset($_POST['current_password']) && isset($_POST['new_password']) && isset($_POST['confirm_new_password'])) {
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];
    if($new_password==$confirm_new_password){
        include "../controllers/customer-controller.php";
        $current_password = $_POST['current_password'];
        UpdatePassword($current_password, $new_password);
        header("Location: ../view/profile.php");
        exit();
    }else{
        header("Location: ../view/profile.php?message=Lütfen şifrenizi doğrulayınız");
    }
} else {
    header("Location: ../view/profile.php?message=Eksik bilgi girdiniz.");
    exit();
}
