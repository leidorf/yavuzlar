<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: login.php?message=Lütfen giriş yapınız.");
    exit();
} else if ($_SESSION['role'] != 0) {
    header("Location: index.php?message=403 Yetkisiz Giriş");
}  
require_once "header.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Company</title>
</head>

<body>
    <div>
        <a href="company-list.php"> <button type="button">←</button> </a>
        <form action="../scripts/add-company-query.php" method="post" enctype="multipart/form-data">
            <div>
                <input type="text" name="name" placeholder="Firma Adı" required />
                <input type="text" name="description" placeholder="Açıklama" required />
                <label for="image">Firma Logosu:</label>
                <input type="file" name="image" accept="image/*" required>
            </div>
            <button type="submit">Kaydet</button>
        </form>
    </div>
    <?php require_once "footer.php"; ?>
</body>

</html>