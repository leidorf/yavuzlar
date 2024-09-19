<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: login.php?message=Lütfen giriş yapınız.");
    exit();
} else if ($_SESSION['role'] == 0) {
    include "../controllers/admin-controller.php";
    $company_id = $_GET['c_id'];
    $company = GetCompanyById($company_id);
} else if ($_SESSION['role'] == 1) {
    include "../controllers/admin-controller.php";
    $company = GetCompanyById($_SESSION['company_id']);
}
require_once "header.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <title>Update <?php echo $company['name']; ?> Company</title>
</head>

<body>
    <h1><?php echo $company['name']; ?> Firmasını Güncelle</h1>
    <img src="<?php echo $company['logo_path']; ?>" alt="Firma Logosu" class="company_logo">
    <div class="container">
        <div class="login t<?php echo $_SESSION['role']; ?>">
            <form action="../scripts/update-company-query.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="company_id" value="<?php echo $company['id']; ?>" />
                <input type="text" value="<?php echo $company['name']; ?>" placeholder="Firma Adı" name="name" required />
                <input type="text" value="<?php echo $company['description']; ?>" name="description" placeholder="Açıklama" required />
                <label for="image">Firma Logosu:</label>
                <input type="file" value="<?php echo $company['logo_path']; ?>" name="image" accept="image/*" required />
                <button type="submit">Güncelle</button>
            </form>
        </div>
    </div>
    <?php require_once "footer.php"; ?>
</body>

</html>