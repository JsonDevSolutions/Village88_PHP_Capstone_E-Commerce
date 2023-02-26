<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    Class Categories extends CI_Controller{
        public function __construct(){
            parent::__construct();
            $this->load->model('Category');
        }
        /*  DOCU: Triggers when user updates category name */
        public function update($category_id){
            $update_category = $this->Category->update_category($this->input->post('category_name'), $category_id);
            if($update_category){
                echo true;
            }
        }
        /*  DOCU: Triggers when user delete category */
        public function delete_category($category_id){
            if($this->Category->delete_category($category_id)){
                $this->html_category();
            }
        }
        /*  DOCU: Returns category list */
        public function html_category(){
            $category = $this->Category->get_category_list();
            $this->load->view('partials/category_dropdown_list', array('categories' => $category));
        }
    }

?>