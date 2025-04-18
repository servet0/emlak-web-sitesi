  <!--/ Property Star /-->
  <?php
include 'baglan.php';

// Son 4 aktif ilanı çek
$query = "SELECT * FROM properties WHERE status = 1 ORDER BY created_at DESC LIMIT 4";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Sorgu başarısız: " . mysqli_error($conn));
}
?>
<section class="section-property section-t8">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="title-wrap d-flex justify-content-between">
                    <div class="title-box">
                        <h2 class="title-a">Son Eklenen İlanlar</h2>
                    </div>
                    <div class="title-link">
                        <a href="kiraliklar.php">Tüm İlanlar
                            <span class="ion-ios-arrow-forward"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div id="property-carousel" class="owl-carousel owl-theme">
            <?php
            // Veritabanından alınan her mülk için slider öğesi oluşturuyoruz
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    ?>
                    <div class="carousel-item-b">
                        <div class="card-box-a card-shadow">
                            <div class="img-box-a">
                                <img src="img/properties/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" class="img-a img-fluid">
                            </div>
                            <div class="card-overlay">
                                <div class="card-overlay-a-content">
                                    <div class="card-header-a">
                                        <h2 class="card-title-a">
                                            <a href="kiralik-single.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['title']); ?></a>
                                        </h2>
                                    </div>
                                    <div class="card-body-a">
                                        <div class="price-box d-flex">
                                            <span class="price-a"><?php echo $row['type'] == 'kiralik' ? 'Kiralık' : 'Satılık'; ?> | <?php echo number_format($row['price']); ?> TL</span>
                                        </div>
                                        <a href="kiralik-single.php?id=<?php echo $row['id']; ?>" class="link-a">Detayları gör
                                            <span class="ion-ios-arrow-forward"></span>
                                        </a>
                                    </div>
                                    <div class="card-footer-a">
                                        <ul class="card-info d-flex justify-content-around">
                                            <li>
                                                <h4 class="card-info-title">Alan</h4>
                                                <span><?php echo htmlspecialchars($row['alan']); ?>m<sup>2</sup></span>
                                            </li>
                                            <li>
                                                <h4 class="card-info-title">Oda</h4>
                                                <span><?php echo htmlspecialchars($row['oda_sayisi']); ?></span>
                                            </li>
                                            <li>
                                                <h4 class="card-info-title">Banyo</h4>
                                                <span><?php echo htmlspecialchars($row['banyo_sayisi']); ?></span>
                                            </li>
                                            <li>
                                                <h4 class="card-info-title">Garaj</h4>
                                                <span><?php echo htmlspecialchars($row['garaj']); ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "Henüz ilan bulunmamaktadır.";
            }
            $conn->close();
            ?>
        </div>
    </div>
</section>
  <!--/ Property End /-->