<?php 
    $this->load->view('partials/client_header_section');
    $this->load->view('partials/client_side_navigation');
?>

    <!---------------------Main Container-------------------->
    <div class="container text-light d-block m-auto">

        <div class="row gx-1">
            <!---------------------Filter Desktop -------------------->
            <div class="col col-2 filter">
                <form action="<?= base_url('products/filter/' . $category_id . '/' . $page_number) ?>" id="search" method="post" class="row gy-1 mt-5 ">
                    <input class="col-12 mt-3 form-control" id="search_product_name" type="text" placeholder="Search Product" name="search_product">
                    <p class="text-light fw-bold m-0 mb-2 mt-3">Categories</p>
<?php 
    if($categories != NULL){
        foreach($categories as $category){
?>
                    <a href="<?= base_url('products/category/' . $category['id'] . '/1') ?>" class="text-light col-12 text-decoration-none"><?= $category['name'] . ' (' . $category['product_count'] . ')' ?></a>
<?php
        }
    }
?>
                    <a href="<?= base_url('products/show_all/1') ?>" class="col-12 text-decoration-none">Show All</a>
                </form>
            </div>
            <!---------------------Filter Mobile -------------------->
            <div class="row col-12 col-lg-10 gy-3 m-0">
                <div class="col-12 row">
                    <h1 class="col-12 col-md-6 m-0 mt-3 p-0"><?= $category_name . ' (page ' . $page_number . ')' ?></h1>
                    <!---------------------Desktop Sort-------------------->
                    <div class="col-3 filter">
                        <form action="<?= base_url('products/filter/' . $category_id) . '/1'?>" method="post">
                            <select class="form-select" name="sort_display" aria-label="Default select example">
                                <option value = "0" selected>Sort By</option>
                                <option value="1">Most popular</option>
                                <option value="2">Price: Low to High</option>
                                <option value="3">Price: High to Low</option>
                            </select>
                        </form>
                    </div>
                    <!---------------------Top Page Nav-------------------->
                    <div class="col-3 mb-4 filter nav">
                        <a href="<?= base_url('products/category/' . $category['id'] . '/1') ?>">first</a>
                        <p>|</p>
                        <a href="<?= base_url('products/category/' . $category['id'] . '/' . ($page_number - 1)) ?>">prev</a>
                        <p>|</p>
                        <p><?= $page_number ?></p>
                        <p>|</p>
                        <a href="<?= base_url('products/category/' . $category['id'] . '/' . ($page_number + 1)) ?>">next</a>
                    </div>
                </div>
                <!---------------------Product List-------------------->
                <div class="col-12 row mt-3" id="product-list">
                </div>
            </div>
        </div>
    <!---------------------Botto Page Nav-------------------->
    <div class="page mb-4 w-100 text-center">

    </div>
    
    

</body>
</html>