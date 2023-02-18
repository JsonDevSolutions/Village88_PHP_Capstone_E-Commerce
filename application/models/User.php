<?php 
    Class User extends CI_Model{
        public function add_user(){
            $salt = bin2hex(openssl_random_pseudo_bytes(22));
            $first_name = $this->input->post('first_name', TRUE);
            $last_name = $this->input->post('last_name', TRUE);
            $email = $this->input->post('email', TRUE);
            $contact_number = $this->input->post('contact_number', TRUE);
            $password = md5($this->input->post('password', TRUE) . '' . $salt);
            $query = "INSERT INTO users (first_name, last_name, email, contact_number, password, salt, is_admin) VALUES(?, ?, ?, ?, ?, ?, ?)";
            $values = array($first_name, $last_name, $email, $contact_number, $password, $salt, '1');
            return $this->db->query($query, $values);
        }
        // private check_user_count(){

        // }
    }
?>