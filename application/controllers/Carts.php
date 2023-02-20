<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    Class Carts extends CI_Controller{
        public function __construct(){
            parent::__construct();
            $this->load->model('Product');
        }
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
        public function remove_cart($product_id){
            $cart = $this->session->userdata('cart');
            unset($cart[$product_id]);
            $this->session->set_userdata('cart', $cart);
            if(!empty($this->session->userdata('cart'))){
                echo count($this->session->userdata('cart'));
            }else{
                echo "0";
            }
        }
        public function update_item_quantity($product_id, $quantity){
            $cart = $this->session->userdata('cart');
            $cart[$product_id] = $quantity;
            $this->session->set_userdata('cart', $cart);
            $this->cart_list_html();
        }
        public function cart_count(){
            if(!empty($this->session->userdata('cart'))){
                echo count($this->session->userdata('cart'));
            }else{
                echo "0";
            }
        }
        public function cart_list(){
            $scripts = array('cart.js');  
            $this->load->view('products/cart', array('scripts' => $scripts));
            // $this->output->enable_profiler(TRUE); 
        }
        public function cart_list_html(){
            if(empty($this->session->userdata('cart'))){
                $this->load->view('partials/cart_list');
            }else{
                $cart = $this->session->userdata('cart');
                $product_ids = implode(', ', array_keys($cart));
                $products = $this->Product->get_carts_product(explode(',', $product_ids));  
                $this->load->view('partials/cart_list', array('products' => $products, 'cart' => $cart));
            }
        }
    }
?>