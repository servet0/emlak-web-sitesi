  <!--/ Carousel Star /-->
  <?php
include 'baglan.php';

// Son 3 veriyi çek
$query = "SELECT * FROM kiralik_daireler ORDER BY id DESC LIMIT 3";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Sorgu başarısız: " . mysqli_error($conn));
}
?>
<div class="intro intro-carousel">
    <div id="carousel" class="owl-carousel owl-theme">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="carousel-item-a intro-item bg-image" style="background-image: url('<?php echo $row['resim']; ?>')">
                <div class="overlay overlay-a"></div>
                <div class="intro-content display-table">
                    <div class="table-cell">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="intro-body">
                                        <p class="intro-title-top">
                                            <?php echo $row['konum']; ?>
                                            <br> Genişlik: <?php echo $row['alan']; ?> m²
                                        </p>
                                        <h1 class="intro-title mb-4">
                                            <a href="kiralik-single.php?id=<?php echo $row['id']; ?>"><span class="color-b"> <?php echo $row['baslik']; ?></span></a>
                                        </h1>
                                        <p class="intro-subtitle intro-price">
                                            <span class="price-a">Kira Fiyatı | <?php echo $row['fiyat']; ?> TL</span>
                                        </p>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
        
    </div>
</div>


  <!--/ Carousel end /-->