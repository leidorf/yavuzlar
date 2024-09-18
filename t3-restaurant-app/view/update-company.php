<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: login.php?message=Lütfen giriş yapınız.");
    exit();
} else if ($_SESSION['role'] != 0) {
    header("Location: index.php?message=403 Yetkisiz Giriş");
}
include "../controllers/admin-controller.php";
$company_id = $_GET['c_id'];
$company = GetCompanyById($company_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update <?php echo $company['name']; ?> Company</title>
</head>

<body>
    <div>
        <a href="company-list.php"> <button type="button">←</button> </a>
        <h3><?php echo $company['name']; ?> Firmasını Güncelle</h3>
        <img src="<?php echo $company['logo_path']; ?>" alt="Firma Logosu">
        <form action="../scripts/update-company-query.php" method="post" enctype="multipart/form-data">
            <div>
                <input type="hidden" name="company_id" value="<?php echo $company['id']; ?>" />
                <input type="text" value="<?php echo $company['name']; ?>" placeholder="Firma Adı" name="name" required />
                <input type="text" value="<?php echo $company['description']; ?>" name="description" placeholder="Açıklama" required />
                <label for="image">Firma Logosu:</label>
                <input type="file" value="<?php echo $company['logo_path']; ?>" name="image" accept="image/*" required />
            </div>
            <button type="submit">Güncelle</button>
        </form>
    </div>

</body>

</html>