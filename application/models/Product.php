<?php
    Class Product extends CI_Model{
        /*  DOCU: Default: Display product list base order by id 
            1. Returns list of product depending on the search product name
            2. Return product list depending on the applied filter (Price or most popular product)
        */ 
        public function get_all_product_list($product_name, $sort_by, $limit, $offset){
            $product_name = $this->security->xss_clean($product_name);
            $sort_by = $this->sort_by($this->security->xss_clean($sort_by));
            $row_count = $this->get_all_product_count('', $product_name, $sort_by);

            $query = "SELECT JSON_UNQUOTE(JSON_EXTRACT(p.image_filenames, '$.main')) AS main_image, p.id, p.name, c.name AS category_name, p.price, p.onhand as inventory_count, p.sold as qty_sold FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.name LIKE ? {$sort_by} limit ? OFFSET ?";
            $product = $this->db->query($query, array("%" . $product_name . "%", $limit, $offset))->result_array();
            return array('row_count' => $row_count, 'product' => $product);
        }
        /*  DOCU: Returns product lists for admin page */ 
        public function get_product_list($product_name, $limit, $offset){
            $product_name = $this->security->xss_clean($product_name);

            $query = "SELECT JSON_UNQUOTE(JSON_EXTRACT(p.image_filenames, '$.main')) AS main_image, p.id, p.name, c.name AS category_name, p.price, p.onhand as inventory_count, p.sold as qty_sold FROM products p LEFT JOIN categories c ON p.category_id = c.id where p.name like ? ORDER BY p.id DESC limit ? OFFSET ?";
            $product = $this->db->query($query, array("%" . $product_name . "%", $limit, $offset))->result_array();
            return $product;
        }
        /*  DOCU: Returns product details of specific id */ 
        public function get_product_by_id($id){
            $query = "SELECT p.id, p.category_id, JSON_REMOVE(p.image_filenames, '$.max', '$.\"max\"') AS images, c.name AS category_name, p.name, p.description, p.price FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ?";
            return $this->db->query($query, array($id))->row_array();
        }
        /*  DOCU: Returns product details for cart items of guest user */ 
        public function get_carts_product($product_ids){
            $query = "SELECT id, name, price FROM products where id IN ?";
            return $this->db->query($query, array($product_ids))->result_array();
        }
        /*  DOCU: Returns total amount of cart items in the cart of guest user */ 
        public function get_carts_total($product_ids){
            $query = "SELECT id, name, price FROM products where id IN ?";
            return $this->db->query($query, array($product_ids))->result_array();
        }
        /*  DOCU: Returns all similar product of each product based on category */ 
        public function get_similar_products($product_id, $category_id){
            $query = "SELECT p.id, c.name AS category_name, p.name, p.price, JSON_UNQUOTE(JSON_EXTRACT(p.image_filenames, '$.main')) AS main_image FROM products p LEFT JOIN categories c ON p.category_id = c.id where p.id != ? AND p.category_id = ? LIMIT 10";
            return $this->db->query($query, array($product_id, $category_id))->result_array();
        }
        /*  DOCU: Display all products from given category */
        public function get_product_per_category($category_id, $product_name, $sort_by, $limit, $offset){
            $product_name = $this->security->xss_clean($product_name);
            $sort_by = $this->sort_by($this->security->xss_clean($sort_by));
            $row_count = $this->get_all_product_count($category_id, $product_name, $sort_by);

            $query = "SELECT p.id, p.category_id, c.name AS category_name, p.name, p.price, JSON_UNQUOTE(JSON_EXTRACT(p.image_filenames, '$.main')) AS main_image FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.category_id = ? AND p.name LIKE ? {$sort_by} limit ? OFFSET ?";
            $product = $this->db->query($query, array($category_id, "%" . $product_name . "%", $limit, $offset))->result_array();
            return array('row_count' => $row_count, 'product' => $product);
        }
        /*  DOCU: Returns number of products that will be used for pagination */
        private function get_all_product_count($category_id, $product_name, $sort_by){
            $query = "SELECT COUNT(*) AS count FROM products p where p.category_id like ? AND p.name like ? {$sort_by}";
            return $this->db->query($query, array("%" . $category_id . "%", "%" . $product_name . "%"))->row();
        }
        /*  DOCU: Used for sorting data (most popular, price(low to high), price(high to low)) */
        private function sort_by($data){
            if($data == 1){
                return "order by p.sold desc";
            }elseif($data == 2){
                return "order by p.price asc";
            }elseif($data == 3){
                return "order by p.price desc";
            }else{
                return "order by p.id desc";
            }
        }
        /*  DOCU: Returns number of products of specific category */
        public function get_product_count_per_category($category_id){
            $query = "SELECT COUNT(*) AS count FROM products where category_id = ?";
            return $this->db->query($query, array($category_id))->row();
        }
        /*  DOCU: Returns the max image name for specific category, to be used for saving images in the directory */
        public function get_category_max_image_count($category_id){
            $query = "SELECT IFNULL(MAX(CONVERT(JSON_EXTRACT(image_filenames, '$.max'), UNSIGNED)), 0) AS max_num_image FROM products WHERE products.category_id = ?";
            return $this->db->query($query, array($category_id))->row();
        }
        /*  DOCU: Triggers when admin add new product */
        public function add_product($product, $image_filenames, $category_id){
            $name = $this->security->xss_clean($product['name']);
            $description = $this->security->xss_clean($product['description']);
            $price = $this->security->xss_clean($product['price']);
            $onhand = $this->security->xss_clean($product['stocks']);
            $image_filenames = json_encode($image_filenames);
            $query = "INSERT INTO products (category_id, name, description, price, onhand, image_filenames) VALUES(?, ?, ?, ?, ?, ?)";
            return $this->db->query($query, array($category_id, $name, $description, $price, $onhand, $image_filenames));
        }
        /*  DOCU: Triggers when admin update specific product */
        public function update_product($product, $image_filenames, $product_id, $category_id){
            $name = $this->security->xss_clean($product['name']);
            $description = $this->security->xss_clean($product['description']);
            $price = $this->security->xss_clean($product['price']);
            $onhand = $this->security->xss_clean($product['stocks']);
            $image_filenames = json_encode($image_filenames);
            $query = "UPDATE products SET category_id = ?, name = ?, description = ?, price = ?, onhand = ?, image_filenames = ? where id = ?";
            return $this->db->query($query, array($category_id, $name, $description, $price, $onhand, $image_filenames, $product_id));
        }
        /*  DOCU: Triggers when admin delete specific product */
        public function delete_product($product_id){
            $name = $this->security->xss_clean($product_id);
            return $this->db->query("DELETE FROM products where id = ?", array($product_id));
        }
        /*  DOCU: Returns product details of specific product */
        public function get_product_details($product_id){
            $query = "SELECT p.id, c.name AS category_name, p.name AS product_name, p.description, p.price, p.onhand, p.image_filenames FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ?";
            return $this->db->query($query, array($product_id))->row_array();
        }
        /*  DOCU: Used for checking if image filename exist in image filename list of specific product */
        public function check_value_exist($product_id){
            $query ="SELECT JSON_REMOVE(image_filenames, '$.main', '$.max', '$.\"main\"', '$.\"max\"') AS image_names FROM products WHERE products.id = ?";
            return $this->db->query($query, array($product_id))->row();
        }
        /*  DOCU: Get Category name of specific product */
        public function get_product_category_name($product_id){
            return $this->db->query("SELECT c.name from products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ?", array($product_id))->row();
        }
    }
?>