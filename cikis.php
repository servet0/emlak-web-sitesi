<?php
session_start();

// Tüm oturum değişkenlerini temizle
$_SESSION = array();

// Oturum çerezini sil
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}

// Oturumu sonlandır
session_destroy();

// Ana sayfaya yönlendir
header("Location: index.php");
exit;
?> 