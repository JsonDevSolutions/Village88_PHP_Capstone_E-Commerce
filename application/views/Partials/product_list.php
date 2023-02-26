<?php 
    if($products != NULL){
        foreach($products as $product){
?>
                <div class="col-6 col-sm-4 col-lg-3 col-xl-2 mb-4">
                    <div class="item-card ">
                        <div class="img_container">
                            <img src="<?= base_url('assets/img/products/' . $product['category_name'] . '/' . $product['main_image']) ?>" alt="mouse">
                        </div>
                        <a href="<?= base_url('products/show/' . $product['id']) ?>" class="d-block text-decoration-none text-truncate"><?= $product['name'] ?></a>
                        <!-- <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> -->
                        <p>Price: $ <?= $product['price'] ?></p>
                    </div>
                </div>
<?php
        }
    }
?>