<?php 
	$this->load->view('partials/header');
	$this->load->view('partials/navigation');
?>
		<div class="mb-3 row">
			<div class="col-6 col-md-3">
				<!------Search-------->
				<div class="input-group">
					<button class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></button>
					<input type="text" class="form-control" placeholder="search" aria-label="search" aria-describedby="basic-addon1" />
				</div>
			</div>
			<div class="col-0 col-md-7 space"></div>
			<!------Add product-------->
			<div class="col-6 col-md-2">
                <button  class="btn btn-primary w-100" id="add" data-bs-toggle="modal" data-bs-target="#product">add new product</button>
			</div>
		</div>
		<!------Product Table-------->
		<div class="table-container">
			<table class="table table-light table-striped align-middle">
				<thead>
					<tr>
						<th class="col-2" scope="col-1">Picture</th>
						<th class="col-1" scope="col-1">ID</th>
						<th class="col-4" scope="col-1">Name</th>
						<th class="col-1" scope="col-1">Inventory Count</th>
						<th class="col-1" scope="col-1">Qty Sold</th>
						<th class="col-3" scope="col-1">Action</th>
					</tr>
				</thead>
				<tbody>
<?php 
	if($products != NULL){
		foreach($products as $product){
?>
					<tr>
						<td>
							<div class="img_container">
								<img src="<?= base_url($product['main_image_url']) ?>" alt="mouse" />
							</div>
						</td>
						<td><?= $product['id'] ?></td>
						<td><?= $product['name'] ?></td>
						<td><?= $product['inventory_count'] ?></td>
						<td><?= $product['qty_sold'] ?></td>
						<td>
							<button data-bs-toggle="modal" data-bs-target="#product"><a href="#">Edit</a></button>
							<button data-bs-toggle="modal" data-bs-target="#delete_product"><a href="#">Delete</a></button>
						</td>
					</tr>
<?php
		}
	}
?>
				</tbody>
			</table>
		</div>
		<!------Page-------->
		<div class="page">
			<a href="#"><</a><a href="#"><<</a><a href="#">1</a><a href="#">2</a><a href="#">3</a><a href="#">4</a><a href="#">5</a><a href="#">6</a><a href="#">7</a><a href="#">8</a><a href="#">9</a><a href="#">10</a><a href="#">></a><a href="#">>></a>
		</div>

		<!-- ------------------------------------------Delete modal------------------------------------------------------------- -->
		<form action="/products/delete_product" method="post">
			<div class="modal fade" id="delete_product" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="staticBackdropLabel">Delete product</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<input type="hidden" name="id" value="1" />
							<p>Are you sure you want to delete this product?</p>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							<input type="submit" class="btn btn-danger" value="delete" />
						</div>
					</div>
				</div>
			</div>
		</form>

		<!-- ------------------------------------------Update/add modal------------------------------------------------------------- -->
		<form action="/products/edit_product" id="form-add-update" method="post"  enctype="multipart/form-data">
			<div class="modal fade" id="product" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title add-update" id="staticBackdropLabel">Edit product</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<!------Upadte/add input field-------->
							<!-- <input type="hidden" name="id" value="1" /> -->
							<div class="mb-1">
								<label for="name" class="form-label">Product Name</label>
								<input type="text" required class="form-control" id="name" name="name" />
							</div>

							<div class="mb-2">
								<label for="Description" class="form-label">Description</label>
								<textarea class="form-control" required id="Description" name="description" rows="3"></textarea>
							</div>

							<div class="row">
								<div class="mb-1 col-6">
									<label for="stocks" class="form-label">Inventory Count</label>
									<input type="number" required class="form-control" id="stocks" name="stocks"/>
								</div>

								<div class="mb-1 col-6">
									<label for="price" class="form-label">Price</label>
									<input type="number" required class="form-control" id="price" name="price"/>
								</div>
								<!------Category Dropdown-------->
								<div class="mb-1 col-12 mt-2 dropdown">
									<button class="form-select text-start" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">Category</button>
									<ul class="dropdown-menu w-100" id="category_list" aria-labelledby="dropdownMenuButton1">
										<!-- <li class="position-relative category_name">
											<a class="dropdown-item" href="#"><input class="w-75" type="text" value="category 1"/></a> <i class="fas fa-pen position-absolute edit-category" style="right: 40px; top: 5px"></i><i class="fas fa-trash position-absolute  delete-category" style="right: 10px; top: 5px"></i>
										</li>
										<li class="position-relative category_name">
											<a class="dropdown-item" href="#"><input class="w-75" type="text" value="category 2" /></a> <i class="fas fa-pen position-absolute edit-category" style="right: 40px; top: 5px"></i><i class="fas fa-trash position-absolute  delete-category" style="right: 10px; top: 5px"></i>
										</li>
										<li class="position-relative category_name">
											<a class="dropdown-item" href="#"><input class="w-75" type="text" value="category 3" /></a> <i class="fas fa-pen position-absolute edit-category" style="right: 40px; top: 5px"></i><i class="fas fa-trash position-absolute  delete-category" style="right: 10px; top: 5px"></i>
										</li> -->
									</ul>
								</div>

								<div class="mb-1 col-12">
									<label for="add_new_categ" class="form-label">Add new category</label>
									<input type="text" class="form-control" id="add_new_categ" name="add_new_categ" required/>
								</div>
								<!------Images-------->
								<div class="mb-4 col-12 mt-2">
									<label for="add_new_categ" class="form-label">Images: </label>
									<label class="btn btn-success text-end" for="img_upload">Upload</label>
									<input id="img_upload" type="file" name="product_img_file[]" multiple accept=".png, .jpg, .jpeg" />
								</div>
	
								<ul class="img_upload_container">
									<!-- Uploaded images here -->
								</ul>
								
							</div>
						</div>
						
						<div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							<input type="button" class="btn btn-success" value="preview" />
							<input type="submit" class="btn btn-primary btn_save" value="update" />
						</div>

					</div>
				</div>
			</div>
		</form>
	</body>
</html>
