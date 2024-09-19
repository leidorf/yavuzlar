<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: login.php?message=Lütfen giriş yapınız.");
    exit();
} else if ($_SESSION['role'] != 1) {
    header("Location: index.php?message=403 Yetkisiz Giriş");
}
include "../controllers/admin-controller.php";
$company = GetCompanyById($_SESSION['company_id']);
require_once "header.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <title><?php echo $company['name']; ?> Company</title>
</head>

<body>
    <div class="container">
        <div class="login t<?php echo $_SESSION['role']; ?>">
            <img name="logo" class="medPhoto container_obj" src="<?php echo $company['logo_path']; ?>" alt="Firma Logosu" class="company_logo">

            <label for="name">İsim:</label>
            <p name="name"><?php echo $company['name']; ?></p>

            <label for="description">Açıklama:</label>
            <p name="description"><?php echo $company['description']; ?></p>

            <a href="update-company.php?<?php echo $company['id']; ?>"><button>Güncelle</button></a>
        </div>
    </div>
    <?php require_once "footer.php"; ?>
</body>

</html>