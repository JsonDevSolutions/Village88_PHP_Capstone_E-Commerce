<?php
	if($products != NULL){
		foreach($products as $product){
?>
					<tr>
						<td>
							<div class="img_container">
								<img src="<?= base_url('assets/img/products/' . $product['category_name'] . '/' . $product['main_image']) ?>" alt="mouse" />
							</div>
						</td>
						<td><?= $product['id'] ?></td>
						<td><?= $product['name'] ?></td>
						<td><?= $product['inventory_count'] ?></td>
						<td><?= $product['qty_sold'] ?></td>
						<td class="text-center">
							<button data-bs-toggle="modal" data-bs-target="#product"><a href="<?= base_url('products/edit_product/'. $product['id']) ?>" alt_url="<?= base_url('products/update/'. $product['id']) ?>" class="edit_product">Edit</a></button>
							<button data-bs-toggle="modal" data-bs-target="#delete_product"><a href="<?= base_url('products/delete_product/'. $product['id']) ?>" class="delete_product">Delete</a></button>
						</td>
					</tr>
<?php
		}
	}
?>