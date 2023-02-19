<?php 
    Class Product extends CI_Model{
        public function get_all_product_list($limit, $offset){
            return $this->db->query("SELECT main_image_url, sub_image_urls, id, name, price, onhand as inventory_count, sold as qty_sold FROM products limit ? OFFSET ?", array($limit, $offset))->result_array();
        }
        public function get_product_by_id($id){
            $query = "SELECT id, category_id, name, description, price, main_image_url, sub_image_urls FROM products where id = ?";
            return $this->db->query($query, array($id))->row_array();
        }
        public function get_carts_product($product_ids){
            $query = "SELECT id, name, price FROM products where id IN ?";
            return $this->db->query($query, array($product_ids))->result_array();
        }
        public function get_carts_total($product_ids){
            $query = "SELECT id, name, price FROM products where id IN ?";
            return $this->db->query($query, array($product_ids))->result_array();
        }
        public function get_similar_products($product_id, $category_id){
            $query = "SELECT id, name, price, main_image_url FROM products where id != ? AND category_id = ? LIMIT 10";
            return $this->db->query($query, array($product_id, $category_id))->result_array();
        }
        public function get_product_per_category($category_id, $limit, $offset){
            $query = "SELECT id, category_id, name, price, main_image_url FROM products where category_id = ? limit ? OFFSET ?";
            return $this->db->query($query, array($category_id, $limit, $offset))->result_array();
        }
        public function get_all_product_count(){
            $query = "SELECT COUNT(*) AS count FROM products";
            return $this->db->query($query)->row();
        }
        public function get_product_count_per_category($category_id){
            $query = "SELECT COUNT(*) AS count FROM products where category_id = ?";
            return $this->db->query($query, array($category_id))->row();
        }
    }
?>