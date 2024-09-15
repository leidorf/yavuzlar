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
    $users = GetUsers();
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
            </div>
            <?php foreach ($users as $user): ?>
                <div class="customerDiv">
                    <p> <?php echo $user['id']; ?> </p>
                    <p> <?php echo $user['company_id']; ?> </p>
                    <p> <?php echo $user['name']; ?> </p>
                    <p> <?php echo $user['surname']; ?> </p>
                    <p> <?php echo $user['username']; ?> </p>
                    <p> <?php echo $user['balance']; ?> </p>
                    <p> <?php echo $user['created_at']; ?> </p>
                    <p> <?php echo $user['deleted_at']; ?> </p>
                    <form action="../scripts/ban-user.php" method="post">
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