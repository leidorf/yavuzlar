<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: login.php?message=Lütfen giriş yapınız.");
    exit();
} else if ($_SESSION['role'] != 1) {
    header("Location: index.php?message=403 Yetkisiz Giriş");
}
require_once "header.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <title>Add Restaurant to Company <?php echo $_SESSION['company_id']; ?></title>
</head>

<body>
    <div class="container">
        <div class="login t<?php echo $_SESSION['role']; ?>">

            <h1>Restoran Ekle</h1>
            <form action="../scripts/add-restaurant-query.php" method="post" enctype="multipart/form-data">
                <div class="container_obj">
                    <label for="name">Restoran Adı:</label><br>
                    <input type="text" name="name" placeholder="Restoran Adı" required />
                </div>

                <div class="container_obj">
                    <label for="description">Açıklama:</label><br>
                    <input type="text" name="description" placeholder="Açıklama" required />
                </div>
                <div class="container_obj">
                    <label for="image">Restoran Fotoğrafı:</label><br>
                    <input type="file" name="image" accept="image/*" required>
                </div>

                <button type="submit">Ekle</button>
            </form>
        </div>
    </div>
    <?php require_once "footer.php"; ?>
</body>

</html>