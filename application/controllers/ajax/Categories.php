<?php
require_once(APPPATH.'controllers/ajax/Ajax_Controller.php');

class Categories extends Ajax_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->lang->load('storage', session_site_lang());
        $this->load->model('categories_model');
    }

    public function index()
    {
        $categories = $this->categories_model->get_all_categories();
        $data = array();
            if (!is_null($categories))
            {
                $data['status'] = TRUE;
                $data['data'] = $categories;
            }
            else
            {
                $data['status'] = FALSE;
            }
            echo json_encode($data);
    }
}
