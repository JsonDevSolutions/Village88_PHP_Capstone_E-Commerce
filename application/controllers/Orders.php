<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    Class Orders extends CI_Controller{
        public function index(){
            $this->load->view('admin/orders');
        }
        public function test(){
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