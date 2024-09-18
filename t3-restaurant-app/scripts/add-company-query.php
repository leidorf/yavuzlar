<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: ../view/login.php?message=Lütfen giriş yapınız.");
    exit();
} else if ($_SESSION['role'] != 0) {
    header("Location: ../view/index.php?message=403 Yetkisiz Giriş");
} else {
    if (isset($_POST['name']) && isset($_POST['description']) && isset($_FILES["image"])) {
        include "../controllers/admin-controller.php";
        $name = $_POST['name'];
        $description = $_POST['description'];

        $max_size = 2 * 1024 * 1024;
        $target_dir = "../uploads/company/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $new_file_name = time() . "." . $image_file_type;
        $logo_path = $target_dir . $new_file_name;
        if (filesize($_FILES["image"]["tmp_name"]) > $max_size) {
            header("Location: ../view/add-company.php?message=Resim boyutu 2MB altında olmalıdır.");
            exit();
        }
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $logo_path)) {
            AddCompany($name, $description, $logo_path);
            header("Location: ../view/company-list.php?message=Başarıyla kaydedildi!");
            exit();
        } else {
            header("Location: ../view/add-company.php?message=Resim yüklenirken bir hata oluştu!");
            exit();
        }
    }
}
