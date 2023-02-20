<?php 
    Class Product extends CI_Model{
        // public function get_all_product_list($limit, $offset){
        //     return $this->db->query("SELECT main_image_url, sub_image_urls, id, name, price, onhand as inventory_count, sold as qty_sold FROM products limit ? OFFSET ?", array($limit, $offset))->result_array();
        // }
        // Catalog Page
        public function get_all_product_list($product_name, $sort_by, $limit, $offset){
            $product_name = $this->security->xss_clean($product_name);
            $sort_by = $this->sort_by($this->security->xss_clean($sort_by));
            $row_count = $this->get_all_product_count($product_name, $sort_by);

            $query = "SELECT main_image_url, sub_image_urls, id, name, price, onhand as inventory_count, sold as qty_sold FROM products where name like ? {$sort_by} limit ? OFFSET ?";
            $product = $this->db->query($query, array("%" . $product_name . "%", $limit, $offset))->result_array();
            return array('row_count' => $row_count, 'product' => $product);
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
        // Display all products from given category
        public function get_product_per_category($category_id, $product_name, $sort_by, $limit, $offset){
            $product_name = $this->security->xss_clean($product_name);
            $sort_by = $this->sort_by($this->security->xss_clean($sort_by));
            $query = "SELECT id, category_id, name, price, main_image_url, sub_image_urls FROM products where category_id = ? and name LIKE ? {$sort_by} limit ? OFFSET ?";
            return $this->db->query($query, array($category_id, "%" . $product_name . "%", $limit, $offset))->result_array();
        }
        // Return Number of pages
        private function get_all_product_count($product_name, $sort_by){
            $query = "SELECT COUNT(*) AS count FROM products where name like ? {$sort_by}";
            return $this->db->query($query, array("%" . $product_name . "%"))->row();
        }
        // Used for sorting data (most popular, price(low to high), price(high to low))
        private function sort_by($data){
            if($data == 1){
                return "order by sold desc";
            }elseif($data == 2){
                return "order by price asc";
            }elseif($data == 3){
                return "order by price desc";
            }else{
                return "order by id asc";
            }
        }
        // public function get_product_per_category($category_id, $limit, $offset){
        //     $query = "SELECT id, category_id, name, price, main_image_url FROM products where category_id = ? limit ? OFFSET ?";
        //     return $this->db->query($query, array($category_id, $limit, $offset))->result_array();
        // }
        public function get_product_count_per_category($category_id){
            $query = "SELECT COUNT(*) AS count FROM products where category_id = ?";
            return $this->db->query($query, array($category_id))->row();
        }
    }
?>