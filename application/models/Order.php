<?php 
    CLass Order extends CI_Model{
        private function place_order($data){
            $this->db->query("INSERT INTO orders (user_id, billing_address, shipping_address, shipping_fee, total_amount) VALUES(?, ?, ?, ?, ?)", $data);
            return $this->db->insert_id();
        }
        private function add_order_details($data){
            $this->db->query("INSERT INTO order_details (order_id, product_id, product_name, quantity, price, total) VALUES(?, ?, ?, ?, ?, ?)", $data);
        }
        public function get_order_list(){
            return $this->db->query("SELECT id, billing_address, total_amount, status, DATE_FORMAT(created_at, '%m/%d/%Y') as order_date FROM orders where id like ?",array("%6%"))->result_array();
        }
        public function get_order_by_id($order_id){
            $order_id = $this->security->xss_clean($order_id);
            return $this->db->query("SELECT id, billing_address, shipping_address, shipping_fee, total_amount, status, DATE_FORMAT(created_at, '%m/%d/%Y') as order_date FROM orders WHERE id = ?", array($order_id))->row_array();
        }
        public function calculate_total($products, $cart){
            $total = 0;
            foreach($products as $product){
                $total += ($product['price'] * $cart[$product['id']]);
            }
            return $total;
        }
        public function add_order($order_data, $total_amount, $cart_products, $cart){
            $data = array(
                'user_id' => 2,
                'billing_address' => json_encode(array(
                    'first_name' => $order_data['first_name'][0],
                    'last_name' => $order_data['last_name'][0],
                    'address' => $order_data['address_one'][0],
                    'address_two' => $order_data['address_two'][0],
                    'city' => $order_data['city'][0],
                    'state' => $order_data['state'][0],
                    'zip_code' => $order_data['zip_code'][0]
                )),
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
            $order_id = $this->place_order($data);
            // Save Cart Products to Order Details Table
            foreach($cart_products as $product){
                $data = array(
                    'order_id' => $order_id,
                    'product_id' => $product['id'],
                    'product_name' => $product['name'],
                    'quantity' => $cart[$product['id']],
                    'price' => $product['price'],
                    'total' => $product['price'] * $cart[$product['id']]
                );
                $this->add_order_details($data);
            }
            if($order_id != NULL){
                return TRUE;
            }else{
                return FALSE;
            }
        }
    }
?>