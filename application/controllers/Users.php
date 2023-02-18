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
    }
?>