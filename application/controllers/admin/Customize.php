<?php
require_once(APPPATH.'controllers/admin/Base_Controller.php');

class Customize extends Base_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->lang->load('customize', session_site_lang());
        $this->load->model('customize_model');
    }

    public function index()
    {
        $customize = $this->customize_model->get();
        load_main_views('customize/index', compact('customize'));
    }

    public function form_validation_rules()
    {
        $this->config->set_item('language', session_site_lang());
        $this->load->helper('security');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('site_title', 'lang:site_title', 'trim|required|xss_clean');
        $this->form_validation->set_rules('footer', 'lang:footer', 'trim|required');
    }

    public function store()
    {
        if ($this->input->is_ajax_request())
        {
            $this->form_validation_rules();
            if ($this->form_validation->run() == FALSE)
            {
                $data['status'] = FALSE;
                $data['messages'] = validation_errors();
            }
            else
            {
                if ($this->update_site())
                {
                    $data['status'] = TRUE;
                    $data['messages'] = $this->lang->line('create_success');
                }
                else
                {
                    $data['status'] = FALSE;
                    $data['messages'] = $this->lang->line('create_failure');
                }
            }
            echo json_encode($data);
        }
    }

    public function update()
    {
        if ($this->input->is_ajax_request())
        {
            $this->form_validation_rules();
            if ($this->form_validation->run() == FALSE)
            {
                $data['status'] = FALSE;
                $data['messages'] = validation_errors();
            }
            else
            {
                if ($this->update_site())
                {
                    $data['status'] = TRUE;
                    $data['messages'] = $this->lang->line('update_success');
                }
                else
                {
                    $data['status'] = FALSE;
                    $data['messages'] = $this->lang->line('update_failure');
                }
            }
            echo json_encode($data);
        }
    }

    public function update_site()
    {
        $site_data = array(
            'site_title' => $this->input->post('site_title'),
            'footer' => $this->input->post('footer'),
            );
        $this->load->model('customize_model');
        return $this->customize_model->update($site_data);
    }

    public function upload_header()
    {
        $data = array(
            'status' => FALSE,
            'messages' => $this->lang->line('update_failure'));
        if ($this->input->is_ajax_request())
        {
            $this->load->library('gallery');
            list($result, $image_data) = $this->gallery->image_upload(LINK_TO_SAVE_TEMPLATE_IMAGE);
            if ($result)
            {
                $this->load->model('customize_model');
                $customize = $this->customize_model->get();
                $old_image_file_name = (!is_null($customize) && !is_null($customize->background_file_name)) ? $customize->background_file_name : NULL;
                $customize_data = array('background_file_name' => $image_data['file_name']);
                if ($this->customize_model->update($customize_data))
                {
                    if (!is_null($old_image_file_name)) $this->gallery->image_delete(LINK_TO_SAVE_TEMPLATE_IMAGE. $old_image_file_name);
                    $data['status'] = TRUE;
                    $data['messages'] = $this->lang->line('update_profile_success');
                    $data['data'] = base_url(LINK_TO_GET_TEMPLATE_IMAGE. $image_data['file_name']);
                }
            }
        }
        echo json_encode($data);
    }
}