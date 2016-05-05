<?php
require_once(APPPATH.'controllers/client/Base_Controller.php');

class Store extends Base_Controller {

    private $limit = 12;

    public function __construct()
    {
        parent::__construct();
        $this->lang->load('client/store', session_site_lang());
    }

    public function index()
    {
        $this->load->model(array('types_model', 'shopping_cart_model', 'products_model'));
        $user_id = session_logged_in()['user_id'];
        $session_carts = $this->session->userdata('carts');
        $carts = $this->shopping_cart_model->get_carts_of_user($user_id);
        $number_of_shopping_cart = (!is_null($user_id)) ? $this->count_quantity_of_carts($carts) : $this->count_quantity_of_carts($session_carts);
        $search_type = $this->input->get('search_type', TRUE);
        $types = $this->types_model->get_types_available($this->limit, $search_type);
        $total_rows = $this->types_model->count_types_available($search_type);
        $this->load->helper('pagination');
        $page_links = pagination($total_rows, $this->limit, base_url('client/store'));
        load_client_views('products/store', compact('number_of_shopping_cart', 'types', 'page_links'));
    }

    public function count_quantity_of_carts($carts)
    {
        $total_quantity = 0;
        if (!is_null($carts))
        {
            foreach ($carts as $key => $cart)
            {
                if (!is_array($cart)) $cart = (array)$cart;
                $total_quantity += $cart['quantity'];
            }
        }
        return $total_quantity;
    }

}