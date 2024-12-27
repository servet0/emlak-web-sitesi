  <!--/ Property Star /-->
  <?php
include 'baglan.php';

// Son 3 veriyi çek
$query = "SELECT * FROM kiralik_daireler ORDER BY id DESC LIMIT 4";
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
                        <h2 class="title-a">Kiralık Daireler</h2>
                    </div>
                    <div class="title-link">
                        <a href="kiraliklar.php">Tüm Daireler
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
                                <img src="<?php echo $row['resim']; ?>" alt="" class="img-a img-fluid">
                            </div>
                            <div class="card-overlay">
                                <div class="card-overlay-a-content">
                                    <div class="card-header-a">
                                        <h2 class="card-title-a">
                                            <a href="kiralik-single.php?id=<?php echo $row['id']; ?>"><?php echo $row['baslik']; ?></a>
                                        </h2>
                                    </div>
                                    <div class="card-body-a">
                                        <div class="price-box d-flex">
                                            <span class="price-a">Fiyat | <?php echo $row['fiyat']; ?> TL</span>
                                        </div>
                                        <a href="kiralik-single.php?id=<?php echo $row['id']; ?>" class="link-a">Detaylari gör
                                            <span class="ion-ios-arrow-forward"></span>
                                        </a>
                                    </div>
                                    <div class="card-footer-a">
                                        <ul class="card-info d-flex justify-content-around">
                                            <li>
                                                <h4 class="card-info-title">Genişlik</h4>
                                                <span><?php echo $row['alan']; ?>m<sup>2</sup></span>
                                            </li>
                                            <li>
                                                <h4 class="card-info-title">Oda</h4>
                                                <span><?php echo $row['oda_sayisi']; ?></span>
                                            </li>
                                            <li>
                                                <h4 class="card-info-title">Banyo</h4>
                                                <span><?php echo $row['banyo_sayisi']; ?></span>
                                            </li>
                                            <li>
                                                <h4 class="card-info-title">Garaj</h4>
                                                <span><?php echo $row['garaj']; ?></span>
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
                echo "No properties found.";
            }
            $conn->close();
            ?>
        </div>
    </div>
</section>
  <!--/ Property End /-->