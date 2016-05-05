<?php
require_once(APPPATH.'controllers/ajax/Ajax_Controller.php');

class Subtypes extends Ajax_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->lang->load('subtypes', session_site_lang());
        $this->load->model('subtypes_model');
    }

    public function type($type_id)
    {
        if ($this->input->is_ajax_request())
        {
            $subtypes = $this->subtypes_model->belong_to_type($type_id);
            $data = array();
            if (!is_null($subtypes))
            {
                $data['status'] = TRUE;
                $data['data'] = $subtypes;
            }
            else
            {
                $data['status'] = FALSE;
            }
            echo json_encode($data);
        }
    }
}
