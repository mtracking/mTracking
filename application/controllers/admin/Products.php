<?php
require_once(APPPATH.'controllers/admin/Base_Controller.php');

class Products extends Base_Controller {

    private $limit = 30;
    private $fake_ip = "203.119.44.0";
    private $api_url = "http://ip-api.com/json/";

    public function __construct()
    {
        parent::__construct();
        $this->lang->load('products', session_site_lang());
    }

    public function index()
    {
        $this->load->model(array('products_model', 'batches_model', 'categories_model', 'types_model', 'subtypes_model'));
        $serial_no_of_product = $this->input->get('search', TRUE);
        $batch_of_products = $this->input->get('storage', TRUE);
        $category_of_products = $this->input->get('category', TRUE);
        $type_of_products = $this->input->get('type', TRUE);
        $subtype_of_products = $this->input->get('subtype', TRUE);
        $batch_of_products = $this->input->get('batch', TRUE);
        $data = array();
        $data['batch_id'] = $batch_of_products;
        $data['category_id'] = $category_of_products;
        $data['type_id'] = $type_of_products;
        $data['subtype_id'] = $subtype_of_products;
        $data['serial_no'] = $serial_no_of_product;
        $products = $this->products_model->all($this->limit, $data);

        $total_rows = $this->products_model->count($data);
        $this->load->helper('pagination');
        $page_links = pagination($total_rows, $this->limit, base_url('admin/products'));
        $batches = $this->batches_model->all();
        $categories = $this->categories_model->get_all_categories();
        $types = $this->types_model->all();
        $subtypes = $this->subtypes_model->all();
        load_main_views('products/index', compact('batches', 'categories', 'types', 'subtypes', 'products', 'page_links'));
    }

    public function details($serial_no)
    {
        $this->load->model('products_model','products');
        $product = $this->products->find($serial_no);
        /*temporary*/
        if (!is_null($product))
        {
            $product->picture_url = base_url(LINK_TO_GET_TYPES_IMAGE.(!empty($product->image_file_name) ? $product->image_file_name: DEFAULT_IMAGE));
            $product->qrcode1 = base_url(LINK_TO_GET_QRCODE . $product->serial_no . FILENAME_QRCODE1);
            $product->qrcode2 = base_url(LINK_TO_GET_QRCODE . $product->serial_no . FILENAME_QRCODE2);
            if ($product->status_product_id == PRODUCT_OPENED_STATUS)
            {
                $product->last_location = $this->get_last_location(json_decode($product->location));
            }
            load_main_views('products/details', compact('product'));
        }
        else show_404();
    }

    public function get_last_location($locations)
    {
        if (!is_null($locations)) return end($locations);
    }

}