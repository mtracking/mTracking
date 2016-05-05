<?php
require_once(APPPATH.'controllers/admin/Base_Controller.php');

class Trash extends Base_Controller {
    private $limit = 20;
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('trash', session_site_lang());
    }

    public function index()
    {
        $kind_of_items = $this->input->get('sort_by', TRUE);
        if (is_null($kind_of_items)) $kind_of_items = CATEGORIES;
        $items = array();
        $search_item = NULL;
        $search_item = $this->input->get('search_item', TRUE);
        switch ($kind_of_items)
        {
            case CATEGORIES:
                $this->load->model('categories_model');
                $items = $this->categories_model->get_all_categories($search_item, NOT_ACTIVE);
                $total_rows = $this->categories_model->count($search_item, NOT_ACTIVE);
                break;
            case TYPES:
                $this->load->model('types_model');
                $items = $this->types_model->all($this->limit, $search_item, NOT_ACTIVE);
                $total_rows = $this->types_model->count($search_item, NOT_ACTIVE);
                break;
            case SUBTYPES:
                $this->load->model('subtypes_model');
                $items = $this->subtypes_model->all($this->limit, $search_item, NOT_ACTIVE);
                $total_rows = $this->subtypes_model->count($search_item, NOT_ACTIVE);
                break;
            case BATCHES:
                $this->load->model('batches_model');
                $items = $this->batches_model->all($this->limit, $search_item, NOT_ACTIVE);
                $total_rows = $this->batches_model->count($search_item, NOT_ACTIVE);
                break;
            case PAGES:
                $this->load->model('pages_model');
                $items = $this->pages_model->all($this->limit, $search_item, NOT_ACTIVE);
                $total_rows = $this->pages_model->count($search_item, NOT_ACTIVE);
                break;
            case POSTS:
                $this->load->model('posts_model');
                $items = $this->posts_model->all($this->limit, $search_item, NOT_ACTIVE);
                $total_rows = $this->posts_model->count($search_item, NOT_ACTIVE);
                break;
            default:
                $this->load->model('categories_model');
                $items = $this->categories_model->get_all_categories(NOT_ACTIVE);
                $total_rows = $this->categories_model->count(NOT_ACTIVE);
                break;
        }
        $this->load->helper('pagination');
        $page_links = pagination($total_rows, $this->limit, base_url('admin/trash'));
        load_main_views('trash/index', compact('items', 'kind_of_items', 'page_links'));
    }
}