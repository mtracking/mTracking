<?php
require_once(APPPATH.'controllers/admin/Base_Controller.php');

class Orders extends Base_Controller {
    private $limit = 5;
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('orders', session_site_lang());
    }

    public function index()
    {
        $status_order = $this->input->get('sort_by', TRUE);
        if (is_null($status_order)) $status_order = ORDER;
        $this->load->model('orders_model');
        $email = $this->input->get('search_email');
        $orders = $this->orders_model->all($this->limit, $email, $status_order);
        $total_sort_by_order = $this->orders_model->count($email, ORDER);
        $total_sort_by_processing = $this->orders_model->count($email, PROCESSING);
        $total_sort_by_delivered = $this->orders_model->count($email, DELIVERED);
        if ($status_order == ORDER) $total_rows = $total_sort_by_order;
        elseif ($status_order == DELIVERED) $total_rows = $total_sort_by_delivered;
        elseif ($status_order == PROCESSING) $total_rows = $total_sort_by_processing;
        $this->load->helper('pagination');
        $page_links = pagination($total_rows, $this->limit, base_url('admin/orders'));
        load_main_views('orders/index', compact('orders', 'page_links', 'status_order', 'total_sort_by_order', 'total_sort_by_delivered', 'total_sort_by_processing'));
    }

   public function change_status_order($id)
   {
        $data = array();
        $data['status'] = FALSE;
        $data['messages'] = 'ERROR';
        if ($this->input->is_ajax_request())
        {
            $status_order = $this->input->post('status_order', TRUE);
            $this->load->model('orders_model');
            $result = $this->orders_model->change_status($id, $status_order);
            if ($result)
            {
                $data['status'] = TRUE;
                $data['messages'] = 'OK';
            }
        }
        echo json_encode($data);
   }

   public function delete($id)
   {
        $data = array();
        $data['status'] = FALSE;
        $data['messages'] = 'ERROR';
        if ($this->input->is_ajax_request())
        {
            $this->load->model('orders_model');
            $result = $this->orders_model->delete($id);
            if ($result)
            {
                $data['status'] = TRUE;
                $data['messages'] = 'OK';
            }
        }
        echo json_encode($data);
   }
}
