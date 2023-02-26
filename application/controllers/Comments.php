<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    Class Comments extends CI_Controller{
        public function __construct(){
            parent::__construct();
            $this->load->model('Comment');
            $this->load->model('Reply');
        }
        /*  DOCU: Triggers when user comments to a specific product */
        public function add_comment(){
            $add_comment = $this->Comment->add_comment($this->input->post(), $this->session->userdata('customer_user_id'));
            if($add_comment){
                echo "added";
            }
        }
        /*  DOCU: returns list of comments */
        public function comment_list_html($product_id){
            $comments = $this->Comment->display_comments($product_id);
            $replies = $this->Reply->get_replies($product_id);
            $this->load->view('partials/comment_list', array('comments' => $comments, 'replies' => $replies, 'product_id' => $product_id));
        }
    }
?>