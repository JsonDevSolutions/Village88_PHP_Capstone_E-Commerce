<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    Class Users extends CI_Controller{
        public function __construct(){
            parent::__construct();
            $this->load->model('User');
        }
        public function index(){
            $this->check_login_session('customer_user_id');
            $this->load->view('users/login', array('title' => 'Login', 'stylesheet_name' => 'login', 'script_file_name' => 'login', 'login_url' => 'users/process_login'));
        }
        public function register(){
            $this->check_login_session('customer_user_id');
            $this->load->view('users/register', array('title' => 'Register', 'stylesheet_name' => 'login', 'script_file_name' => 'register'));
        }
        public function process_register(){
            $add_user = $this->User->add_user($this->input->post());
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
                    redirect(base_url('products/show_all/1'));
                }
            }
        }
        public function admin(){
            if(!empty($this->session->userdata('admin_user_id'))){
                redirect(base_url('orders/order_list'));
            }
            $this->load->view('users/login', array('title' => 'Admin Login', 'stylesheet_name' => 'login', 'script_file_name' => 'login', 'login_url' => 'users/process_admin_login'));
        }
        public function process_admin_login(){
            $validate = $this->User->validate_login_data();
            if($validate === TRUE){
                $this->session->set_flashdata('login_error', $this->form_validation->error_array());
                $this->session->set_flashdata('input_values', $this->input->post());
                redirect(base_url('users/admin'));
            }else{
                $user = $this->User->check_user_email($this->input->post('email'), TRUE);
                $validate_login_credentials = $this->User->validate_login_credentials($user, $this->input->post('password'));
                if($validate_login_credentials === FALSE){
                    $this->session->set_flashdata('input_values', $this->input->post());
                    $this->session->set_flashdata('login_error', array("invalid credentials" => "Invalid email or password"));
                    redirect(base_url('users/admin'));
                }else{
                    $this->session->set_userdata('admin_user_id', $user['id']);
                    redirect(base_url('orders/order_list'));
                }
            }
        }
        private function check_login_session($user_session){
            if($this->session->userdata($user_session)){
                redirect(base_url('products/show_all/1'));
            }
        }
        public function logout_user(){
            $this->session->unset_userdata('customer_user_id');
            redirect(base_url('users'));
        }
    }
?>