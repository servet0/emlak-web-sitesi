<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar navbar-default navbar-trans navbar-expand-lg fixed-top">
    <div class="container">
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarDefault"
            aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <a class="navbar-brand text-brand" href="index.php">Es Emlak</a>
        <button type="button" class="btn btn-link nav-search navbar-toggle-box-collapse d-md-none" data-toggle="collapse"
            data-target="#navbarTogglerDemo01" aria-expanded="false">
            <span class="fa fa-search" aria-hidden="true"></span>
        </button>
        <div class="navbar-collapse collapse justify-content-center" id="navbarDefault">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Anasayfa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="about.php">Hakkında</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="kiraliklar.php">İlanlar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="contact.php">İletişim</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="rapor.php">Rapor</a>
                </li>
                <?php if (isset($_SESSION['user_giris']) && $_SESSION['user_giris'] === true): ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="kaydettiklerim.php">Kaydedilenler</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown-a" data-toggle="dropdown">
                            <i class="fa fa-user"></i> <?php echo htmlspecialchars($_SESSION['username']); ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdown-a">
                            <a class="dropdown-item" href="profil.php">Profilim</a>
                            <a class="dropdown-item" href="kaydettiklerim.php">Kaydedilen İlanlar</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="cikis.php">Çıkış Yap</a>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="giris.php">Giriş Yap</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="kayit.php">Kayıt Ol</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>