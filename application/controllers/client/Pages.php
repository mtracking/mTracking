<?php
require_once(APPPATH.'controllers/client/Base_Controller.php');

class Pages extends Base_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->lang->load('client/page', session_site_lang());
    }

    public function detail($id)
    {
        if ($id == PREVIEW)
        {
            $page = $this->session->userdata('page_preview');
        }
        else
        {
            $this->load->model('pages_model');
            $page = $this->pages_model->find($id);
            if ($page)
            {
                $title = $page->title;
                $this->pages_model->increment_view($id);
                $this->session->unset_userdata('page_preview');
            }
            else show_404();
        }
        load_client_views('pages/detail', compact('page', 'title'));
    }
}