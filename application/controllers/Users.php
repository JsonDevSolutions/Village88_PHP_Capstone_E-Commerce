<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    Class Users extends CI_Controller{
        public function __construct(){
            parent::__construct();
            $this->load->model('User');
        }
        /*  DOCU: Displays login page for customer */
        public function index(){
            $this->check_login_session('customer_user_id');
            $this->load->view('users/login', array('title' => 'Login', 'stylesheet_name' => 'login', 'script_file_name' => 'login', 'login_url' => 'users/process_login'));
        }
        /*  DOCU: Displays registration page */
        public function register(){
            $this->check_login_session('customer_user_id');
            $this->load->view('users/register', array('title' => 'Register', 'stylesheet_name' => 'login', 'script_file_name' => 'register'));
        }
        /*  DOCU: Triggers when customer register an account */
        public function process_register(){
            $add_user = $this->User->add_user($this->input->post());
            // 1. Check if there is any input validation errors
            // 2. Check if customer email or number already exist in database
            // 3. Add customer info into the database if no validation error occurs
            if($add_user === FALSE){
                $this->session->set_flashdata('login_error', $this->form_validation->error_array());
                $this->session->set_flashdata('input_values', $this->input->post());
                redirect(base_url('users/register'));
            }elseif($add_user === "Email or Number is invalid!"){
                $this->session->set_flashdata('login_error', array("Email or Contact Number is invalid!"));
                $this->session->set_flashdata('input_values', $this->input->post());
                redirect(base_url('users/register'));
            }elseif($add_user === TRUE){
                $this->session->set_flashdata('success', 'Successfully Registered');
                redirect(base_url('users/register'));
            }
            exit;
            $validate = $this->User->validate_registration_data();
            if($validate === TRUE){
                $this->session->set_flashdata('login_error', $this->form_validation->error_array());
                $this->session->set_flashdata('input_values', $this->input->post());
                redirect(base_url('users/register'));
            }else{
                $add_user = $this->User->add_user();
                if($add_user === TRUE){
                    $this->session->set_flashdata('success', 'Successfully Registered');
                    redirect(base_url('users/register'));
                }
            }
        }
        /*  DOCU: Triggers when customer attemps to login 
            1. Checks for any input validation errors
            2. Check for customer login credentials
        */
        public function process_login(){
            $validate = $this->User->validate_login_data();
            if($validate === TRUE){
                $this->session->set_flashdata('login_error', $this->form_validation->error_array());
                $this->session->set_flashdata('input_values', $this->input->post());
                redirect(base_url('users'));
            }else{
                $user = $this->User->check_user_email($this->input->post('email'), FALSE);
                $validate_login_credentials = $this->User->validate_login_credentials($user, $this->input->post('password'));
                if($validate_login_credentials === FALSE){
                    $this->session->set_flashdata('input_values', $this->input->post());
                    $this->session->set_flashdata('login_error', array("invalid credentials" => "Invalid email or password"));
                    redirect(base_url('users'));
                }else{
                    $this->session->set_userdata('customer_user_id', $user['id']);
                    redirect(base_url('/'));
                }
            }
        }
        /*  DOCU: Displays admin login page */
        public function admin(){
            if(!empty($this->session->userdata('admin_user_id'))){
                redirect(base_url('orders'));
            }
            $this->load->view('users/login', array('title' => 'Admin Login', 'stylesheet_name' => 'login', 'script_file_name' => 'login', 'login_url' => 'users/process_admin_login'));
        }
        /* Docu: Triggers when admin clicks the login button */
        public function process_admin_login(){
            $validate = $this->User->validate_login_data();
            if($validate === TRUE){
                $this->session->set_flashdata('login_error', $this->form_validation->error_array());
                $this->session->set_flashdata('input_values', $this->input->post());
                redirect(base_url('admin'));
            }else{
                $user = $this->User->check_user_email($this->input->post('email'), TRUE);
                $validate_login_credentials = $this->User->validate_login_credentials($user, $this->input->post('password'));
                if($validate_login_credentials === FALSE){
                    $this->session->set_flashdata('input_values', $this->input->post());
                    $this->session->set_flashdata('login_error', array("invalid credentials" => "Invalid email or password"));
                    redirect(base_url('admin'));
                }else{
                    $this->session->set_userdata('admin_user_id', $user['id']);
                    redirect(base_url('dashboard/orders'));
                }
            }
        }
        /*  DOCU: Used for checking customer or admin login session */
        private function check_login_session($user_session){
            if($this->session->userdata($user_session)){
                redirect(base_url('products/show_all/1'));
            }
        }
        /*  DOCU: Triggers when customer click the logout link */
        public function logout_user(){
            $this->session->unset_userdata('customer_user_id');
            redirect(base_url('users'));
        }
        /*  DOCU: Triggers when admin click the logout link */
        public function logout_admin(){
            $this->session->unset_userdata('admin_user_id');
            redirect(base_url('users/admin'));
        }
    }
?>