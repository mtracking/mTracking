<?php
require_once(APPPATH.'controllers/admin/Base_Controller.php');

class Home extends Base_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->lang->load('home', session_site_lang());
    }

    public function index()
    {
	    $this->load->model(array('categories_model', 'batches_model', 'types_model', 'users_model', 'orders_model', 'products_model'));
	    $number_of_categories = $this->categories_model->count();
	    $number_of_types = $this->types_model->count();
        $number_of_users = $this->users_model->count();
        $number_of_orders = $this->orders_model->count();
        $number_of_batches = $this->batches_model->count();
        $products = $this->products_model->all();
        $number_of_products = count($products);
	    $locations = array();
	    foreach ($products as $key => $product)
	    {
	    	if (!is_null($product->location))
	    	{
	    		$locations_temp = json_decode($product->location);
	    		for($i=0; $i < count($locations_temp); $i++)
	    		{
	    			$location = array('lat' => $locations_temp[$i]->latitude, 'lng' => $locations_temp[$i]->longitude);
	    			if (!in_array($location, $locations)) array_push($locations, $location);
	    		}
	    	}
	    }
	    load_main_views('home', compact(
            'locations',
            'number_of_batches', 'number_of_products',
            'number_of_types', 'number_of_categories',
            'number_of_users', 'number_of_orders'));
    }
}
