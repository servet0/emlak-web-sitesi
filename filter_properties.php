<?php
include 'baglan.php';

// Filtreleme ve sayfalama parametrelerini al
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 12; 
$offset = ($page - 1) * $limit;

// Filtreye göre SQL sorgusunu oluştur
if ($filter == 'newest') {
  $sql = "SELECT * FROM kiralik_daireler ORDER BY created_at DESC LIMIT $limit OFFSET $offset"; // En yeni
} elseif ($filter == 'oldest') {
  $sql = "SELECT * FROM kiralik_daireler ORDER BY created_at ASC LIMIT $limit OFFSET $offset"; // En eski
} else {
  $sql = "SELECT * FROM kiralik_daireler LIMIT $limit OFFSET $offset"; // Tümü
}

$result = $conn->query($sql);

// Sonuçları HTML olarak döndür
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo '
    <div class="col-md-4">
      <div class="card-box-a card-shadow">
        <div class="img-box-a">
          <img src="' . $row['resim'] . '" alt="" class="img-a img-fluid">
        </div>
        <div class="card-overlay">
          <div class="card-overlay-a-content">
            <div class="card-header-a">
              <h2 class="card-title-a">
                <a href="#">' . $row['baslik'] . '</a>
              </h2>
            </div>
            <div class="card-body-a">
              <div class="price-box d-flex">
                <span class="price-a">rent | $ ' . number_format($row['fiyat']) . '</span>
              </div>
              <a href="kiralik-single.php?id=' . $row['id'] . '" class="link-a">Detayları Gör</a>
            </div>
            <div class="card-footer-a">
              <ul class="card-info d-flex justify-content-around">
                <li>
                  <h4 class="card-info-title">Area</h4>
                  <span>' . $row['alan'] . 'm<sup>2</sup></span>
                </li>
                <li>
                  <h4 class="card-info-title">Beds</h4>
                  <span>' . $row['oda_sayisi'] . '</span>
                </li>
                <li>
                  <h4 class="card-info-title">Baths</h4>
                  <span>' . $row['banyo_sayisi'] . '</span>
                </li>
                <li>
                  <h4 class="card-info-title">Garages</h4>
                  <span>' . $row['garaj'] . '</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    ';
  }
} else {
  echo 'No properties found.';
}
?>
