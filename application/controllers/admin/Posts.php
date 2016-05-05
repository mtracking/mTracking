<?php
require_once(APPPATH.'controllers/admin/Base_Controller.php');

class Posts extends Base_Controller {
    private $limit = 10;
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('posts', session_site_lang());
    }

    public function index()
    {
        $this->load->model('posts_model');
        $search_post = $this->input->get('search', TRUE);
        $posts = $this->posts_model->all($this->limit, $search_post, ACTIVE);
        $total_rows = $this->posts_model->count($search_post, ACTIVE);
        $this->load->helper('pagination');
        $page_links = pagination($total_rows, $this->limit, base_url('admin/posts'));
        load_main_views('posts/index', array('posts' => $posts, 'page_links' => $page_links));
    }

    public function add()
    {
        $this->load->model('categories_model');
        $categories = $this->categories_model->get_all_categories();
        $types = array();
        if (!is_null($categories))
        {
            $this->load->model('types_model');
            $types = $this->types_model->belong_to_category(0, $categories[0]->id);
        }
        load_main_views('posts/post', compact('categories', 'types'));
    }

    public function edit($id)
    {
        $this->load->model('posts_model');
        $post = $this->posts_model->find($id);
        $categories = array();
        $types = array();
        if (!empty($post))
        {
            $this->load->model('categories_model');
            $categories = $this->categories_model->get_all_categories();
            if (!empty($categories))
            {
                $this->load->model('types_model');
                $types = $this->types_model->belong_to_category(0, $post->category_id);
            }
        }
        load_main_views('posts/post', compact('post', 'categories', 'types'));
    }

    public function preview()
    {
        $title = $this->input->post('title', TRUE);
        $content = $this->input->post('content');
        $post = new stdClass();
        $post->title = $title;
        $post->content = $content;
        $this->session->set_userdata('post_preview', $post);
        echo json_encode(base_url('client/posts/detail/preview'));
    }

    public function form_validation_rules()
    {
        $this->config->set_item('language', session_site_lang());
        $this->load->helper('security');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('post_title', 'lang:post_title', 'trim|required|xss_clean');
        $this->form_validation->set_rules('content', 'lang:content', 'trim|required');
        $this->form_validation->set_rules('type', 'lang:type', 'trim|numeric|required|xss_clean');
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
                if ($this->update_post())
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
                if ($this->update_post($id))
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

    public function update_post($id = NULL)
    {
        $post_data = array(
            'title' => $this->input->post('post_title'),
            'content' => $this->input->post('content'),
            'type_id' => $this->input->post('type'),
            'is_active' => ACTIVE
            );
        if (!is_null($id)) $post_data['id'] = $id;
        else
        {
            $post_data['is_available'] = ACTIVE;
            $post_data['user_id'] = session_logged_in()['user_id'];
        }
        $this->load->model('posts_model');
        return (is_null($id)) ? $this->posts_model->insert($post_data) : $this->posts_model->update($post_data);
    }

    public function update_status($id)
    {
        $response_data = array();
        if ($this->input->is_ajax_request())
        {
            $this->load->model('posts_model');
            $is_active = $this->input->get('is_active', TRUE);
            $is_available = $this->input->get('is_available', TRUE);
            if (is_null($is_available))
            {
                $post_data = array('id' => $id, 'is_active'=> $is_active);
            }
            else if (is_null($is_active))
            {
                $post_data = array('id' => $id, 'is_available'=> $is_available);
            }
            else $post_data = array();
            $result = $this->posts_model->update($post_data);
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
            $this->load->model('posts_model');
            $post_ids = $this->input->post('post_ids', TRUE);
            $update_status = $this->input->post('update_status', TRUE);
            switch ($update_status)
            {
                case DRAFT:
                    $post_data = array('is_available'=> $update_status);
                    $response_data['is_draft'] = TRUE;
                    break;
                case PUBLISHED:
                    $post_data = array('is_available'=> $update_status);
                    $response_data['is_published'] = TRUE;
                    break;
                case REMOVE:
                    $post_data = array('is_active'=> NOT_ACTIVE);
                    $response_data['is_remove'] = TRUE;
                    break;
            }
            $result = $this->posts_model->update_multi_posts_with_same_data($post_ids, $post_data);
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
            $this->load->model('posts_model');
            $result = $this->posts_model->delete($id);
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