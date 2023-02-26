<?php
    Class Category extends CI_Model{
        /*  DOCU: Returns all category list */ 
        public function get_category_list(){
            return $this->db->query("SELECT id, name FROM categories")->result_array();
        }
        /*  DOCU: Returns number of products for each category */ 
        public function categories_product_count(){
            return $this->db->query("SELECT c.id, c.name, COUNT(*) AS product_count FROM  categories c LEFT JOIN products pd ON pd.category_id = c.id GROUP BY pd.category_id")->result_array();
        }
        /*  DOCU: Returns specific category name based on a given category_id */ 
        public function get_category_name($category_id){
            return $this->db->query("SELECT name FROM categories where id = ?", array($category_id))->row();
        }
        /*  DOCU: Used for checking Category Name, Save Category Name if not exist in database */ 
        public function get_category_id($category_name){
            $category_name = $this->security->xss_clean($category_name);
            $category = $this->db->query("SELECT id FROM categories where name = ?", array($category_name))->row_array();
            if($category != NULL){
                return $category['id'];
            }else{
                return $this->create_category($category_name);
            }
        }
        /*  DOCU: Triggers when category name does not exist in database */ 
        private function create_category($category_name){
            $this->db->query("INSERT INTO categories (name) VALUES(?)", array($category_name));
            return $this->db->insert_id();
        }
        /*  DOCU: Used for updating category name */ 
        public function update_category($category_name, $category_id){
            $category_name = $this->security->xss_clean($category_name);
            return $this->db->query("UPDATE categories SET name = ? WHERE id = ?", array($category_name, $category_id));
        }
        /*  DOCU: triggers when admin delete specific category */ 
        public function delete_category($category_id){
            return $this->db->query("DELETE FROM categories where id = ?", array($category_id));
        }
    }
?>