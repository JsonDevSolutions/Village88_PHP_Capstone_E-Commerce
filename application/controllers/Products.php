<?php
    defined('BASEPATH') OR exit('No direct script access allowed'); 

    Class Products extends CI_Controller{
        public function __construct(){
            parent::__construct();
            $this->load->model('Category');
            $this->load->model('Product');
        }
        public function index(){
            $products = $this->Product->get_all_product_list(5, (1 * 5 - 5));
            $this->load->view('admin/admin_products', array('title' => 'Products Page', 'products' => $products));
        }
        public function home(){
            // $products = $this->Product->get_all_product_list(5, (1 * 5 - 5));
            // $this->load->view('products/home', array('title' => 'Products Page', 'products' => $products));
            $this->load->view('products/home');
        }
        public function show_all($page_number){
            $categories = $this->Category->categories_product_count();
            $this->load->view('products/catalog', array('title' => 'All Products', 'categories' => $categories, 'page_number' => $page_number, 'stylesheet_name' => 'catalog', 'script_file_name' => 'catalog'));
        }
        // Show individual Image
        public function show($id){
            $product = $this->Product->get_product_by_id($id);
            $similar_products = $this->Product->get_similar_products($id, $product['category_id']);
            if(!empty($this->session->userdata('customer_user_id'))){
                $this->load->view('products/show_product', array('title' => '(Product Page)' . $product['name'], 'product' => $product, 'similar_products' => $similar_products, 'cart_method' => 'add_to_cart_db', 'stylesheet_name' => 'show_products', 'script_file_name' => 'cart'));
            }else{
                $this->load->view('products/show_product', array('title' => '(Product Page)' . $product['name'], 'product' => $product, 'similar_products' => $similar_products, 'cart_method' => 'add_to_cart', 'stylesheet_name' => 'show_products', 'script_file_name' => 'cart'));
            }
        }
        // Products Per Category and Page Number
        public function category($category_id, $page_number){
            $sort_by = 2;
            // $products = $this->Product->get_product_per_category($category_id, "", $sort_by, 2, ($page_number * 2 - 2));
            $categories = $this->Category->categories_product_count();
            $category_name = $this->Category->get_category_name($category_id)->name;
            $total_pages = ceil($this->Product->get_product_count_per_category($category_id)->count / 2);
            // $data = array('title' => '(Product Page) ' . $category_name . ' (page ' . $page_number . ')', 'products' => $products, 'categories' => $categories, 'category_id' => $category_id, 'category_name' => $category_name, 'total_pages' => $total_pages, 'page_number' => $page_number, 'stylesheet_name' => 'catalog', 'script_file_name' => 'catalog');
            $data = array('title' => '(Product Page) ' . $category_name . ' (page ' . $page_number . ')', 'categories' => $categories, 'category_id' => $category_id, 'category_name' => $category_name, 'total_pages' => $total_pages, 'page_number' => $page_number, 'stylesheet_name' => 'catalog', 'script_file_name' => 'catalog');
            $this->load->view('products/catalog_per_category', $data);
        }
        public function filter($category_id = '', $page_number){
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
            $products = $this->Product->get_product_per_category($category_id, $this->session->userdata('search_product'), $this->session->userdata('sort_display'), 2, ($page_number * 2 - 2));
            $total_pages = ceil($products['row_count']->count / 2);
            $product_list = $this->load->view('partials/product_list', array('products' => $products['product']), TRUE);
            $pagination_links = $this->load->view('partials/pagination_links', array('total_pages' => $total_pages, 'page_number' => $page_number, 'url' => 'products/category/' . $category_id . '/'), TRUE);
        
            echo json_encode(array('product_list' => $product_list, 'pagination_links' => $pagination_links));
        }
        // Responce for Catalog Page
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
            $products = $this->Product->get_all_product_list($this->session->userdata('search_product'), $this->session->userdata('sort_display'), 5, ($page_number * 5 - 5));
            $total_pages = ceil($products['row_count']->count / 5);
            $product_list = $this->load->view('partials/product_list', array('products' => $products['product']), TRUE);
            $pagination_links = $this->load->view('partials/pagination_links', array('total_pages' => $total_pages, 'page_number' => $page_number, 'url' => 'products/show_all/'), TRUE);
        
            echo json_encode(array('product_list' => $product_list, 'pagination_links' => $pagination_links));
        }
        public function html_category(){
            $category = $this->Category->get_category_list();
            $this->load->view('partials/category_dropdown_list', array('categories' => $category));
        }






























        public function create(){
            // echo "<pre>";
            // var_dump($_FILES);
            // // var_dump($this->input->post('product_img_file'));
            // // $url = $this->input->post('image_url')[0];
            // echo "</pre>";
            // if(isset($_FILES[$url]) && $_FILES[$url]['name'] != "") {
            //     echo "hey";
            // }
            
            // if(isset($_FILES['product_img_file']) && $_FILES['product_img_file']['name'] != "") {
            //     $target_dir = "image/";
            //     $uploadfile = $_SERVER['DOCUMENT_ROOT'].$target_dir.'test.jpg';
            //     // check file type
            //     if ($_FILES['product_img_file']['type'] == 'image/jpeg' || $_FILES['product_img_file']['type'] == 'image/png' || $_FILES['product_img_file']['type'] == 'image/gif') {
            //         // move_uploaded_file($_FILES['product_img_file']['tmp_name'], base_url('assets/upload/') . $_FILES['product_img_file']['name']);
            //         move_uploaded_file($_FILES['product_img_file']['tmp_name'] , $uploadfile);
            //     }else {
            //         array_push($_SESSION['validation_error'], "Error: Attach image file only!");
            //         session_input_val($input_values);
            //         header('Location: index.php');
            //         die();
            //     }
            // }
        }
        // public function do_upload() {
        //     // echo "<pre>";
        //     // var_dump($_FILES);
        //     // echo "</pre>";
        //     // File upload configuration 
        //     $targetDir = "assets/img/products/"; 
        //     $allowTypes = array('jpg','png','jpeg','gif'); 
        
        //     $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = ''; 
        //     $fileNames = array_filter($_FILES['product_img_file']['name']); 
        //         if(!empty($fileNames)){ 
        //             foreach($_FILES['product_img_file']['name'] as $key=>$val){ 
        //                 // File upload path 
        //                 $fileName = basename($_FILES['product_img_file']['name'][$key]); 
        //                 $targetFilePath = $targetDir . $fileName; 
                        
        //                 // Check whether file type is valid 
        //                 $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
        //                 if(in_array($fileType, $allowTypes)){ 
        //                     // Upload file to server 
        //                     if(move_uploaded_file($_FILES["product_img_file"]["tmp_name"][$key], $targetFilePath)){ 
        //                         // Image db insert sql 
        //                         $insertValuesSQL .= "('".$fileName."', NOW()),"; 
        //                     }else{ 
        //                         $errorUpload .= $_FILES['product_img_file']['name'][$key].' | '; 
        //                     } 
        //                 }else{ 
        //                     $errorUploadType .= $_FILES['product_img_file']['name'][$key].' | '; 
        //                 } 
        //             }
        //         } 
        // }          
        
    }
?>