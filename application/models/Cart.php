<?php
    date_default_timezone_set('Asia/Manila');
    Class Cart extends CI_Model{
        /*  DOCU: Triggers when customer add item to cart 
            1. Apply XSS Security
            2. if item already exist in the cart, it will only update the quantity
            3. Insert new item in the cart if it does not exist
        */
        public function process_cart_item($product, $user_id){
            $product_id = $this->security->xss_clean($product['product_id']);
            $quantity = $this->security->xss_clean($product['quantity']);

            if($this->validate_cart_data() === TRUE){
                return FALSE;
            }elseif(!$this->check_product_exist($product_id)){
                return "Product Does not exist!";
            }
            if($this->check_cart_item_exist($product_id, $user_id)->count != 0){
                return $this->update_cart_item($user_id, $product_id, $quantity);
            }else{
                return $this->insert_cart_item($user_id, $product_id, $quantity);
            }
        }
        /*  DOCU: Delete specific product in cart for a specific customer */ 
        public function delete_cart_item($product_id, $user_id){
            $product_id = $this->security->xss_clean($product_id);
            $user_id = $this->security->xss_clean($user_id);
            return $this->db->query("DELETE FROM cart_items WHERE user_id = ? AND product_id = ?", array($user_id, $product_id));
        }
        /*  DOCU: Triggers when customer update quantity of specific product for a specific customer */ 
        public function update_cart_item_qty($user_id, $product_id, $quantity){
            return $this->db->query("UPDATE cart_items SET quantity = ? WHERE user_id = ? and product_id = ?", array($quantity, $user_id, $product_id));
        }
        /*  DOCU: Returns number of unique items in the cart of specific customer */ 
        public function get_total_items($user_id){
            return $this->db->query("SELECT COUNT(*) AS num_items FROM cart_items WHERE user_id = ?", array($user_id))->row_array();
        }
        /*  DOCU: Returns list of items */ 
        public function get_cart_items($user_id){
            $query = "SELECT cart_items.product_id AS id, products.name, products.price, cart_items.quantity, (cart_items.quantity * products.price) AS total 
                        FROM cart_items LEFT JOIN products ON cart_items.product_id = products.id WHERE user_id = ?";
            return $this->db->query($query, array($user_id))->result_array();
        }
        /*  DOCU: Get concatenated product description that will be used in stripe payment history */ 
        public function get_cart_item_descriptions($user_id){
            return $this->db->query("SELECT GROUP_CONCAT(CONCAT(products.name) SEPARATOR ', ') AS description FROM cart_items INNER JOIN products ON products.id = cart_items.product_id WHERE user_id = ?", array($user_id))->row_array();
        }
        /*  DOCU: Returns total amount of cart items */ 
        public function get_total_cart_amount($user_id){
            return $this->db->query("SELECT SUM((cart_items.quantity * products.price)) AS total FROM cart_items LEFT JOIN products ON cart_items.product_id = products.id WHERE user_id = ?", array($user_id))->row();
        }
        /*  DOCU: Returns cart item details for guest user */ 
        public function guest_cart_details($cart_items, $cart){
            $order_details = array();
            foreach($cart_items as $cart_item){
                $order_details[$cart_item['id']] = array($cart_item['name'], $cart[$cart_item['id']], $cart_item['price']);
            }
            return $order_details;
        }
        /*  DOCU: Returns cart item details for registered user */ 
        public function user_cart_details($cart_items){
            $order_details = array();
            foreach($cart_items as $cart_item){
                $this->db->query("UPDATE products SET sold = sold + ? WHERE id = ?", array($cart_item['quantity'], $cart_item['id']));
                $order_details[$cart_item['id']] = array($cart_item['name'], $cart_item['quantity'], $cart_item['price']);
            }
            return $order_details;
        }
        /*  DOCU: Triggers when customer place an order, it will remove all items in the cart for a specific customer */ 
        public function remove_cart_items($user_id){
            $user_id = $this->security->xss_clean($user_id);
            return $this->db->query("DELETE FROM cart_items WHERE user_id = ?", array($user_id));
        }
        /*  DOCU: Triggers when item does not exist in the cart */ 
        private function insert_cart_item($user_id, $product_id, $quantity){
            $query = "INSERT INTO cart_items (user_id, product_id, quantity, created_at, updated_at) VALUES(?, ?, ?, ?, ?)";
            $values = array($user_id, $product_id, $quantity, date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));
            return $this->db->query($query, $values);
        }
        /*  DOCU: Returns total amount of cart items */ 
        private function update_cart_item($user_id, $product_id, $quantity){
            return $this->db->query("UPDATE cart_items SET quantity = quantity + ? WHERE user_id = ? and product_id = ?", array($quantity, $user_id, $product_id));
        }
        /*  DOCU: Used for validating item data, to ensure valid product info that will be added in the cart */
        private function validate_cart_data(){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('product_id', 'Product ID', 'trim|required|integer|greater_than[0]');
            $this->form_validation->set_rules('quantity', 'Quantity', 'trim|required|integer|greater_than[0]');
            if($this->form_validation->run() == FALSE){
                return TRUE;
            }
        }
        /*  DOCU: Used for checking if product exist in database, incase customer change product id via inspect element */
        private function check_product_exist($product_id){
            if(!empty($product_id)){
                $product_exist = $this->db->query("SELECT COUNT(*) as count FROM products where id = ?", array($product_id))->row();
                if($product_exist->count == 0){
                    return FALSE;
                }else{
                    return TRUE;
                }
            }else{
                return FALSE;
            }
        }
        /*  DOCU: Used for checking if item is already in the cart of a specific custoner */
        private function check_cart_item_exist($product_id, $user_id){
            return $this->db->query("SELECT COUNT(*) as count FROM cart_items WHERE user_id = ? AND product_id = ?", array($user_id, $product_id))->row();
        }
    }
?>