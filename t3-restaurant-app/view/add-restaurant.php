<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: login.php?message=Lütfen giriş yapınız.");
    exit();
} else if ($_SESSION['role'] != 1) {
    header("Location: index.php?message=403 Yetkisiz Giriş");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Restaurant to Company <?php echo $_SESSION['company_id']; ?></title>
</head>

<body>
    <div>
        <h3>Restoran Ekle</h3>
        <a href="./restaurant-list.php"><button type="button"><- </button></a>
        <form action="../scripts/add-restaurant-query.php" method="post" enctype="multipart/form-data">
            <div>
                <label for="name">Restoran Adı:</label>
                <input type="text" name="name" placeholder="Restoran Adı" required />

                <label for="description">Açıklama:</label>
                <input type="text" name="description" placeholder="Açıklama" required />

                <label for="image">Restoran Fotoğrafı:</label>
                <input type="file" name="image" accept="image/*" required>
            </div>

            <button type="submit">Ekle</button>
        </form>
    </div>
</body>

</html>