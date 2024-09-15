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
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Customer List</title>
    </head>

    <body>
        <div class="container">
            <h3>Müşteriler</h3>
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
            <?php if (empty($datas)) {
                echo "No users found.";
            } ?>
            <?php foreach ($datas as $data): ?>
                <div class="customerDiv" is-banned="<?php echo $data['user_deleted_at'] ? 'true' : 'false'; ?>">
                    <p> <?php echo $data['user_id']; ?> </p>
                    <p> <?php echo $data['user_company_id']; ?> </p>
                    <p> <?php echo $data['user_name']; ?> </p>
                    <p> <?php echo $data['user_surname']; ?> </p>
                    <p> <?php echo $data['user_username']; ?> </p>
                    <p> <?php echo $data['user_balance']; ?> </p>
                    <p> <?php echo $data['user_created_at']; ?> </p>
                    <p> <?php echo $data['user_deleted_at'] ? 'Banlı (' . $data['user_deleted_at'] . ")" : 'Değil'; ?> </p>
                    <form action="../scripts/ban-user.php" method="post">
                        <input type="hidden" name="user_id" value="<?php echo $data['user_id']; ?>" />
                        <button type="submit">X</button>
                    </form>
                </div>
            <?php endforeach ?>
        </div>

        <a href="index.php"><button type="button">Ana Sayfa</button></a>
        <script src="../public/js/customer-list.js"></script>
    </body>

    </html>

<?php } ?>