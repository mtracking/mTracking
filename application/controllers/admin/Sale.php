<?php
require_once(APPPATH.'controllers/admin/Base_Controller.php');

class Sale extends Base_Controller {

    private $limit = 12;
    private $images = array();
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('language');
        $this->load->helper('views');
        check_language();
        $this->lang->load('sale', session_site_lang());
    }

    public function index()
    {
        $this->load->model('types_model','types');
        $search_type_label = $this->input->get('search', TRUE);
        $types = $this->types->all($this->limit, $search_type_label);
        $total_rows = $this->types->count($search_type_label);
        $this->load->helper('pagination');
        $page_links = pagination($total_rows, $this->limit, base_url('admin/sale'));
        load_main_views('types/sale', array('types' => $types, 'page_links' => $page_links));
    }

    public function update_type_price($id)
    {
        $data = array();
        $data['status'] = FALSE;
        $data['messages'] = 'ERROR';
        if ($this->input->is_ajax_request())
        {
            $price = $this->input->post('price');
            $this->load->model('types_model');
            $type_data = array(
                'id' => $id,
                'price' => $price);
            $result = $this->types_model->update($type_data);
            if ($result)
            {
                $data['status'] = TRUE;
                $data['messages'] = 'OK';
            }
        }
        echo json_encode($data);
    }

    public function update_type_available($id)
    {
        $data = array();
        $data['status'] = FALSE;
        $data['messages'] = 'ERROR';
        if ($this->input->is_ajax_request())
        {
            $is_available = $this->input->post('is_available');
            $this->load->model('types_model');
            $type_data = array(
                'id' => $id,
                'is_available' => $is_available);
            $result = $this->types_model->update($type_data);
            if ($result)
            {
                $data['status'] = TRUE;
                $data['messages'] = 'OK';
            }
        }
        echo json_encode($data);
    }

    public function upload_pictures($id)
    {
        $data = array(
            'status' => FALSE,
            'messages' => $this->lang->line('update_failure'));
        if ($this->input->is_ajax_request())
        {
            $this->load->library('gallery');
            list($result, $image_data) = $this->gallery->image_upload(LINK_TO_SAVE_TYPES_IMAGE);
            if ($result)
            {
                $this->load->model('types_model');
                $old_pictures = $this->types_model->pictures($id);
                foreach ($old_pictures as $key => $old_picture)
                {
                    $this->gallery->image_delete(LINK_TO_SAVE_TYPES_IMAGE. $old_picture->image_file_name);
                }
                $update_user_data = array(
                    'image_file_name' => $image_data['file_name']);
                if ($this->types_model->update_pictures($id, $update_user_data))
                {
                    $data['status'] = TRUE;
                    $data['messages'] = $this->lang->line('update_profile_success');
                    $data['data'] = base_url(LINK_TO_GET_TYPES_IMAGE. $image_data['file_name']);
                }
            }
        }
        echo json_encode($data);
    }

}
