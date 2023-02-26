                            <!-- <input type="hidden" name="id" value="1" /> -->
							<div class="mb-1">
								<label for="name" class="form-label">Product Name</label>
								<input type="text" required class="form-control" id="product_name" value="<?= $product['product_name'] ?>" name="name" />
							</div>

							<div class="mb-2">
								<label for="Description" class="form-label">Description</label>
								<textarea class="form-control" required id="description" name="description" rows="3"><?= $product['description'] ?></textarea>
							</div>

							<div class="row">
								<div class="mb-1 col-6">
									<label for="stocks" class="form-label">Inventory Count</label>
									<input type="number" required class="form-control" id="stocks" value="<?= $product['onhand'] ?>" name="stocks"/>
								</div>

								<div class="mb-1 col-6">
									<label for="price" class="form-label">Price</label>
									<input type="number" required class="form-control" id="price" value="<?= $product['price'] ?>" name="price"/>
								</div>
								<!------Category Dropdown-------->
								<div class="mb-1 col-12 mt-2 dropdown">
									<button class="form-select text-start" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><?= $product['category_name'] ?></button>
									<ul class="dropdown-menu w-100" id="category_list" aria-labelledby="dropdownMenuButton1">
									</ul>
								</div>

								<div class="mb-1 col-12">
									<label for="add_new_categ" class="form-label">Add new category</label>
									<input type="text" class="form-control" id="add_new_categ" value = "" name="add_new_categ" required/>
								</div>
								<!------Images-------->
								<div class="mb-4 col-12 mt-2">
									<label for="add_new_categ" class="form-label">Images: </label>
									<label class="btn btn-success text-end" for="img_upload">Upload</label>
									<input id="img_upload" type="file" name="product_img_file[]" multiple accept=".png, .jpg, .jpeg" />
								</div>
<?php
    $images = json_decode($product['image_filenames'], true);
    foreach($images as $key => $image){
        if($key == 'main'){
            break;
        }
?>
                                <ul class="img_upload_container">
                                    <li class="img_upload_section">
                                        <input type="hidden" name="file_name[]" value="<?= $image ?>" />
                                        <div class="row align-items-center">
                                            <i class="fas fa-bars col-1"></i>
                                            <div class="col-3">
                                                <div class="img_container">
                                                    <img src="<?= base_url('assets/img/products/' . $product['category_name'] . '/' . $image) ?>" alt="<?= $image ?>" />
                                                </div>
                                            </div>
                                            <p class="img_filename col-4 overflow-hidden"> <?= $image ?></p>
                                            <i class="fas fa-trash col-1 btn_img_upload_delete"></i>
<?php
    if($image == $images['main']){
		$main = $image
?>
                                            <input class="col-1" type="checkbox" name="img_upload_main_id" value="filename" checked/>
<?php
    }else{
?>
                                            <input class="col-1" type="checkbox" name="img_upload_main_id" value="filename" disabled/>
<?php
    }
?>
                                            <p class="col-1 m-0 p-0">main</p>
                                        </div>
                                    </li>
								</ul>
<?php
    }
?>
							<input type="hidden" id = "main_image" name="main_image" value="<?= $main ?>" />
							</div>