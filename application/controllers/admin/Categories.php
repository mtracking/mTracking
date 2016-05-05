<?php
require_once(APPPATH.'controllers/admin/Base_Controller.php');

class Categories extends Base_Controller
{
    // private $categories_model = 'categories_model';
    private $add_form_url = '';
    private $update_form_url = '';
    private $category_view_form_url = '';
    private $category_all_view = '';

    public function __construct()
    {
        parent::__construct();
        $this->init();
        if (!session_site_lang())
        {
            set_session_site_lang('english');
        }
        $this->lang->load("categories_lang",session_site_lang());
    }

    private function init()
    {
        $this->load->helper('views');
        $this->config->set_item('language', session_site_lang());
        $this->load->library('form_validation');
        $this->add_form_url = base_url('admin/categories/store');
        $this->update_form_url = base_url('admin/categories/update');
        $this->category_view_form_url = 'admin/categories/categories';
        $this->categories_all_view = 'admin/categories/all_categories';
        $this->load->model('categories_model');
    }

    public function index()
    {
        $list_categories = $this->categories_model->get_all_categories();

        load_main_views('categories/all_categories', ['categories' => $list_categories,]);
    }

    public function add()
    {
        $data =
        [
            'url' => $this->add_form_url,
            'label' => $this->lang->line('txt_add_btn'),
        ];
        load_main_views('categories/categories', array('data' => $data));
    }

    public function store()
    {
        if ($this->input->is_ajax_request())
        {
            $check_validation = $this->category_form_validation();
            $response_data['status'] = FALSE;
            $response_data['messages'] = $this->lang->line('update_failed_msg');
            if ($check_validation)
            {
                $category = $this->update_category();
                if ($category != NULL) {
                    $response_data['status'] = TRUE;
                    $response_data['messages'] = $this->lang->line('update_success_msg');
                }
            } else
            {
                $response_data['messages'] = validation_errors();
            }
            echo json_encode($response_data);
        }
    }

    public function update($id)
    {
        if ($this->input->is_ajax_request())
        {
            $check_validation = $this->category_form_validation();
            $response_data['status'] = FALSE;
            $response_data['messages'] = $this->lang->line('update_failed_msg');
            if ($check_validation)
            {
                $category = $this->update_category($id);
                if ($category != NULL) {
                    $response_data['status'] = TRUE;
                    $response_data['messages'] = $this->lang->line('update_success_msg');
                }
            } else
            {
                $response_data['messages'] = validation_errors();
            }
            echo json_encode($response_data);
        }
    }

    public function edit($id)
    {
        $category = $this->categories_model->get_category_by_id($id);
        if ($category)
        {
            $data =
            [
                'url' => $this->update_form_url.'/'.$id,
                'category' => $category,
                'label' => $this->lang->line('txt_update_btn'),
            ];
            load_main_views('categories/categories', array('data' => $data));
        } else
        {
            show_error('page not found', ['status_code' => 404 ]);
        }
    }

    public function update_status($id)
    {
        $response_data = array();
        if ($this->input->is_ajax_request())
        {
            $is_active = $this->input->get('is_active', TRUE);
            $category_data = array('id' => $id, 'is_active'=> $is_active);
            $result = $this->categories_model->update_category( $category_data);
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

    private function update_category($id = NULL)
    {
        $category['name'] = $this->input->post('name');
        $category['is_active'] = ACTIVE;
        if ($id == NULL) {
            return $this->categories_model->insert_new_category($category);
        } else
        {
            $category['id'] = $id;
            return $this->categories_model->update_category($category);
        }
    }


    private function  category_form_validation()
    {
        $this->form_validation->set_rules('name', 'lang:txt_add_cate_name', 'trim|required|min_length[3]|max_length[255]|xss_clean');
        // $this->form_validation->set_rules('wine_details', 'lang:txt_add_cate_desc', 'trim|required|min_length[3]');

        return $this->form_validation->run();
    }
}