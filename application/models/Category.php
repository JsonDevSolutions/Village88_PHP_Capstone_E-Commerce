<?php 
    Class Category extends CI_Model{
        public function get_category_list(){
            return $this->db->query("SELECT id, name FROM categories")->result_array();
        }
        public function categories_product_count(){
            return $this->db->query("SELECT c.id, c.name, COUNT(*) AS product_count FROM  categories c LEFT JOIN products pd ON pd.category_id = c.id GROUP BY pd.category_id")->result_array();
        }
        public function get_category_name($category_id){
            return $this->db->query("SELECT name FROM categories where id = ?", array($category_id))->row();
        }
    }
?>