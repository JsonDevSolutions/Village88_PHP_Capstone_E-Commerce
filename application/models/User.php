<?php
    Class User extends CI_Model{
        /*  DOCU: Triggers when user registers in the website 
            1. Triggers input validations to check if there is any validation errors
            2. Check if email or contact number is already registered or not
            3. First registered user will be tagged as admin, the rest will be tagged as customers
        */
        public function add_user($user){
            if($this->validate_registration_data() === TRUE){
                return FALSE;
            }elseif($this->check_user_number_or_email($this->security->xss_clean($user['email']), $this->security->xss_clean($user['contact_number']))->count != 0){
                return "Email or Number is invalid!";
            }
            $salt = bin2hex(openssl_random_pseudo_bytes(22));
            $first_name =  $this->security->xss_clean($user['first_name']);
            $last_name = $this->security->xss_clean($user['last_name']);
            $email = $this->security->xss_clean($user['email']);
            $contact_number = $this->security->xss_clean($user['contact_number']);
            $password = md5($this->security->xss_clean($user['password']) . '' . $salt);
            if($this->check_user_count()->count == 0){
                $query = "INSERT INTO users (first_name, last_name, email, contact_number, password, salt, is_admin) VALUES(?, ?, ?, ?, ?, ?, ?)";
                $values = array($first_name, $last_name, $email, $contact_number, $password, $salt, 1);
            }else{
                $query = "INSERT INTO users (first_name, last_name, email, contact_number, password, salt) VALUES(?, ?, ?, ?, ?, ?)";
                $values = array($first_name, $last_name, $email, $contact_number, $password, $salt);
            }
            return $this->db->query($query, $values);
        }
        /*  DOCU: Returns user data of the login user */
        public function get_user_data($user_id){
            return $this->db->query("SELECT id, email, CONCAT(first_name, ' ', last_name) AS fullname FROM Users where id = ?", array($user_id))->row_array();
        }
        /*  DOCU: Used for checking if database user is empty or not */
        private function check_user_count(){
            return $this->db->query("SELECT COUNT(*) as count from users")->row();
        }
        /*  DOCU: Used for checking the existence of email or number entered in the registration page */
        private function check_user_number_or_email($email, $contact_number){
            return $this->db->query("SELECT COUNT(*) as count from users where email =? OR contact_number = ?", array($email, $contact_number))->row();
        }
        /*  DOCU: Used for checking the existence of email as login credentials */
        public function check_user_email($email, $admin){
            $email = $this->security->xss_clean($email);
            if($admin === TRUE){
                return $this->db->query("SELECT * FROM users WHERE email = ? and is_admin = ?", array($email, 1))->row_array();
            }else{
                return $this->db->query("SELECT * FROM users WHERE email = ? and is_admin = ?", array($email, 0))->row_array();
            }
        }
        /*  DOCU: Used for validatin input values and Login Credentials */
        private function validate_registration_data(){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[2]');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|min_length[2]');
            $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
            $this->form_validation->set_rules("contact_number", "Contact Number", "trim|required|numeric|exact_length[11]");
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
            if($this->form_validation->run() == FALSE){
                return TRUE;
            }
        }
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
        public function validate_login_credentials($user, $password){
            $user = $this->security->xss_clean($user);
            $password = $this->security->xss_clean($password);
            if($user != NULL){
                $salt = $user['salt'];
                $encrypted_password = md5($password . '' . $salt);
                if($user['password'] === $encrypted_password){
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