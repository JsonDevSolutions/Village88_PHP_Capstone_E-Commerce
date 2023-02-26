<?php 
    CLass Order extends CI_Model{
        /*  DOCU: Returns order list, base on the pagination selected by the admin */ 
        public function get_order_list($limit, $offset){
            return $this->db->query("SELECT id, billing_address, total_amount, status, DATE_FORMAT(created_at, '%m/%d/%Y') as order_date FROM orders limit ? OFFSET ?", array($limit, $offset))->result_array();
        }
        /*  DOCU: Returns filtered list of orders base on the applied filter ex(order status, order ID or customer name) */ 
        public function get_filtered_order_list($filter, $limit, $offset){
            $search = $this->security->xss_clean($filter['search_order']);
            $filter_by = $this->security->xss_clean($filter['filter_order']);
            $row_count = $this->get_order_list_count($search, $filter_by);

            if($filter_by == 'Show all'){
                $query = "SELECT id, billing_address, total_amount, status, DATE_FORMAT(created_at, '%m/%d/%Y') as order_date FROM orders WHERE id LIKE ? OR JSON_EXTRACT(billing_address, '$.first_name') LIKE ? OR JSON_EXTRACT(billing_address, '$.last_name') LIKE ? order by id DESC limit ? OFFSET ?";
                $values = array("%" . $search . "%", "%" . $search . "%", "%" . $search . "%", $limit, $offset);
            }else{
                $query = "SELECT id, billing_address, total_amount, status, DATE_FORMAT(created_at, '%m/%d/%Y') as order_date FROM orders WHERE (id LIKE ? OR JSON_EXTRACT(billing_address, '$.first_name') LIKE ? OR JSON_EXTRACT(billing_address, '$.last_name') LIKE ?) AND status = ? order by id DESC limit ? OFFSET ?";
                $values = array("%" . $search . "%", "%" . $search . "%", "%" . $search . "%", $filter_by, $limit, $offset);
            }
            $orders = $this->db->query($query, $values)->result_array();
            return array('row_count' => $row_count, 'orders' => $orders);
        }
        /*  DOCU: returns number of order list to determine total number of pages in the pagination */ 
        public function get_order_list_count($search, $filter_by){
            if($filter_by == 'Show all'){
                $query = "SELECT COUNT(*) as count FROM orders WHERE id LIKE ? OR JSON_EXTRACT(billing_address, '$.first_name') LIKE ? OR JSON_EXTRACT(billing_address, '$.last_name') LIKE ?";
                $values = array("%" . $search . "%", "%" . $search . "%", "%" . $search . "%");
            }else{
                $query = "SELECT COUNT(*) as count FROM orders WHERE (id LIKE ? OR JSON_EXTRACT(billing_address, '$.first_name') LIKE ? OR JSON_EXTRACT(billing_address, '$.last_name') LIKE ?) AND status = ?";
                $values = array("%" . $search . "%", "%" . $search . "%", "%" . $search . "%", $filter_by);
            }
            return $this->db->query($query, $values)->row();
        }
        /*  DOCU: Returns order details based on the given ID */ 
        public function get_order_by_id($order_id){
            $order_id = $this->security->xss_clean($order_id);
            return $this->db->query("SELECT id, order_items, billing_address, shipping_address, shipping_fee, total_amount, status, DATE_FORMAT(created_at, '%m/%d/%Y') as order_date FROM orders WHERE id = ?", array($order_id))->row_array();
        }
        /*  DOCU: Returns total amount of specific order */ 
        public function calculate_total($products, $cart){
            $total = 0;
            foreach($products as $product){
                $total += ($product['price'] * $cart[$product['id']]);
            }
            return $total;
        }
        /*  DOCU: This function will be triggered when customer place an order */ 
        public function add_order($user_id, $order_data, $total_amount, $order_details, $user_details, $get_cart_item_descriptions){
            $stripe_token = $order_data['stripeToken'];
            $billing_details = array(
                'first_name' => $order_data['first_name'][0],
                'last_name' => $order_data['last_name'][0],
                'address' => $order_data['address_one'][0],
                'address_two' => $order_data['address_two'][0],
                'city' => $order_data['city'][0],
                'state' => $order_data['state'][0],
                'zip_code' => $order_data['zip_code'][0]
            );
            // Process Card Payment
            $this->made_payment($stripe_token, $user_details, $billing_details, $total_amount, $get_cart_item_descriptions);

            $data = array(
                'user_id' => $user_id,
                'order_items' => json_encode($order_details),
                'billing_address' => json_encode($billing_details),
                'shipping_address' => json_encode(array(
                    'first_name' => $order_data['first_name'][1],
                    'last_name' => $order_data['last_name'][1],
                    'address' => $order_data['address_one'][1],
                    'address_two' => $order_data['address_two'][1],
                    'city' => $order_data['city'][1],
                    'state' => $order_data['state'][1],
                    'zip_code' => $order_data['zip_code'][1]
                )),
                'shipping_fee' => 1,
                'total_amount' => $total_amount,
            );
            return $this->place_order($data);
        }
        /*  DOCU: Process customer payment via stripe */ 
        private function made_payment($stripe_token, $user_details, $billing_details, $total_amount, $get_cart_item_descriptions){
            //include Stripe PHP library
            require_once APPPATH."third_party/stripe/init.php";
            $currency = "USD";

            if(!empty($stripe_token)){
                //set api key
                $stripe = array(
                    "secret_key"      => "sk_test_51MY8xOEpepl4hv4FygMZlEYVVUP0pQ2XeytUp6SVT1rVMgBiBNzNw5bzFv4mfdD9xai3OFurjLILc37ogZruDb2y00hVOIOpMd",
                    "publishable_key" => "pk_test_51MY8xOEpepl4hv4FtyO1CyFzT6viZOpQaj1mvQygRyi1NY1jhGuRPrqFgrXa04HE2kRsaWfnJvG0TbflmVcWkXGg00BbekxX03"
                );
                \Stripe\Stripe::setApiKey($stripe['secret_key']);
                //add customer to stripe
                $customer = \Stripe\Customer::create(array(
                    // 'address' => $address,
                    'email' => $user_details['email'],
                    'source'  => $stripe_token,
                    'name' => $user_details['fullname'],
                    'metadata' => $billing_details
                ));

                //charge a credit or a debit card
                $charge = \Stripe\Charge::create(array(
                    'customer' => $customer->id,
                    'amount'   => ceil($total_amount),
                    'currency' => $currency,
                    'description' => $get_cart_item_descriptions['description']
                ));
                //retrieve charge details
                $chargeJson = $charge->jsonSerialize();
                // if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){
                //     echo "<pre>";
                //     var_dump($chargeJson);
                //     echo "</pre>";
                // }
            }
        }
        // Save Order Details in order table
        private function place_order($data){
            return $this->db->query("INSERT INTO orders (user_id, order_items, billing_address, shipping_address, shipping_fee, total_amount) VALUES(?, ?, ?, ?, ?, ?)", $data);
        }
        /*  DOCU: Triggers when admin update the order status of specific order id */ 
        public function update_order_status($order_id, $status){
            $order_id = $this->security->xss_clean($order_id);
            $status = $this->security->xss_clean($status);
            return $this->db->query("UPDATE orders SET status = ? WHERE id = ?", array($status, $order_id));
        }
        /*  DOCU: Returns all orders of specific customer */ 
        public function order_history($user_id){
            return $this->db->query("SELECT id, order_items, billing_address, total_amount, status, DATE_FORMAT(created_at, '%m/%d/%Y') as order_date FROM orders WHERE user_id = ?", array($user_id))->result_array();
        }
    }
?>