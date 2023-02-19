<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    Class Orders extends CI_Controller{
        public function __construct(){
            parent::__construct();
            $this->load->model('Order');
            $this->load->model('Product');
            $this->load->model('OrderDetails');
        }
        public function index(){
            $this->load->view('admin/orders');
        }
        public function place_order(){
            $cart = $this->session->userdata('cart');
            $product_ids = implode(', ', array_keys($cart));
            $cart_products = $this->Product->get_carts_product(explode(',', $product_ids));
            $total_amount = $this->Order->calculate_total($cart_products, $cart);
            $add_order = $this->Order->add_order($this->input->post(), $total_amount, $cart_products, $cart);
            if($add_order === TRUE){
                $this->session->unset_userdata('cart');
                redirect(base_url('orders/order_success'));
            }
        }
        public function order_success(){
            $this->load->view('products/order_success');
        }
        public function order_list(){
            $scripts = array('orders.js');
            $orders = $this->Order->get_order_list();
            $this->load->view('admin/orders', array('orders' => $orders, 'scripts' => $scripts));
        }
        public function show($order_id){
            $order = $this->Order->get_order_by_id($order_id);
            $order_details = $this->OrderDetails->get_order_details_by_id($order_id);
            $this->load->view('admin/order_view', array('order' => $order, 'order_details' => $order_details));
        }
        public function test(){
            redirect(base_url('orders/order_success'));
            // $this->Order->place_order();
            // $this->load->view('users/register');
            // $this->load->view('users/login');
            // $this->load->view('users/profile');
            // $this->load->view('products/cart');
            // $this->load->view('products/catalog');
            // $this->load->view('products/home');
            // $this->load->view('products/show_products');
            // $this->load->view('admin/order_view');
        }
    }
?>