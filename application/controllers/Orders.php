<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    Class Orders extends CI_Controller{
        public function __construct(){
            parent::__construct();
            $this->load->model('Order');
            $this->load->model('Product');
            $this->load->model('Cart');
        }
        public function index(){
            $this->load->view('admin/orders');
        }
        public function place_order(){
            // $this->output->enable_profiler(TRUE); //enables the profiler
            if(!empty($this->session->userdata('customer_user_id'))){
                $user_id = $this->session->userdata('customer_user_id');
                $cart_items = $this->Cart->get_cart_items($user_id);
                $total_amount = $this->Cart->get_total_cart_amount($user_id)->total;
                $order_details = $this->Cart->user_cart_details($cart_items);
                $add_order = $this->Order->add_order($user_id, $this->input->post(), $total_amount, $order_details);
                $remove_cart_items = $this->Cart->remove_cart_items($user_id);
                if($add_order === TRUE && $remove_cart_items === TRUE){
                    redirect(base_url('orders/order_success'));
                }
            }else{
                $cart = $this->session->userdata('cart');
                $product_ids = implode(', ', array_keys($cart));
                $cart_items = $this->Product->get_carts_product(explode(',', $product_ids));
                $order_details = $this->Cart->guest_cart_details($cart_items, $cart);
                $total_amount = $this->Order->calculate_total($cart_items, $cart);
                $add_order = $this->Order->add_order('2', $this->input->post(), $total_amount, $order_details);
                if($add_order === TRUE){
                    $this->session->unset_userdata('cart');
                    redirect(base_url('orders/order_success'));
                }
            }
        }
        public function order_success(){
            $this->load->view('products/order_success', array('title' => 'Order Success', 'stylesheet_name' => 'cart'));
        }
        public function order_list(){
            $this->load->view('admin/orders', array('title' => '(Dashboard Orders)', 'stylesheet_name' => 'orders', 'script_file_name' => 'orders'));
        }
        public function show($order_id){
            $order = $this->Order->get_order_by_id($order_id);
            $this->load->view('admin/order_view', array('title' => '(View Order)', 'order' => $order, 'stylesheet_name' => 'order_view'));
        }
        public function filter_order_display($page_number){
            $this->session->set_userdata('search_order', $this->input->post('search_order'));
            $this->session->set_userdata('filter_order', $this->input->post('filter_order'));
            $this->order_list_html($page_number);
        }
        public function update_order_status($order_id){
            $update_order_status = $this->Order->update_order_status($order_id, $this->input->post('order_status'));
            $orders = $this->Order->get_order_list(1, (1 * 1 - 1));
            $this->load->view('partials/order_list', array('orders' => $orders));
        }
        public function order_list_html($page_number){
            $orders = $this->Order->get_filtered_order_list(array('search_order' => $this->session->userdata('search_order'), 'filter_order' => $this->session->userdata('filter_order')), 2, ($page_number * 2 - 2));
            $total_pages = ceil($orders['row_count']->count / 2);
            $order_list = $this->load->view('partials/order_list', array('orders' => $orders['orders']), TRUE);
            $pagination_links = $this->load->view('partials/pagination_links', array('total_pages' => $total_pages, 'page_number' => $page_number, 'url' => 'orders/order_list_html/'), TRUE);
            echo json_encode(array('order_list' => $order_list, 'pagination_links' => $pagination_links));
        }
        public function test_sms(){
            $ch = curl_init();
            $parameters = array(
                'apikey' => '12aaec3ae6c2bbf7f87cd8e77f9884bf', //Your API KEY
                'number' => '09280696663',
                'message' => 'I just sent my first message with Semaphore',
                'sendername' => 'SEMAPHORE'
            );
            curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
            curl_setopt( $ch, CURLOPT_POST, 1 );

            //Send the parameters set above with the request
            curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

            // Receive response from server
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            $output = curl_exec( $ch );
            curl_close ($ch);

            //Show the server response
            echo $output;
        }
    }
?>