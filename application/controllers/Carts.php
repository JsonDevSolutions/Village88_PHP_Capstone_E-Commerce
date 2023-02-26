<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    Class Carts extends CI_Controller{
        public function __construct(){
            parent::__construct();
            $this->load->model('Product');
            $this->load->model('Cart');
            $this->load->model('User');
        }
        /*  DOCU: Triggers when add to cart is clicked
            For Guest add cart function, Returns number of cart items
        */
        public function add_to_cart(){
            $product_id = $this->input->post('product_id', TRUE);
            $quantity = $this->input->post('quantity', TRUE);
            if(empty($this->session->userdata('cart'))){
                $this->session->set_userdata('cart', array($product_id => $quantity));
            }else{
                $cart = $this->session->userdata('cart');
                if (array_key_exists($product_id, $cart)) {
                    $cart[$product_id] += $quantity;
                }else{
                    $cart[$product_id] = $quantity;
                }
                $this->session->set_userdata('cart', $cart);
            }
            echo count($this->session->userdata('cart'));
        }
        /*  DOCU: Triggers when add to cart is clicked
            For Registered add cart function, Returns number of cart items
        */
        public function add_to_cart_db(){
            $process_cart_item = $this->Cart->process_cart_item($this->input->post(), $this->session->userdata('customer_user_id'));
            if($process_cart_item == FALSE){
                redirect(base_url('products/show_all/1'));
            }elseif($process_cart_item === "Product Does not exist!"){
                redirect(base_url('products/show_all/1'));
            }else{
                $cart_count = $this->Cart->get_total_items($this->session->userdata('customer_user_id'));
                echo $cart_count['num_items'];
            }
        }
        /*  DOCU: Triggers when delete cart item is clicked, Both works for guest and registered user */
        public function remove_cart($product_id){
            if(!empty($this->session->userdata('customer_user_id'))){
                $delete_cart_item = $this->Cart->delete_cart_item($product_id, $this->session->userdata('customer_user_id'));
                $this->cart_count();
            }else{
                $cart = $this->session->userdata('cart');
                unset($cart[$product_id]);
                $this->session->set_userdata('cart', $cart);
                if(!empty($this->session->userdata('cart'))){
                    echo count($this->session->userdata('cart'));
                }else{
                    echo "0";
                }
            }
        }
        /*  DOCU: Triggers when update cart item is clicked, Both works for guest and registered user 
            Returns Cart list
        */
        public function update_item_quantity($product_id, $quantity){
            if(!empty($this->session->userdata('customer_user_id'))){
                $this->Cart->update_cart_item_qty($this->session->userdata('customer_user_id'), $product_id, $quantity);
            }else{
                $cart = $this->session->userdata('cart');
                $cart[$product_id] = $quantity;
                $this->session->set_userdata('cart', $cart);
            }
            $this->cart_list_html();
        }
        /*  DOCU: Returns unique number of cart items for both guest and registered user */
        public function cart_count(){
            if(!empty($this->session->userdata('customer_user_id'))){
                $cart_count = $this->Cart->get_total_items($this->session->userdata('customer_user_id'));
                echo $cart_count['num_items'];
            }else{
                if(!empty($this->session->userdata('cart'))){
                    echo count($this->session->userdata('cart'));
                }else{
                    echo "0";
                }
            }
        }
        /*  DOCU: Cart List Page */
        public function cart_list(){
            $this->load->view('products/cart', array('title' => '(Cart Page) Shopping Cart | BEST Deals PH', 'stylesheet_name' => 'cart', 'script_file_name' => 'cart_list', 'is_logged_in' => $this->is_login(), 'user' => $this->user()));
        }
        /*  DOCU: Returns List of cart items */
        public function cart_list_html(){
            if(!empty($this->session->userdata('customer_user_id'))){
                $products = $this->Cart->get_cart_items($this->session->userdata('customer_user_id'));
                $this->load->view('partials/cart_list', array('products' => $products, 'user' => 'registered_user'));
            }else{
                if(empty($this->session->userdata('cart'))){
                    $this->load->view('partials/cart_list');
                }else{
                    $cart = $this->session->userdata('cart');
                    $product_ids = implode(', ', array_keys($cart));
                    $products = $this->Product->get_carts_product(explode(',', $product_ids));  
                    $this->load->view('partials/cart_list', array('products' => $products, 'cart' => $cart, 'user' => 'guest'));
                }
            }
        }
        /*  DOCU: Used for checking if there is a login user */
        private function is_login(){
            return $is_logged_in = $this->session->userdata('customer_user_id') ? true : false;
        }
        /*  DOCU: Returns user Login Details */
        private function user(){
            return $this->User->get_user_data($this->session->userdata('customer_user_id'));
        }
    }
?>