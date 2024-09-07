<?php
session_start();
if (!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
    header("Location: login.php?message=You are not logged in!");
    die();
} else {
    include "functions/functions.php";
    $logs = GetLogs($_SESSION['id']);
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Submissions</title>
    </head>

    <body>
        <div class="container">
            <?php if (count($logs) < 1) { ?>
                <h3>Herhangi bir çözüm kaydı bulunamadı</h3>
            <?php } else { ?>
                <h3>Skorunuz: <?php echo $_SESSION['score']; ?></h3>
                <?php foreach ($logs as $i => $log): ?>
                    <div class="submissionDiv">
                        <p><?php echo $log['qname'];  ?></p>
                        <p><?php echo $log['isCorrect'] ? "✅" : "❌";  ?></p>
                    </div>
                <?php endforeach ?>
            <?php } ?>
            <a href="index.php"><button type="button" style="margin-top:0.5rem;">Ana Sayfa</button></a>
        </div>
        <script src=""></script>
    </body>

    </html>
<?php } ?>