<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: login.php?message=Lütfen giriş yapınız.");
    exit();
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
</head>

<body>
    <div>
        <a href="login.php"> <button type="button">←</button> </a>
        <form action="../scripts/update-profile-query.php" method="post">
            <label for="name">İsim:</label>
            <input type="text" name="name" placeholder="İsim" value="<?php echo $_SESSION['name']; ?>" required />
            <label for="surname">Soyisim:</label>
            <input type="text" name="surname" placeholder="Soyisim" value="<?php echo $_SESSION['surname']; ?>" required />
            <label for="username">Kullanıcı Adı:</label>
            <input type="text" name="username" placeholder="Kullanıcı Adı" value="<?php echo $_SESSION['username']; ?>" required />
            <button type="submit">Profili Güncelle</button>
        </form>
    </div>

</body>

</html>