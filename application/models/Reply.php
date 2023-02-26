<?php
    Class Reply extends CI_Model{
        /*  DOCU: Returns list of replies of specific product */
        public function get_replies($product_id){
            return $this->db->query("SELECT r.id AS reply_id, r.comment_id AS comment_id, CONCAT(u.first_name, ' ', u.last_name) AS fullname, r.content, r.created_at AS reply_date  FROM replies r LEFT JOIN users u ON r.user_id = u.id where r.product_id = ?", array($product_id))->result_array();
        }
        /*  DOCU: Triggers when customer replies to specific comment of specific product */
        public function add_reply($reply, $user_id){
            return $this->db->query("INSERT INTO replies (comment_id, product_id, user_id, content) VALUES(?, ?, ?, ?)", array($reply['comment_id'], $reply['product_id'], $user_id, $reply['content']));
        }
    }
?>