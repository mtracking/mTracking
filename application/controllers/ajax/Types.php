<?php
require_once(APPPATH.'controllers/ajax/Ajax_Controller.php');

class Types extends Ajax_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->lang->load('types', session_site_lang());
        $this->load->model('types_model');
    }

    public function get($id)
    {
        if ($this->input->is_ajax_request())
        {
            $type = $this->types_model->find($id);
            if (!is_null($type) && !empty($type->image_file_name))
            {
                $type->image_url = base_url(LINK_TO_GET_TYPES_IMAGE. $type->image_file_name);
            }
            else $type->image_url = base_url(LINK_TO_GET_TYPES_IMAGE. DEFAULT_IMAGE);
            $data = array();
            if (!is_null($type))
            {
                $data['status'] = TRUE;
                $data['data'] = $type;
            }
            else
            {
                $data['status'] = FALSE;
            }
            echo json_encode($data);
        }
    }

    public function category($category_id)
    {
        if ($this->input->is_ajax_request())
        {
            $types = $this->types_model->belong_to_category(NULL, $category_id);
            $data = array();
            if (!is_null($types))
            {
                $data['status'] = TRUE;
                $data['data'] = $types;
            }
            else
            {
                $data['status'] = FALSE;
            }
            echo json_encode($data);
        }
    }
}
