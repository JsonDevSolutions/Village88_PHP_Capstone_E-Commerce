<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    use Stripe\StripeClient;

   Class Orders extends CI_Controller{
        public function __construct(){
            parent::__construct();
            $this->load->model('Order');
            $this->load->model('Product');
            $this->load->model('Cart');
            $this->load->model('User');
        }
        // Admin Dashboard Order Page
        public function index(){
            if(empty($this->session->userdata('admin_user_id'))){
                redirect(base_url('users/admin'));
            }
            $this->load->view('admin/orders', array('title' => '(Dashboard Orders)', 'stylesheet_name' => 'orders', 'script_file_name' => 'orders'));
        }
        /* Docu : Execute when customer place an order,
            Cater Both Registered User and Guest User
        */
        public function place_order(){
            if(!empty($this->session->userdata('customer_user_id'))){
                $user_id = $this->session->userdata('customer_user_id');
                $cart_items = $this->Cart->get_cart_items($user_id);
                $total_amount = $this->Cart->get_total_cart_amount($user_id)->total;
                $order_details = $this->Cart->user_cart_details($cart_items);
                $user_details = $this->User->get_user_data($this->session->userdata('customer_user_id'));
                $get_cart_item_descriptions  = $this->Cart->get_cart_item_descriptions($this->session->userdata('customer_user_id'));
                $add_order = $this->Order->add_order($user_id, $this->input->post(), $total_amount, $order_details, $user_details, $get_cart_item_descriptions);
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
        /* Docu : Page that will be shown after the user successfully placed an order */
        public function order_success(){
            $this->load->view('products/order_success', array('title' => 'Order Success', 'stylesheet_name' => 'cart', 'is_logged_in' => $this->is_login(), 'user' => $this->user()));
        }
        /* Docu : Disply Order Details */
        public function show($order_id){
            $order = $this->Order->get_order_by_id($order_id);
            $this->load->view('admin/order_view', array('title' => '(View Order)', 'order' => $order, 'stylesheet_name' => 'order_view'));
        }
        /* Docu : Trigger when admin search an order or filter order Status */
        public function filter_order_display($page_number){
            $this->session->set_userdata('search_order', $this->input->post('search_order'));
            $this->session->set_userdata('filter_order', $this->input->post('filter_order'));
            $this->order_list_html($page_number);
        }
        /* Docu : Update Order status */
        public function update_order_status($order_id){
            $update_order_status = $this->Order->update_order_status($order_id, $this->input->post('order_status'));
            $orders = $this->Order->get_order_list(1, (1 * 1 - 1));
            $this->load->view('partials/order_list', array('orders' => $orders));
        }
        /* Docu : Used for displaying Order List - JSON Responce */
        public function order_list_html($page_number){
            $orders = $this->Order->get_filtered_order_list(array('search_order' => $this->session->userdata('search_order'), 'filter_order' => $this->session->userdata('filter_order')), 10, ($page_number * 10 - 10));
            $total_pages = ceil($orders['row_count']->count / 10);
            $order_list = $this->load->view('partials/order_list', array('orders' => $orders['orders']), TRUE);
            $pagination_links = $this->load->view('partials/pagination_links', array('total_pages' => $total_pages, 'page_number' => $page_number, 'url' => 'orders/order_list_html/'), TRUE);
            echo json_encode(array('order_list' => $order_list, 'pagination_links' => $pagination_links));
        }
        /*  DOCU: Returns list of order history per customer */
        public function order_history(){
            $orders = $this->Order->order_history($this->session->userdata('customer_user_id'));
            $this->load->view('products/order_history', array('title' => 'My Orders', 'is_logged_in' => $this->is_login(), 'user' => $this->user(), 'orders' => $orders));
        }
        public function test_sms(){
            $this->load->library('clicksend');
            $config = ClickSend\Configuration::getDefaultConfiguration()
            ->setUsername('jeassonseroy4@gmail.com')
            ->setPassword('FEA253EF-E88D-84F2-4533-9A4A06DE47BD');

                $apiInstance = new ClickSend\Api\SMSApi(new GuzzleHttp\Client(),$config);
                $msg = new \ClickSend\Model\SmsMessage();
                $msg->setBody("Sample Test");
                $msg->setTo("09273932807");
                $msg->setSource("sdk");

                // \ClickSend\Model\SmsMessageCollection | SmsMessageCollection model
                $sms_messages = new \ClickSend\Model\SmsMessageCollection(); 
                $sms_messages->setMessages([$msg]);

                try {
                    $result = $apiInstance->smsSendPost($sms_messages);
                    print_r($result);
                } catch (Exception $e) {
                    echo 'Exception when calling SMSApi->smsSendPost: ', $e->getMessage(), PHP_EOL;
                }

                // $response = /* the response you received from the API */

                // if ($response['http_code'] == 200) { // check if the request was successful
                //     $data = json_decode($response['response'], true); // decode the response JSON to an array
                //     if ($data['response_code'] == 'SUCCESS') { // check if the API response code is success
                //         echo 'Message sent successfully.';
                //     } else {
                //         echo 'Failed to send message: ' . $data['response_msg'];
                //     }
                // } else {
                //     echo 'HTTP error: ' . $response['http_code'];
                // }
        }
        private function is_login(){
            return $is_logged_in = $this->session->userdata('customer_user_id') ? true : false;
        }
        private function user(){
            return $this->User->get_user_data($this->session->userdata('customer_user_id'));
        }
    }
?>