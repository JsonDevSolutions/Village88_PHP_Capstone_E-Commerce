<?php
    Class Comment extends CI_Model{
        /*  DOCU: Returns list of comments for specific product */ 
        public function display_comments($product_id){
            return $this->db->query("SELECT c.id AS comment_id, CONCAT(u.first_name, ' ', u.last_name) AS fullname, content, DATE_FORMAT(c.created_at, '%m/%d/%Y') AS comment_date  FROM comments c LEFT JOIN users u ON c.user_id = u.id where c.product_id = ? order by c.created_at DESC", array($product_id))->result_array();
        }
        /*  DOCU: Triggers when registered user comments in specific product */ 
        public function add_comment($comment, $user_id){
            return $this->db->query("INSERT INTO comments (product_id, user_id, content) VALUES(?, ?, ?)", array($comment['product_id'], $user_id, $comment['content']));
        }
    }
?>