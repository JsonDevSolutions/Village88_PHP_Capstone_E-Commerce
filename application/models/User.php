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
        public function check_admin_email($email){
            $email = $this->security->xss_clean($email);
            return $this->db->query("SELECT * FROM users WHERE email = ? and is_admin = ?", array($email, 1))->row_array();
        }
        // Validations
        public function validate_login_data(){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
            if($this->form_validation->run() == FALSE){
                return TRUE;
            }else{
                return FALSE;
            }
        }
        public function validate_admin_login($user, $password){
            $user = $this->security->xss_clean($user);
            $password = $this->security->xss_clean($password);
            if($user != NULL){
                $salt = $user['salt'];
                $encrypted_password = md5($password . '' . $salt);
                if($user['password'] === $encrypted_password){
                    $this->session->set_userdata('admin_user_id', $user['id']);
                    return TRUE;
                }else{
                    return FALSE;
                }
            }else{
                return FALSE;
            }
        }
    }
?>