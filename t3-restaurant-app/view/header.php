<link rel="stylesheet" href="../public/css/header.css">
<div class="
<?php switch ($_SESSION['role']) {
    case 0:
        echo "admin_header";
        break;
    case 1:
        echo "company_header";
        break;
    case 2:
        echo "user_header";
        break;
} ?>">
    <a href="profile.php"><img class="profile_photo" src="../public/images/profile_logo.png" alt="Profil Logosu"></a>
    <a href="index.php" class="header_obj"><button>Ana Sayfa</button></a>
    <?php switch ($_SESSION['role']) {
        case 0: ?>
            <a href="customer-list.php" class="header_obj"><button>Müşteriler</button></a>
            <a href="company-list.php" class="header_obj"><button>Firmalar</button></a>
            <a href="cupons.php" class="header_obj"><button>Kuponlar</button></a>
        <?php break;
        case 1: ?>
            <a href="company.php" class="header_obj"><button>Firma</button></a>
            <a href="food-list.php" class="header_obj"><button>Yemekler</button></a>
            <a href="restaurant-list.php" class="header_obj"><button>Restoranlar</button></a>
        <?php break;
        case 2: ?>
            <a href="foods.php" class="header_obj"><button>Yemekler</button></a>
            <a href="orders.php" class="header_obj"><button>Siparişler</button></a>
            <a href="basket.php" class="header_obj"><button>Sepet</button></a>
    <?php break;
    } ?>
    <form action="logout.php" method="post"><button class="logout_btn" type="submit">Çıkış Yap</button></form>
</div>