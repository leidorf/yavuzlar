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
$datas = GetUsers();
$companies = GetCompanies();
$uniqueDatas = [];
foreach ($datas as $data) {
    if (!in_array($data['user_id'], array_column($uniqueDatas, 'user_id'))) {
        $uniqueDatas[] = $data;
    }
}
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
    <div class="centerDiv">
        <h1 class="searchbox">Müşteriler</h1>
        <?php if (empty($datas)) {
            echo "Hiç müşteri bulunamadı.";
        } else { ?>
            <div class="searchbox">
                <input type="search" id="searchbox" placeholder="Müşteri Ara" />
                <div>
                    <label for="isBanned">&nbsp;Banlı mı?</label>
                    <input type="checkbox" id="isBanned" />
                </div>
            </div>
            <table class="dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Firma Adı</th>
                        <th>Ad</th>
                        <th>Soyad</th>
                        <th>Kullanıcı Adı</th>
                        <th>Bakiye</th>
                        <th>Sipariş</th>
                        <th>Kayıt</th>
                        <th>Banlanma</th>
                        <th>Yetiklendirme</th>
                        <th>Banla</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($uniqueDatas as $data): ?>
                        <tr class="dataElement dataTable t<?php echo $_SESSION['role']; ?>" is-banned="<?php echo $data['user_deleted_at'] ? 'true' : 'false'; ?>">
                            <td>
                                <p> <?php echo $data['user_id']; ?> </p>
                            </td>
                            <td>
                                <p>
                                    <?php echo !is_null($data['user_company_id']) ? GetCompanyById($data['user_company_id'])['name'] : "Yok"; ?>
                                </p>
                            </td>
                            <td>
                                <p> <?php echo $data['user_name']; ?> </p>
                            </td>
                            <td>
                                <p> <?php echo $data['user_surname']; ?> </p>
                            </td>
                            <td>
                                <p> <?php echo $data['user_username']; ?> </p>
                            </td>
                            <td>
                                <p> <?php echo $data['user_balance']; ?> </p>
                            </td>
                            <td>
                                <p> <?php echo !is_null($data['order_status']) ? "<a href='user-orders.php?u_id=" . $data['user_id'] . "'><button>Siparişler</button></a>" : "Mevcut sipariş yok"; ?></p>
                            </td>
                            <td>
                                <p> <?php echo $data['user_created_at']; ?> </p>
                            </td>
                            <td>
                                <p> <?php echo $data['user_deleted_at'] ? 'Banlı (' . $data['user_deleted_at'] . ")" : 'Değil'; ?> </p>
                            </td>
                            <td>
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
                            </td>
                            <td>
                                <form action="../scripts/ban-user.php" method="post">
                                    <input type="hidden" name="user_id" value="<?php echo $data['user_id']; ?>" />
                                    <button type="submit">X</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            <?php } ?>
            </table>
    </div>
    <div class="centerDiv">
        <a href="index.php" class="searchbox cleanText" style="margin-top:1.5rem;"><button>Ana Sayfa</button></a>
    </div>
    <?php require_once "footer.php"; ?>
    <script src="../public/js/searchbox.js"></script>
</body>

</html>