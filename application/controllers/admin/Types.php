<?php
require_once(APPPATH.'controllers/admin/Base_Controller.php');

class Types extends Base_Controller {

    private $limit = 12;
    private $images = array();
    private $model = 'types_model';
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('language');
        $this->load->helper('views');
        check_language();
        $this->lang->load('types', session_site_lang());
    }

    public function index()
    {
        $this->load->model('types_model');
        $search_type = $this->input->get('search', TRUE);
        $types = $this->types_model->all($this->limit, $search_type);
        $total_rows = $this->types_model->count($search_type);
        $this->load->helper('pagination');
        $page_links = pagination($total_rows, $this->limit, base_url('admin/types'));
        load_main_views('types/index', array('types' => $types, 'page_links' => $page_links));
    }

    public function add()
    {
        $this->load->model('categories_model', 'categories');
        $categories = $this->categories->get_all_categories();
        load_main_views('types/type', compact('categories'));
    }

    public function edit($id)
    {
        $this->load->model('types_model');
        $type = $this->types_model->find($id);
        $pictures = $this->types_model->pictures($id);
        $this->load->model('categories_model', 'categories');
        $categories = $this->categories->get_all_categories();
        load_main_views('types/type', compact('type', 'categories', 'pictures'));
    }

    public function form_validation_rules()
    {
        $this->config->set_item('language', session_site_lang());
        $this->load->helper('security');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'lang:name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('sourcing', 'lang:sourcing', 'trim|required|xss_clean');
        $this->form_validation->set_rules('type_details', 'lang:type_details', 'trim|required|xss_clean');
        $this->form_validation->set_rules('characteristics', 'lang:characteristics', 'trim|required|xss_clean');
        $this->form_validation->set_rules('country', 'lang:country', 'trim|required|xss_clean');
        // $this->form_validation->set_rules('price', 'lang:price', 'trim|required|callback_decimal_numeric|xss_clean');
        $this->form_validation->set_rules('storage_temp', 'lang:storage_temp', 'trim|required|xss_clean');
        $this->form_validation->set_rules('category', 'lang:category', 'trim|required|xss_clean');
    }

    public function decimal_numeric($price)
    {
        if (is_numeric($price) OR is_float($price))
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('decimal_numeric', $this->lang->line('decimal_numeric'));
            return FALSE;
        }
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
                if ($this->update_type())
                {
                    $data['status'] = TRUE;
                    $data['messages'] = $this->lang->line('create_success');
                }
                else
                {
                    $this->remove_images($this->session->userdata('image_upload'));
                    $data['status'] = FALSE;
                    $data['messages'] = $this->lang->line('create_failure');
                }
            }
            echo json_encode($data);
        }
    }

    public function update($id)
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
                if ($this->update_type($id))
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

    public function update_type($id = NULL)
    {
        $type_data = array(
            'name' => $this->input->post('name'),
            'sourcing' => $this->input->post('sourcing'),
            'characteristics' => $this->input->post('characteristics'),
            'type_details' => $this->input->post('type_details'),
            'country' => $this->input->post('country'),
            'storage_temp' => $this->input->post('storage_temp'),
            'category_id' => $this->input->post('category'),
            'is_active' => ACTIVE
            );
        $pictures_data = $this->session->userdata('image_upload');
        if (!is_null($id)) $type_data['id'] = $id;
        else $type_data['is_available'] = ACTIVE;
        $this->load->model('types_model');
        return (is_null($id)) ? $this->types_model->insert($type_data, $pictures_data) : $this->types_model->update($type_data, $pictures_data);
    }

    public function update_status($id)
    {
        $response_data = array();
        if ($this->input->is_ajax_request())
        {
            $is_active = $this->input->get('is_active', TRUE);
            $this->load->model('types_model');
            $type_data = array('id' => $id, 'is_active'=> $is_active);
            $result = $this->types_model->update($type_data);
            if ($result)
            {
                $response_data['status'] = TRUE;
                $response_data['messages'] = $this->lang->line('update_success_msg');
            }
            else
            {
                $response_data['status'] = FALSE;
                $response_data['messages'] = $this->lang->line('update_failed_msg');
            }
        }
        echo json_encode($response_data);
    }

    public function upload()
    {
        $this->load->library('gallery');
        list($result, $image_data) = $this->gallery->image_upload(LINK_TO_SAVE_TYPES_IMAGE);
        if ($image_data['file_name'])
        {
            $this->add_file_name_images_upload_in_session($image_data['file_name']);
        }
    }

    public function remove_images($images)
    {
        $this->load->library('gallery');
        if (!is_null($images))
        {
            foreach ($images as $image) {
                $this->gallery->image_delete(LINK_TO_SAVE_TYPES_IMAGE.$image);
            }
        }
    }

    public function add_file_name_images_upload_in_session($image_file_name)
    {
        if ($this->session->has_userdata('image_upload'))
        {
            $images = $this->session->userdata('image_upload');
            $images[] = $image_file_name;
        }
        else
        {
            $images = array();
            $images[] = $image_file_name;
        }
        $this->session->set_userdata('image_upload', $images);
    }

}
