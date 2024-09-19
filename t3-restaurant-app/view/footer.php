<link rel="stylesheet" href="../public/css/footer.css">
<div class="footer     
<?php switch ($_SESSION['role']) {
    case 1:
        echo "secondary";
        break;
    case 2:
        echo "accent";
        break;
} ?>">
    <?php switch ($_SESSION['role']) {
        case 0: ?>
            <div>
                <p class="footer_obj">Admin yetkisiyle işlem yaptığınızı unutmayın.</p>
            </div>
        <?php break;
        case 1: ?>
        <?php break;
        case 2: ?>

    <?php break;
    } ?>
    <div class="under_div">
        <div style="display: flex;">
            <img src="../public/images/logo.png" alt="Yavuzlar Logo" class="yavuzlar_logo">
            <p class="footer_obj">
                Yavuzlar Restoran Uygulaması<br>
                Bu uygulama Yavuzlar Web Güvenliği ve Yazılım Geliştirme Takımı altında <a href="https://github.com/leidorf" target="_blank" rel="noopener noreferrer">leidorf</a> tarafından geliştirilmiştir.
            </p>
        </div>
        <p class="footer_obj">
            2024 🄯 copyleft <br>kopyalayınız, dağıtınız
        </p>
    </div>
</div>