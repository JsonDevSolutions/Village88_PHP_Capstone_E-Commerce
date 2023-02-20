<?php 
	$this->load->view('partials/client_side_header');
	$this->load->view('partials/client_side_navigation');
	$images = json_decode($product['sub_image_urls'], true);
?>
        <!------------------------Product--------------------------->
		<div class="row product">
			<div class="col-12 col-md-6">
                <!------------------------Product Images--------------------------->
				<div class="slider">
					<div class="fotorama" data-width="100%" data-autoplay="2000" data-nav="thumbs">
						<img src="<?= base_url($product['main_image_url']) ?>" style = "width:350px; height: 200px;"/>
<?php 
	foreach($images as $image){
?>
						<img src="<?= base_url($image) ?>" />
<?php
	}
?>
					</div>
				</div>
			</div>
            <!------------------------Product Info--------------------------->
			<div class="col-12 col-md-6 text-light">
				<form action="<?= base_url('carts/add_to_cart') ?>" method="post">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
					<input type="hidden" name="product_id" value = "<?= $product['id'] ?>">
					<div class="row gy-2">
						<h1 class="col-12"><?= $product['name'] ?></h1>
						<p class="col-12"><?= $product['description'] ?></p>
						<div class="col-7 col-sm-5 col-md-6 col-lg-5 d-block me-0 ms-auto">
							<!------------------------Select Quantity--------------------------->
							<select class="form-select" name="quantity" aria-label="Disabled select example">
								<option value="1">1 <?= '($' . $product['price'] . ')' ?></option>
								<option value="2">2 <?= '($' . ($product['price'] * 2) . ')' ?></option>
								<option value="3">3 <?= '($' . ($product['price'] * 3) . ')' ?></option>
							</select>
							<input type="submit" id="add-to-cart" class="btn btn-success w-100 mt-2 fs-4" value="Add to cart">
						</div>
					</div>
				</form>
			</div>
		</div>
		<!------------------------Similar Items--------------------------->
		<div class="container text-light">
			<h2>Similar items</h2>
            <!------------------------Item List--------------------------->
			<div class="row gy-3">
<?php 
	if($similar_products != NULL){
		foreach($similar_products as $similar_product){
?>
				<div class="col-6 col-sm-4 col-lg-2">
					<div class="item-card">
						<div></div>
						<div class="img_container">
							<img src="<?= base_url($similar_product['main_image_url']) ?>" alt="#" />
						</div>
						<a href="<?= base_url('products/show/' . $similar_product['id']) ?>" class="d-block"><?= $similar_product['name'] ?></a>
						<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
						<p>Price: $<?= $similar_product['price'] ?></p>
					</div>
				</div>
<?php
		}
	}
?>
			</div>
		</div>
	</body>
</html>
