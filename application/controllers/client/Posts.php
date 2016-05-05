<?php
require_once(APPPATH.'controllers/client/Base_Controller.php');

class Posts extends Base_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->lang->load('client/post', session_site_lang());
    }

    public function detail($id)
    {
        $post = NULL;
        $type = NULL;
        if ($id == PREVIEW)
        {
            $post = $this->session->userdata('post_preview');
        }
        else
        {
            $this->load->model(array('posts_model', 'types_model'));
            $is_type_id = $this->input->get('type', TRUE);
            if (!is_null($is_type_id))
            {
                $post = $this->posts_model->get_post_is_available_from_type_id($id);
                $type = $this->types_model->find($id);
                if (!is_null($post))
                {
                    $title = $post->title;
                    $this->posts_model->increment_view($id, $is_type_id);
                }
                else if (!is_null($post)) $title = $type->name;
            }
            else
            {
                $post = $this->posts_model->find($id);
                $type = $this->types_model->find($post->type_id);
                if (!is_null($post))
                {
                    $title = $post->title;
                    $this->posts_model->increment_view($id);
                }
                else if (!is_null($post)) $title = $type->name;
            }
            if ($type) $type->picture_url = (!empty($type->image_file_name)) ? $type->image_file_name : DEFAULT_IMAGE;
            $this->session->unset_userdata('post_preview');
        }
        if (!is_null($type) OR $id == PREVIEW) load_client_views('posts/detail', compact('post', 'type', 'title'));
        else show_404();
    }
}