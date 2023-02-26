<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    Class Replies extends CI_Controller{
        /*  DOCU: Triggers when customer comments to a specific product */
        public function add_reply(){
            $this->load->model('Reply');
            $add_reply = $this->Reply->add_reply($this->input->post(), $this->session->userdata('customer_user_id'));
            if($add_reply){
                echo "Save";
            }
        }
    }
?>