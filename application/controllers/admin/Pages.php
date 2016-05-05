<?php
require_once(APPPATH.'controllers/admin/Base_Controller.php');

class Pages extends Base_Controller {
    private $limit = 10;
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('pages', session_site_lang());
    }

    public function index()
    {
        $this->load->model('pages_model');
        $search_page = $this->input->get('search', TRUE);
        $pages = $this->pages_model->all($this->limit, $search_page, ACTIVE);
        $total_rows = $this->pages_model->count($search_page, ACTIVE);
        $this->load->helper('pagination');
        $page_links = pagination($total_rows, $this->limit, base_url('admin/pages'));
        load_main_views('pages/index', array('pages' => $pages, 'page_links' => $page_links));
    }

    public function add()
    {
        load_main_views('pages/page', NULL);
    }

    public function edit($id)
    {
        $this->load->model('pages_model');
        $page = $this->pages_model->find($id);
        load_main_views('pages/page', compact('page'));
    }

    public function preview()
    {
        $title = $this->input->post('title', TRUE);
        $content = $this->input->post('content');
        $page = new stdClass();
        $page->title = $title;
        $page->content = $content;
        $this->session->set_userdata('page_preview', $page);
        echo json_encode(base_url('client/pages/detail/preview'));
    }

    public function form_validation_rules()
    {
        $this->config->set_item('language', session_site_lang());
        $this->load->helper('security');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('page_title', 'lang:page_title', 'trim|required|xss_clean');
        $this->form_validation->set_rules('content', 'lang:content', 'trim|required');
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
                if ($this->update_page())
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
                if ($this->update_page($id))
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

    public function update_page($id = NULL)
    {
        $page_data = array(
            'title' => $this->input->post('page_title'),
            'content' => $this->input->post('content'),
            'is_active' => ACTIVE
            );
        if (!is_null($id)) $page_data['id'] = $id;
        else
        {
            $page_data['is_available'] = ACTIVE;
            $page_data['user_id'] = session_logged_in()['user_id'];
        }
        $this->load->model('pages_model');
        return (is_null($id)) ? $this->pages_model->insert($page_data) : $this->pages_model->update($page_data);
    }

    public function update_status($id)
    {
        $response_data = array();
        if ($this->input->is_ajax_request())
        {
            $this->load->model('pages_model');
            $is_active = $this->input->get('is_active', TRUE);
            $is_available = $this->input->get('is_available', TRUE);
            if (is_null($is_available))
            {
                $page_data = array('id' => $id, 'is_active'=> $is_active);
            }
            else if (is_null($is_active))
            {
                $page_data = array('id' => $id, 'is_available'=> $is_available);
            }
            else $page_data = array();
            $result = $this->pages_model->update($page_data);
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

    public function update_status_mutilple()
    {
        $response_data = array();
        if ($this->input->is_ajax_request())
        {
            $this->load->model('pages_model');
            $page_ids = $this->input->post('page_ids', TRUE);
            $update_status = $this->input->post('update_status', TRUE);
            switch ($update_status)
            {
                case DRAFT:
                    $page_data = array('is_available'=> $update_status);
                    $response_data['is_draft'] = TRUE;
                    break;
                case PUBLISHED:
                    $page_data = array('is_available'=> $update_status);
                    $response_data['is_published'] = TRUE;
                    break;
                case REMOVE:
                    $page_data = array('is_active'=> NOT_ACTIVE);
                    $response_data['is_remove'] = TRUE;
                    break;
            }
            $result = $this->pages_model->update_multi_pages_with_same_data($page_ids, $page_data);
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

    public function delete($id)
    {
        $response_data = array();
        if ($this->input->is_ajax_request())
        {
            $this->load->model('pages_model');
            $result = $this->pages_model->delete($id);
            if ($result)
            {
                $response_data['status'] = TRUE;
            }
            else
            {
                $response_data['status'] = FALSE;
            }
        }
        echo json_encode($response_data);
    }

}
?>