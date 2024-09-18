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
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Company List</title>
    </head>

    <body>
        <div class="container">
            <h3>Firmalar</h3>
            <a href="./add-company.php"><button type="button">Firma Ekle</button></a>
            <?php if (empty($companies)) {
                echo "<p>Hiç müşteri bulunamadı.</p>";
            } else { ?>
                <div>
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
                <?php foreach ($companies as $i => $company): ?>
                    <div class="customerDiv" is-banned="<?php echo $company['deleted_at'] ? 'true' : 'false'; ?>">
                        <p><?php echo $company['id']; ?></p>
                        <p><?php echo $company['name']; ?></p>
                        <p><?php echo $company['description']; ?></p>
                        <p><?php echo $company['logo_path']; ?></p>
                        <p><?php echo $company['deleted_at']; ?></p>
                        <a href="company-foods.php?c_id=<?php echo $company['id']; ?>"><button>Yemekleri Listele</button></a>
                        <div>
                            <a href="update-company.php?c_id=<?php echo $company['id']; ?>"><button>Firmayı Güncelle</button></a>
                            <form action="../scripts/ban-company.php" method="post">
                                <input type="hidden" name="company_id" value="<?php echo $company['id']; ?>" />
                                <button type="submit">X</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php } ?>
        </div>

        <a href="index.php"><button type="button">Ana Sayfa</button></a>
        <script src="../public/js/customer-list.js"></script>
    </body>

    </html>
<?php } ?>