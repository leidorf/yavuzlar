<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: login.php?message=Lütfen giriş yapınız.");
    exit();
} else if ($_SESSION['role'] != 0) {
    header("Location: index.php?message=403 Yetkisiz Giriş");
} else {
    include "../controllers/admin-controller.php";
    $companies = GetCompanies();
    require_once "header.php";
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../public/css/style.css">
        <title>Company List</title>
    </head>

    <body>
        <div class="">
            <h1 class="searchbox">Firmalar</h1>
            <a href="./add-company.php" class="searchbox"><button>Firma Ekle</button></a>
            <?php if (empty($companies)) {
                echo "<p>Hiç müşteri bulunamadı.</p>";
            } else { ?>
                <div class="searchbox">
                    <input
                        type="search"
                        id="searchbox"
                        onchange="liveSearch()"
                        placeholder="Müşteri Ara" />
                    <div>
                        <label for="isBanned">Banlı mı?</label>
                        <input type="checkbox" id="isBanned" />
                    </div>
                </div>
                <div class="dataDiv">
                    <p>ID</p>
                    <p>Ad</p>
                    <p>Açıklama</p>
                    <p>Fotoğraf</p>
                    <p>Silinme</p>
                    <p>Yemekler</p>
                    <p>Güncelleme</p>
                    <p>Silme</p>
                </div>
                <?php foreach ($companies as $i => $company): ?>
                    <div class="customerDiv" is-banned="<?php echo $company['deleted_at'] ? 'true' : 'false'; ?>">
                        <div class="dataDiv t<?php echo $_SESSION['role']; ?>">
                            <p><?php echo $company['id']; ?></p>
                            <p><?php echo $company['name']; ?></p>
                            <p><?php echo $company['description']; ?></p>
                            <img src="<?php echo $company['logo_path']; ?>" alt="Firma Logosu" class="company_logo" title="<?php echo $company['logo_path']; ?>">
                            <p><?php echo $company['deleted_at']? $company['deleted_at'] : "Mevcut" ; ?></p>
                            <a href="company-foods.php?c_id=<?php echo $company['id']; ?>"><button>Yemekleri Listele</button></a>
                            <a href="update-company.php?c_id=<?php echo $company['id']; ?>"><button>Firmayı Güncelle</button></a>
                            <form action="../scripts/ban-company.php" method="post">
                                <input type="hidden" name="company_id" value="<?php echo $company['id']; ?>" />
                                <button type="submit" style="margin-top: 1rem;" >X</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php } ?>
        </div>

        <a href="index.php" style="margin-top: 1.5rem;" class="searchbox"><button>Ana Sayfa</button></a>
        <?php require_once "footer.php"; ?>
        <script src="../public/js/customer-list.js"></script>
    </body>

    </html>
<?php } ?>