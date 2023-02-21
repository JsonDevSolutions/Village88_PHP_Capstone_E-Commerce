<?php 
    CLass Order extends CI_Model{
        private function place_order($data){
            return $this->db->query("INSERT INTO orders (user_id, order_items, billing_address, shipping_address, shipping_fee, total_amount) VALUES(?, ?, ?, ?, ?, ?)", $data);
        }
        public function get_order_list($limit, $offset){
            return $this->db->query("SELECT id, billing_address, total_amount, status, DATE_FORMAT(created_at, '%m/%d/%Y') as order_date FROM orders limit ? OFFSET ?", array($limit, $offset))->result_array();
        }
        public function get_filtered_order_list($filter, $limit, $offset){
            $search = $this->security->xss_clean($filter['search_order']);
            $filter_by = $this->security->xss_clean($filter['filter_order']);
            $row_count = $this->get_order_list_count($search, $filter_by);

            if($filter_by == 'Show all'){
                $query = "SELECT id, billing_address, total_amount, status, DATE_FORMAT(created_at, '%m/%d/%Y') as order_date FROM orders WHERE id LIKE ? OR JSON_EXTRACT(billing_address, '$.first_name') LIKE ? OR JSON_EXTRACT(billing_address, '$.last_name') LIKE ? limit ? OFFSET ?";
                $values = array("%" . $search . "%", "%" . $search . "%", "%" . $search . "%", $limit, $offset);
            }else{
                $query = "SELECT id, billing_address, total_amount, status, DATE_FORMAT(created_at, '%m/%d/%Y') as order_date FROM orders WHERE (id LIKE ? OR JSON_EXTRACT(billing_address, '$.first_name') LIKE ? OR JSON_EXTRACT(billing_address, '$.last_name') LIKE ?) AND status = ? limit ? OFFSET ?";
                $values = array("%" . $search . "%", "%" . $search . "%", "%" . $search . "%", $filter_by, $limit, $offset);
            }
            $orders = $this->db->query($query, $values)->result_array();
            return array('row_count' => $row_count, 'orders' => $orders);
        }
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
        public function get_order_by_id($order_id){
            $order_id = $this->security->xss_clean($order_id);
            return $this->db->query("SELECT id, order_items, billing_address, shipping_address, shipping_fee, total_amount, status, DATE_FORMAT(created_at, '%m/%d/%Y') as order_date FROM orders WHERE id = ?", array($order_id))->row_array();
        }
        public function calculate_total($products, $cart){
            $total = 0;
            foreach($products as $product){
                $total += ($product['price'] * $cart[$product['id']]);
            }
            return $total;
        }
        public function add_order($user_id, $order_data, $total_amount, $order_details){
            $data = array(
                'user_id' => $user_id,
                'order_items' => json_encode($order_details),
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
            return $this->place_order($data);
        }
        public function update_order_status($order_id, $status){
            $order_id = $this->security->xss_clean($order_id);
            $status = $this->security->xss_clean($status);
            return $this->db->query("UPDATE orders SET status = ? WHERE id = ?", array($status, $order_id));
        }
    }
?>