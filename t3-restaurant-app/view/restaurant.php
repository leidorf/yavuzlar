<?php
session_start();
include "../controllers/auth-controller.php";
if (!IsUserLoggedIn()) {
    header("Location: login.php?message=Lütfen giriş yapınız.");
    exit();
} else if ($_SESSION['role'] != 2) {
    header("Location: ../view/index.php?message=403 Yetkisiz Giriş");
}
include "../controllers/customer-controller.php";
$restaurant_id = $_GET['r_id'];
$datas = GetComments($restaurant_id);
$restaurant_score = empty(GetAvgScore($restaurant_id)) ?: number_format(GetAvgScore($restaurant_id), 2);
require_once "header.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <title><?php echo $datas[0]["restaurant_name"]; ?></title>
</head>

<body>
    <div class="centerDiv">
        <?php if (empty($datas)) {
            echo "<div class='centerDiv'> <p>Restoran hakkında herhangi bir yorum yok.</p>";
            echo "<a href='add-comment.php?r_id=" . $restaurant_id . "'><button>Yorum Ekle</button></a></div>";
        } else { ?>
            <h1><?php echo $datas[0]['restaurant_name']; ?> Restoran</h1>
            <img src="<?php echo $datas[0]['restaurant_image_path'] ?>" alt="Restoran Fotoğrafı" class="medPhoto container_obj">
            <p><?php echo $restaurant_score; ?> ⭐ / 10 ⭐</p>
            <div class="searchbox">
                <input type="search" id="searchbox" placeholder="Yorum Ara" />
            </div>
            <a href="add-comment.php?r_id=<?php echo $restaurant_id; ?>"><button class="container_obj">Yorum Ekle</button></a>

            <div class="centerDiv">
                <table class="dataTable">
                    <thead>
                        <tr>
                            <th>Kullanıcı Adı</th>
                            <th>Başlık</th>
                            <th>Açıklama</th>
                            <th>Skor</th>
                            <th>Girdi</th>
                            <th>Güncelleme</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($datas as $data): ?>
                            <tr class="dataElement t<?php echo $_SESSION['role']; ?>">
                                <td>
                                    <p><?php echo $data["comments_username"]; ?></p>
                                </td>
                                <td>
                                    <p><?php echo $data["comments_title"]; ?></p>
                                </td>
                                <td>
                                    <p><?php echo $data["comments_description"]; ?></p>
                                </td>
                                <td>
                                    <p><?php echo $data["comments_score"] ? $data["comments_score"] . " ⭐" : "[deleted]"; ?></p>
                                </td>
                                <td>
                                    <p><?php echo $data["comments_created_at"]; ?></p>
                                </td>
                                <td>
                                    <p><?php echo $data["comments_updated_at"]; ?></p>
                                </td>
                                <?php if ($data['comments_user_id'] == $_SESSION['user_id'] && $data["comments_title"]!=="[deleted]" && $data["comments_description"]!=="[deleted]"): ?>
                                    <td>
                                        <form action="../scripts/delete-comment.php" method="post">
                                            <input type="hidden" name="c_id" value="<?php echo $data['comments_id']; ?>">
                                            <button type="submit">Sil</button>
                                        </form>
                                    </td>
                                <?php endif ?>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
    </div>
<?php } ?>
</div>
<div class="centerDiv">
    <a href="index.php" class="b<?php echo $_SESSION['role']; ?>"><button>Ana Sayfa</button></a>
</div>

<?php require_once "footer.php"; ?>
</body>
<script src="../public/js/searchbox.js"></script>

</html>