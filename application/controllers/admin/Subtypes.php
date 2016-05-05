<?php
require_once(APPPATH.'controllers/admin/Base_Controller.php');

class Subtypes extends Base_Controller {

    private $limit = 12;
    private $images = array();
    private $model = 'types_model';
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('language');
        $this->load->helper('views');
        check_language();
        $this->lang->load('subtypes', session_site_lang());
    }

    public function index()
    {
        $this->load->model('subtypes_model');
        $search_subtype = $this->input->get('search', TRUE);
        $subtypes = $this->subtypes_model->all($this->limit, $search_subtype);
        $total_rows = $this->subtypes_model->count($search_subtype);
        $this->load->helper('pagination');
        $page_links = pagination($total_rows, $this->limit, base_url('admin/subtypes'));
        load_main_views('subtypes/index', array('subtypes' => $subtypes, 'page_links' => $page_links));
    }

    public function add()
    {
        $this->load->model('categories_model');
        $categories = $this->categories_model->get_all_categories();
        $types = array();
        if (!empty($categories))
        {
            $this->load->model('types_model');
            $types = $this->types_model->belong_to_category(0, $categories[0]->id);
        }
        load_main_views('subtypes/subtype', compact('categories', 'types'));
    }

    public function edit($id)
    {
        $this->load->model('subtypes_model');
        $subtype = $this->subtypes_model->find($id);
        $categories = array();
        $types = array();
        if (!is_null($subtype))
        {
            $this->load->model(array('categories_model', 'types_model'));
            $categories = $this->categories_model->get_all_categories();
            $types = $this->types_model->belong_to_category(0, $subtype->category_id);
        }
        load_main_views('subtypes/subtype', compact('subtype', 'categories', 'types'));
    }

    public function form_validation_rules()
    {
        $this->config->set_item('language', session_site_lang());
        $this->load->helper('security');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('producing_year', 'lang:producing_year', 'trim|required|numeric|xss_clean');
        $this->form_validation->set_rules('type', 'lang:type', 'trim|required|numeric|xss_clean');
        $this->form_validation->set_rules('factory', 'lang:factory', 'trim|required|xss_clean');
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
                if ($this->update_subtype_label())
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
                if ($this->update_subtype_label($id))
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

    public function update_subtype_label($id = NULL)
    {
        $subtype_data = array(
            'type_id' => $this->input->post('type'),
            'producing_year' => $this->input->post('producing_year'),
            'factory' => $this->input->post('factory'),
            'is_active' => ACTIVE
            );
        if (!is_null($id)) $subtype_data['id'] = $id;
        $this->load->model('subtypes_model');
        return (is_null($id)) ? $this->subtypes_model->insert($subtype_data) : $this->subtypes_model->update($subtype_data);
    }

    public function update_status($id)
    {
        $response_data = array();
        if ($this->input->is_ajax_request())
        {
            $is_active = $this->input->get('is_active', TRUE);
            $this->load->model('subtypes_model');
            $subtype_data = array('id' => $id, 'is_active'=> $is_active);
            $result = $this->subtypes_model->update($subtype_data);
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

}
