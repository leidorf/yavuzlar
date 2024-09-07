<?php
session_start();
if (!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
    header("Location: login.php?message=You are not logged in!");
    die();
} else {
    include "functions/functions.php";
    $datas = GetUsers();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Scoreboard</title>
    </head>

    <body>
        <div class="container">
            <?php if (count($datas) < 1) { ?>
                <h3>Herhangi bir kayıt bulunamadı</h3>
            <?php } else { ?>
                <div class="boardDiv">
                    <p>Kullanıcı Adı</p>
                    <p>Skor</p>
                </div>
                <?php foreach ($datas as $i => $data) { ?>
                    <div class="submissionDiv">
                        <p><?php echo $data['username']; ?></p>
                        <p><?php echo $data['score']; ?></p>
                    </div>
            <?php }
            } ?>
            <a href="index.php"><button type="button" style="margin-top:0.5rem;">Ana Sayfa</button></a>
        </div>
    </body>

    </html>
<?php } ?>