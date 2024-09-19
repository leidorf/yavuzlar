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
    $datas = GetUsers();
    $companies = GetCompanies();
    require_once "header.php";
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../public/css/style.css">
        <title>Customer List</title>
    </head>

    <body>
        <div class="">
            <h1 class="searchbox">Müşteriler</h1>
            <?php if (empty($datas)) {
                echo "Hiç müşteri bulunamadı.";
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
                    <p>Firma Adı</p>
                    <p>Ad</p>
                    <p>Soyad</p>
                    <p>Kullanıcı Adı</p>
                    <p>Bakiye</p>
                    <p>Sipariş</p>
                    <p>Kayıt</p>
                    <p>Banlanma</p>
                    <p>Yetkilendir</p>
                    <p>Banla</p>
                </div>
                <?php foreach ($datas as $data): ?>
                    <div class="customerDiv" is-banned="<?php echo $data['user_deleted_at'] ? 'true' : 'false'; ?>">
                        <div class="dataDiv">
                            <p> <?php echo $data['user_id']; ?> </p>
                            <p> <?php echo $data['user_company_id'] ? $data['company_name'] : ""; ?> </p>
                            <p> <?php echo $data['user_name']; ?> </p>
                            <p> <?php echo $data['user_surname']; ?> </p>
                            <p> <?php echo $data['user_username']; ?> </p>
                            <p> <?php echo $data['user_balance']; ?> </p>
                            <p> <?php echo $data['order_status'] ? $data['order_status'] : "Mevcut sipariş yok"; ?></p>
                            <p> <?php echo $data['user_created_at']; ?> </p>
                            <p> <?php echo $data['user_deleted_at'] ? 'Banlı (' . $data['user_deleted_at'] . ")" : 'Değil'; ?> </p>
                            <div>
                                <form action="../scripts/make-employee-query.php" method="post">
                                    <input type="hidden" name="user_id" value="<?php echo $data['user_id']; ?>" />
                                    <select name="company_id" id="company_id">
                                        <?php foreach ($companies as $company): ?>
                                            <option value="<?php echo $company['id']; ?>"><?php echo $company['name']; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <button type="submit">Kaydet</button>
                                </form>
                            </div>
                            <form action="../scripts/ban-user.php" method="post">
                                <input type="hidden" name="user_id" value="<?php echo $data['user_id']; ?>" />
                                <button type="submit">X</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php } ?>
        </div>

        <a href="index.php" class="searchbox" style="margin-top:1.5rem;"><button>Ana Sayfa</button></a>
        <?php require_once "footer.php"; ?>
        <script src="../public/js/customer-list.js"></script>
    </body>

    </html>

<?php } ?>