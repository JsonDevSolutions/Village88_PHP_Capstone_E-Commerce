<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    Class Users extends CI_Controller{
        public function __construct(){
            parent::__construct();
            $this->load->model('User');
        }
        public function index(){
            $this->load->view('users/login');
        }
        public function register(){
            $this->load->view('users/register');
        }
        public function process_register(){
            $add_user = $this->User->add_user();
            if($add_user === TRUE){
                echo "Registered Successfully";
            }
        }
        public function process_login(){
            
        }
        public function admin(){
            if(!empty($this->session->userdata('admin_user_id'))){
                redirect(base_url('orders/order_list'));
            }
            $this->load->view('admin/login');
        }
        public function process_admin_login(){
            $validate = $this->User->validate_login_data();
            if($validate === TRUE){
                $this->session->set_flashdata('login_error', $this->form_validation->error_array());
                $this->session->set_flashdata('input_values', $this->input->post());
                redirect(base_url('users/admin'));
            }else{
                $user = $this->User->check_admin_email($this->input->post('email'));
                $validate_login_credentials = $this->User->validate_admin_login($user, $this->input->post('password'));
                if($validate_login_credentials === FALSE){
                    $this->session->set_flashdata('input_values', $this->input->post());
                    $this->session->set_flashdata('login_error', array("invalid credentials" => "Invalid username or password"));
                    redirect(base_url('users/admin'));
                }else{
                    redirect(base_url('orders/order_list'));
                }
            }
        }
    }
?>