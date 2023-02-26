<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    Class Products extends CI_Controller{
        public function __construct(){
            parent::__construct();
            $this->load->model('Category');
            $this->load->model('Product');
            $this->load->model('User');
            $this->load->model('Comment');
            $this->load->model('Reply');
        }
        /*  DOCU: Client Side index page */
        public function index(){
            $categories = $this->Category->categories_product_count();
            $this->load->view('products/catalog', array('title' => 'All Products', 'categories' => $categories, 'page_number' => 1, 'stylesheet_name' => 'catalog', 'script_file_name' => 'catalog', 'is_logged_in' => $this->is_login(), 'user' => $this->user()));
        }
        /*  DOCU: Returns list of products in admin side */
        public function admin_products(){
            if(empty($this->session->userdata('admin_user_id'))){
                redirect(base_url('users/admin'));
            }
            $products = $this->Product->get_product_list('', 20, (1 * 20 - 20));
            $this->load->view('admin/admin_products', array('title' => 'Products Page', 'products' => $products, 'stylesheet_name' => 'admin_products', 'script_file_name' => 'admin_products'));
        }
        /*  DOCU: Catalog page - all products */
        public function show_all($page_number){
            $categories = $this->Category->categories_product_count();
            $this->load->view('products/catalog', array('title' => 'All Products', 'categories' => $categories, 'page_number' => $page_number, 'stylesheet_name' => 'catalog', 'script_file_name' => 'catalog', 'is_logged_in' => $this->is_login(), 'user' => $this->user()));
        }
        /*  DOCU: Display individual product */
        public function show($id){
            $product = $this->Product->get_product_by_id($id);
            $similar_products = $this->Product->get_similar_products($id, $product['category_id']);
            $comments = $this->Comment->display_comments($id);
            $replies = $this->Reply->get_replies($id);
            if(!empty($this->session->userdata('customer_user_id'))){
                $this->load->view('products/show_product', array('title' => '(Product Page)' . $product['name'] . '| BEST Deals PH', 'product' => $product, 'similar_products' => $similar_products, 'cart_method' => 'add_to_cart_db', 'stylesheet_name' => 'show_products', 'script_file_name' => 'cart', 'is_logged_in' => $this->is_login(), 'user' => $this->user(), 'comments' => $comments, 'replies' => $replies));
            }else{
                $this->load->view('products/show_product', array('title' => '(Product Page)' . $product['name'] . '| BEST Deals PH', 'product' => $product, 'similar_products' => $similar_products, 'cart_method' => 'add_to_cart', 'stylesheet_name' => 'show_products', 'script_file_name' => 'cart', 'is_logged_in' => $this->is_login()));
            }
        }
        /*  DOCU: Display products per category - With pagination */
        public function category($category_id, $page_number){
            $categories = $this->Category->categories_product_count();
            $category_name = $this->Category->get_category_name($category_id)->name;
            $total_pages = ceil($this->Product->get_product_count_per_category($category_id)->count / 2);
            $data = array('title' => '(Product Page) ' . $category_name . ' (page ' . $page_number . ') | BEST Deals PH', 'categories' => $categories, 'category_id' => $category_id, 'category_name' => $category_name, 'total_pages' => $total_pages, 'page_number' => $page_number, 'stylesheet_name' => 'catalog', 'script_file_name' => 'catalog', 'is_logged_in' => $this->is_login(), 'user' => $this->user());
            $this->load->view('products/catalog_per_category', $data);
        }
        /*  DOCU: Returns filtered product list (Sort By: Price Low to High & High to low, Most Popular, and for searching products) 
            Returns Product List and pagination links
        */
        public function filter($category_id, $page_number){
            if(array_key_exists('sort_display', $this->input->post())){
                if(empty($this->input->post('sort_display'))){
                    $this->session->unset_userdata('sort_display');
                }else{
                    $this->session->set_userdata('sort_display', $this->input->post('sort_display'));
                }
            }elseif(array_key_exists('search_product', $this->input->post())){
                if(empty($this->input->post('search_product'))){
                    $this->session->unset_userdata('search_product');
                }else{
                    $this->session->set_userdata('search_product', $this->input->post('search_product'));
                }
            }
            $products = $this->Product->get_product_per_category($category_id, $this->session->userdata('search_product'), $this->session->userdata('sort_display'), 12, ($page_number * 12 - 12));
            $total_pages = ceil($products['row_count']->count / 12);
            $product_list = $this->load->view('partials/product_list', array('products' => $products['product']), TRUE);
            $pagination_links = $this->load->view('partials/pagination_links', array('total_pages' => $total_pages, 'page_number' => $page_number, 'url' => 'products/category/' . $category_id . '/'), TRUE);
            echo json_encode(array('product_list' => $product_list, 'pagination_links' => $pagination_links));
        }
        /*  DOCU: Returns product list for catalog page */
        public function html_product_list($page_number){
            if(array_key_exists('sort_display', $this->input->post())){
                if(empty($this->input->post('sort_display'))){
                    $this->session->unset_userdata('sort_display');
                }else{
                    $this->session->set_userdata('sort_display', $this->input->post('sort_display'));
                }
            }elseif(array_key_exists('search_product', $this->input->post())){
                if(empty($this->input->post('search_product'))){
                    $this->session->unset_userdata('search_product');
                }else{
                    $this->session->set_userdata('search_product', $this->input->post('search_product'));
                }
            }
            $products = $this->Product->get_all_product_list($this->session->userdata('search_product'), $this->session->userdata('sort_display'), 12, ($page_number * 12 - 12));
            $total_pages = ceil($products['row_count']->count / 12);
            $product_list = $this->load->view('partials/product_list', array('products' => $products['product']), TRUE);
            $pagination_links = $this->load->view('partials/pagination_links', array('total_pages' => $total_pages, 'page_number' => $page_number, 'url' => 'products/show_all/'), TRUE);

            echo json_encode(array('product_list' => $product_list, 'pagination_links' => $pagination_links));
        }
        /*  DOCU: Returns list of category list */
        public function html_category(){
            $category = $this->Category->get_category_list();
            $this->load->view('partials/category_dropdown_list', array('categories' => $category));
        }
        /*  DOCU: Returns specific product details when admin edit product details */
        public function edit_product($product_id){
            $product = $this->Product->get_product_details($product_id);
            $this->load->view('partials/edit_product', array('product' => $product));
        }
        /*  DOCU: Delete Product from database and images from directory */
        public function delete_product($product_id){
            $category_name = $this->Product->get_product_category_name($product_id)->name;
            $file_names =  json_decode($this->Product->check_value_exist($product_id)->image_names, true);
            $target_dir = 'assets/img/products/' . $category_name . '/';
            $delete_product = $this->Product->delete_product($product_id);
            foreach($file_names as $file){
                unlink($target_dir . $file);
            }
            $this->search_product(1);
        }
        /*  DOCU: Returns Product list and pagination links for admin product list */
        public function search_product($page_number){
            if(!empty($this->input->post('search_product'))){
                $this->session->set_userdata('search_product', $this->input->post('search_product'));
            }else{
                $this->session->set_userdata('search_product', '');
            }
            $products = $this->Product->get_all_product_list($this->session->userdata('search_product'), '', 5, ($page_number * 5 - 5));
            $total_pages = ceil($products['row_count']->count / 5);
            $product_list = $this->load->view('partials/admin_products_list', array('products' => $products['product']), TRUE);
            $pagination_links = $this->load->view('partials/pagination_links', array('total_pages' => $total_pages, 'page_number' => $page_number, 'url' => 'products/search_product/'), TRUE);
            echo json_encode(array('product_list' => $product_list, 'pagination_links' => $pagination_links));
        }
        /*  DOCU: Update Product Details */
        public function update($product_id){
            $count = 0;
            $category = $this->input->post('add_new_categ');
            $category_id = $this->Category->get_category_id($category);
            $main = ltrim($this->input->post('main_image'));
            $target_dir = 'assets/img/products/' . $category . '/';
            $file_names =  json_decode($this->Product->check_value_exist($product_id)->image_names, true);
            $updated_file_names = array();
            // Check if old images are remove in this new update
            // Remove images from directory
            foreach($file_names as $file){
                if(in_array($file, $this->input->post('file_name'), true)){
                    $count += 1;
                    $updated_file_names[$count] = $file;
                }else{
                    unlink($target_dir . $file);
                }
            }
            $image_max_filename = $this->Product->get_category_max_image_count($category_id)->max_num_image;
            if (!empty($_FILES['product_img_file']['name'][0])) {
                $this->load->library('upload');
                $files = $_FILES['product_img_file'];
                $errors = array();

                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true); // true flag creates nested directories if needed
                }
                // Loop through each file and upload it
                foreach ($files['name'] as $key => $name) {
                    $count += 1;
                    // Get image file extension
                    $file_extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                    $image_name =  ($image_max_filename + $count) . '.' . $file_extension;
                    $updated_file_names[$count] = $image_name;
                    if($this->input->post('main_image') == $name){
                        $main = $image_name;
                    }
                    // prepare the file information for uploading file
                    $_FILES['userfile']['name'] = $files['name'][$key];
                    $_FILES['userfile']['type'] = $files['type'][$key];
                    $_FILES['userfile']['tmp_name'] = $files['tmp_name'][$key];
                    $_FILES['userfile']['error'] = $files['error'][$key];
                    $_FILES['userfile']['size'] = $files['size'][$key];

                    // Set the upload path and file name
                    $config['upload_path'] = './assets/img/products/' . $this->input->post('add_new_categ') . '/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['file_name'] = $image_name;
                    // Initialize the upload library with the configuration
                    $this->upload->initialize($config);

                    // Attempt to upload the file
                    if (!$this->upload->do_upload('userfile')) {
                        $errors[] = $this->upload->display_errors();
                    }
                }
            }

            $updated_file_names['main'] = $main;
            $updated_file_names['max'] = $image_max_filename + $count;
            $update_product = $this->Product->update_product($this->input->post(), $updated_file_names, $product_id, $category_id);
            if($update_product){
                echo "updated";
            }else{
                echo "error";
            }
        }
        /*  DOCU: Triggers when admin add new product 
            1. Check if folder name exist, else it will create new folder
            2. Retrieves the maximum image number of the specific category, used for naming images that can be save in the directory.
            3. Save image to directory (Folder: CategoryName/imagenumber.jpg) 
            4. Build images filename as JSON format that can be save in Database
            5. Add Product details into the database
        */
        public function create(){
            $this->load->library('upload');
            $category = $this->input->post('add_new_categ');
            $category_id = $this->Category->get_category_id($category);
            $main = $this->input->post('main_image');
            $image_max_filename = $this->Product->get_category_max_image_count($category_id)->max_num_image;
            $target_dir = 'assets/img/products/' . $category . '/';
            $files = $_FILES['product_img_file'];

            $image_filenames = array();
            $errors = array();
            $count = 0;
            if (!empty($_FILES['product_img_file']['name'][0])){
                // Check if directory exist, Create Folder
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                // Loop through each file and upload it
                foreach ($files['name'] as $key => $name) {
                    $count += 1;
                    // Filenames that will be save in database
                    $file_extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                    $image_name =  ($image_max_filename + $count) . '.' . $file_extension;
                    $image_filenames[$count] = $image_name;
                    if($this->input->post('main_image') == $name){
                        $main = $image_name;
                    }
                    // prepare the file information for uploading file
                    $_FILES['userfile']['name'] = $files['name'][$key];
                    $_FILES['userfile']['type'] = $files['type'][$key];
                    $_FILES['userfile']['tmp_name'] = $files['tmp_name'][$key];
                    $_FILES['userfile']['error'] = $files['error'][$key];
                    $_FILES['userfile']['size'] = $files['size'][$key];

                    // Set the upload path and file name
                    $config['upload_path'] = './assets/img/products/' . $category . '/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['file_name'] = $image_name;
                    // Initialize the upload library with the configuration
                    $this->upload->initialize($config);

                    // Attempt to upload the file
                    if (!$this->upload->do_upload('userfile')) {
                        $errors[] = $this->upload->display_errors();
                    }
                }
            }
            $image_filenames['main'] = $main;
            $image_filenames['max'] = $image_max_filename + $count;

            $add_product = $this->Product->add_product($this->input->post(), $image_filenames, $category_id);
            $this->search_product(1);
        }
        private function is_login(){
            return $is_logged_in = $this->session->userdata('customer_user_id') ? true : false;
        }
        private function user(){
            return $this->User->get_user_data($this->session->userdata('customer_user_id'));
        }
    }
?>