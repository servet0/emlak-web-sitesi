<?php
include '../baglan.php';

// AJAX isteğinden gelen parametreleri al
$type = isset($_POST['type']) ? $_POST['type'] : '';
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$limit = 12;
$offset = ($page - 1) * $limit;

// Veritabanından verileri çek
$sql = "SELECT * FROM properties WHERE status = 1";
if ($type) {
    $sql .= " AND type = '$type'";
}
$sql .= " ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// İlanları HTML formatında oluştur
$html = '';
while($row = $result->fetch_assoc()) {
    $html .= '<div class="col-md-4">';
    $html .= '<div class="card-box-a card-shadow">';
    $html .= '<div class="img-box-a">';
    $html .= '<img src="img/properties/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['title']) . '" class="img-a img-fluid">';
    $html .= '</div>';
    $html .= '<div class="card-overlay">';
    $html .= '<div class="card-overlay-a-content">';
    $html .= '<div class="card-header-a">';
    $html .= '<h2 class="card-title-a">';
    $html .= '<a href="kiralik-single.php?id=' . $row['id'] . '">' . htmlspecialchars($row['title']) . '</a>';
    $html .= '</h2>';
    $html .= '</div>';
    $html .= '<div class="card-body-a">';
    $html .= '<div class="price-box d-flex">';
    $html .= '<span class="price-a">' . ($row['type'] == 'kiralik' ? 'Kiralık' : 'Satılık') . ' | ' . number_format($row['price']) . ' TL</span>';
    $html .= '</div>';
    $html .= '<a href="kiralik-single.php?id=' . $row['id'] . '" class="link-a">Detayları gör';
    $html .= '<span class="ion-ios-arrow-forward"></span>';
    $html .= '</a>';
    $html .= '</div>';
    $html .= '<div class="card-footer-a">';
    $html .= '<ul class="card-info d-flex justify-content-around">';
    $html .= '<li>';
    $html .= '<h4 class="card-info-title">Alan</h4>';
    $html .= '<span>' . htmlspecialchars($row['alan']) . 'm<sup>2</sup></span>';
    $html .= '</li>';
    $html .= '<li>';
    $html .= '<h4 class="card-info-title">Oda</h4>';
    $html .= '<span>' . htmlspecialchars($row['oda_sayisi']) . '</span>';
    $html .= '</li>';
    $html .= '<li>';
    $html .= '<h4 class="card-info-title">Banyo</h4>';
    $html .= '<span>' . htmlspecialchars($row['banyo_sayisi']) . '</span>';
    $html .= '</li>';
    $html .= '<li>';
    $html .= '<h4 class="card-info-title">Garaj</h4>';
    $html .= '<span>' . htmlspecialchars($row['garaj']) . '</span>';
    $html .= '</li>';
    $html .= '</ul>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
}

echo $html;
?> 