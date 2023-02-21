<?php
    $this->load->view('partials/client_header_section');
    $this->load->view('partials/client_side_navigation');
?>

    <!---------------------Main Container-------------------->
    <div class="container text-light d-block m-auto">

        <div class="row gx-1">
            <!---------------------Filter Desktop -------------------->
            <div class="col col-2 filter">
                <form action="<?= base_url('products/html_product_list/'. $page_number) ?>" id="search" method="post" class="row gy-1 mt-5 ">
                    <input class="col-12 mt-3 form-control" id="search_product_name" type="text" placeholder="Search product name" name="search_product">
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
            <div class="row col-12 col-lg-10 gy-3 m-0 p-0">
                <div class="col-12 row">
                    <h1 class="col-12 col-md-6 m-0 mt-3 p-0">All Products <?= '(page '. $page_number . ')' ?></h1>
                    <div class="row gx-1 mobile-filter">
                        <h4 class="col-4 col-sm-3 col-md-2">Sort by: </h4>
                        <!---------------------Mobile Sort-------------------->
                        <div class="col-12 row gx-0 mb-4">
                            <div class="col-1">
                                <input type="radio" class="btn-check" name="options-outlined" id="All" autocomplete="off">
                                <label class="btn btn-outline-light w-100" for="All">All</label>
                            </div>
                            <div class="col-3">
                                <input type="radio" class="btn-check" name="options-outlined" id="Top_sales" autocomplete="off">
                                <label class="btn btn-outline-light w-100" for="Top_sales">Top sales</label>
                            </div>
                            <div class="col-4">
                                <input type="radio" class="btn-check" name="options-outlined" id="most_popular" autocomplete="off">
                                <label class="btn btn-outline-light w-100" for="most_popular">Most Popular</label>
                            </div>
                            <div class="col-2">
                                <input type="radio" class="btn-check" name="options-outlined" id="price" autocomplete="off">
                                <label class="btn btn-outline-light w-100" for="price">Price</label>
                            </div>
                            <!---------------------Mobile Category Filter-------------------->
                            <div class="category col-2">
                                <button type="button" class="btn btn-light dropdown-toggle p-1" data-bs-toggle="dropdown" aria-expanded="false">
                                    category
                                </button>
                                <ul class="dropdown-menu">
<?php 
    if($categories != NULL){
        foreach($categories as $category){
?>
                                    <li><a class="dropdown-item" href="<?= base_url('products/category/' . $category['id'] . '/1') ?>"><?= $category['name'] . ' (' . $category['product_count'] . ')' ?></a></li>
<?php
        }
    }
?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!---------------------Desktop Sort-------------------->
                    <div class="col-3  mt-4 filter">
                        <form action="<?= base_url('products/html_product_list/' . $page_number)?>" method="post">
                            <select class="form-select" name="sort_display" aria-label="Default select example">
                                <option value = "0" selected>Sort By</option>
                                <option value="1">Most popular</option>
                                <option value="2">Price: Low to High</option>
                                <option value="3">Price: High to Low</option>
                            </select>
                        </form>
                    </div>
                    <!---------------------Top Page Nav-------------------->
                    <div class="col-3 filter nav">
                        <a href="">first</a>
                        <p>|</p>
                        <a href="">prev</a>
                        <p>|</p>
                        <p>2</p>
                        <p>|</p>
                        <a href="">next</a>
                    </div>
                </div>
                <div class="col-12 row mt-3" id="product-list">

                </div>
                <!---------------------Product List-------------------->

            </div>
        </div>
    <!---------------------Botto Page Nav-------------------->
    <div class="page mb-4 w-100 text-center">
        
    </div>
    
    

</body>
</html>