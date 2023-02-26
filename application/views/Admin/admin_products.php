<?php
	$this->load->view('partials/header');
	$this->load->view('partials/navigation');
?>
		<div class="mb-3 row">
			<div class="col-6 col-md-3">
				<!------Search-------->
				<form action="<?= base_url('products/search_product/1') ?>" id="search" method="post">
					<div class="input-group">
						<button class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></button>
						<input type="text" class="form-control search_product" name = "search_product" placeholder="search" aria-label="search" aria-describedby="basic-addon1" />
					</div>
				</form>
			</div>
			<div class="col-0 col-md-7 space"></div>
			<!------Add product-------->
			<div class="col-6 col-md-2">
                <button  class="btn btn-primary w-100" id="add" data-bs-toggle="modal" data-bs-target="#product">Add new product</button>
			</div>
		</div>
		<!------Product Table-------->
		<div class="table-container" style="height: 560px">
			<table class="table table-light table-striped align-middle">
				<thead>
					<tr>
						<th class="col-2" scope="col-1">Picture</th>
						<th class="col-1" scope="col-1">ID</th>
						<th class="col-4" scope="col-1">Name</th>
						<th class="col-2" scope="col-1">Inventory Count</th>
						<th class="col-1" scope="col-1">Qty Sold</th>
						<th class="col-2 text-center" scope="col-1">Action</th>
					</tr>
				</thead>
				<tbody>
					<!-- List of Products Here -->
				</tbody>
			</table>
		</div>
		<!------Page-------->
		<div class="page">
			<!-- Pagination Links Here -->
		</div>

		<!-- ------------------------------------------Delete modal------------------------------------------------------------- -->
		<form action="/products/delete_product" id = "confirm_delete" method="post">
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
							<input type="submit" class="btn btn-danger" data-bs-dismiss="modal" value="delete" />
						</div>
					</div>
				</div>
			</div>
		</form>

		<!-- ------------------------------------------Update/add modal------------------------------------------------------------- -->
		<form action="products/edit_product" id="form-add-update" method="post" class="row g-3"  enctype="multipart/form-data" autocomplete="off">
			<div class="modal fade" id="product" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title add-update" id="staticBackdropLabel">Edit product</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body" id="product_info">
							<input type="hidden" id = "main_image" name="main_image" value="" />
							<!------Upadte/add input field-------->
							<div class="mb-1">
								<label for="name" class="form-label">Product Name</label>
								<input type="text" required class="form-control" id="product_name" name="name" />
							</div>

							<div class="mb-2">
								<label for="Description" class="form-label">Description</label>
								<textarea class="form-control" required id="description" name="description" rows="3"></textarea>
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
							<input type="button" class="btn_preview_products_add_edit btn btn-success" value="preview" />
							<input type="submit" class="btn btn-primary btn_save" value="update" />
						</div>

					</div>
				</div>
			</div>
		</form>
		<!-- <script src="<?= base_url('assets/js/admin_products.js') ?>"></script> -->
	</body>
</html>
