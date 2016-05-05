<?php
require_once(APPPATH.'controllers/client/Base_Controller.php');

class History extends Base_Controller {
    private $limit = 10;
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('client/cart', session_site_lang());
    }

    public function index()
    {
        $this->load->model('products_model');
        $user_id = session_logged_in()['user_id'];
        $products = $this->products_model->buy_from_user($this->limit, $user_id);
        $total_rows = $this->products_model->count_buy_from_user($user_id);
        $this->load->helper('pagination');
        $page_links = pagination($total_rows, $this->limit, base_url('client/history'));
        load_client_views('cart/history', compact('products', 'page_links'));
    }

    public function get_last_location($locations)
    {
        if (!is_null($locations)) return end($locations);
    }
}