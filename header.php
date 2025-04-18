  <!--/ Carousel Star /-->
  <?php
include 'baglan.php';

// Son 3 aktif ilanı çek
$query = "SELECT * FROM properties WHERE status = 1 ORDER BY created_at DESC LIMIT 3";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Sorgu başarısız: " . mysqli_error($conn));
}
?>
<div class="intro intro-carousel">
    <div id="carousel" class="owl-carousel owl-theme">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="carousel-item-a intro-item bg-image" style="background-image: url('img/properties/<?php echo htmlspecialchars($row['image']); ?>')">
                <div class="overlay overlay-a"></div>
                <div class="intro-content display-table">
                    <div class="table-cell">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="intro-body">
                                        <p class="intro-title-top">
                                            <?php echo htmlspecialchars($row['konum']); ?>
                                            <br> Alan: <?php echo htmlspecialchars($row['alan']); ?> m²
                                        </p>
                                        <h1 class="intro-title mb-4">
                                            <a href="kiralik-single.php?id=<?php echo $row['id']; ?>"><span class="color-b"><?php echo htmlspecialchars($row['title']); ?></span></a>
                                        </h1>
                                        <p class="intro-subtitle intro-price">
                                            <span class="price-a"><?php echo $row['type'] == 'kiralik' ? 'Kiralık' : 'Satılık'; ?> | <?php echo number_format($row['price']); ?> TL</span>
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