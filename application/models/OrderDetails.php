<?php 
    Class OrderDetails extends CI_Model{
        public function get_order_details_by_id($order_id){
            return $this->db->query("SELECT * FROM order_details where order_id = ?", array($order_id))->result_array();
        }
        public function add_order_details($order_id, $user_id){
            $this->db->query("INSERT INTO order_details (order_id, product_id, product_name, quantity, price, total) VALUES(?, ?, ?, ?, ?, ?)", $data);
        }
    }
?>