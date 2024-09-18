<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: ../view/login.php?message=Lütfen giriş yapınız.");
    exit();
} else if ($_SESSION['role'] != 1) {
    header("Location: ../view/index.php?message=403 Yetkisiz Giriş");
} else {
    if (isset($_POST['name']) && isset($_POST['description']) && isset($_FILES["image"])) {
        include "../controllers/company-controller.php";
        $name = $_POST['name'];
        $description = $_POST['description'];
        $company_id = $_SESSION['company_id'];

        $max_size = 2 * 1024 * 1024;
        $target_dir = "../uploads/restaurant/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $new_file_name = time() . "." . $image_file_type;
        $image_path = $target_dir . $new_file_name;
        if (filesize($_FILES["image"]["tmp_name"]) > $max_size) {
            header("Location: ../view/add-restaurant.php?message=Resim boyutu 2MB altında olmalıdır.");
            exit();
        }
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $image_path)) {
            AddRestaurant($company_id, $name, $description, $image_path);
            header("Location: ../view/restaurant-list.php?message=Başarıyla kaydedildi!");
            exit();
        } else {
            header("Location: ../view/add-restaurant.php?message=Resim yüklenirken bir hata oluştu!");
            exit();
        }
    }
}
