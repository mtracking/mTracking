<?php
require_once(APPPATH.'controllers/client/Base_Controller.php');

class Orders extends Base_Controller {
    private $limit = 3;
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('client/orders', session_site_lang());
    }

    public function insert_order()
    {
        $order_data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'phone_number' => $this->input->post('phone_number'),
            'address' => $this->input->post('address'),
            'postal_code' => $this->input->post('postal_code'),
            'content' => $this->input->post('content'),
            'total_money' => $this->input->post('total_money'),
            'status_order' => ORDER);
        $this->load->model('orders_model');
        return $this->orders_model->insert($order_data);
    }

    public function index()
    {
        $status_order = $this->input->get('sort_by', TRUE);
        if (is_null($status_order)) $status_order = ORDER;
        $this->load->model('orders_model');
        $email = session_logged_in()['email'];
        $orders = $this->orders_model->get_orders_of_customer($this->limit, $email, $status_order);
        $total_sort_by_order = $this->orders_model->count_orders_of_customer($email, ORDER);
        $total_sort_by_processing = $this->orders_model->count_orders_of_customer($email, PROCESSING);
        $total_sort_by_delivered = $this->orders_model->count_orders_of_customer($email, DELIVERED);
        if ($status_order == ORDER) $total_rows = $total_sort_by_order;
        elseif ($status_order == DELIVERED) $total_rows = $total_sort_by_delivered;
        elseif ($status_order == PROCESSING) $total_rows = $total_sort_by_processing;
        $this->load->helper('pagination');
        $page_links = pagination($total_rows, $this->limit, base_url('client/orders'));
        load_client_views('orders/index', compact('orders', 'page_links', 'status_order', 'total_sort_by_order', 'total_sort_by_delivered', 'total_sort_by_processing'));
    }

    public function delete($id)
   {
        $data = array();
        $data['status'] = FALSE;
        $data['messages'] = $this->lang->line('delete_failure');
        if ($this->input->is_ajax_request())
        {
            $this->load->model('orders_model');
            $result = $this->orders_model->delete($id, CUSTOMER);
            if ($result)
            {
                $data['status'] = TRUE;
                $data['messages'] = 'OK';
            }
        }
        echo json_encode($data);
   }

    public function store()
    {
        if ($this->input->is_ajax_request())
        {
            $this->form_validation_rules();
            if ($this->form_validation->run() == FALSE)
            {
                $data['status'] = FALSE;
                foreach ($_POST as $key => $value)
                {
                    $data['messages'][$key] = form_error($key);
                }
            }
            else
            {
                if ($this->insert_order())
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

    public function form_validation_rules()
    {
        $this->config->set_item('language', session_site_lang());
        $this->load->helper('security');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'lang:name', 'trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('email', 'lang:email', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('phone_number', 'lang:phone_number', 'trim|required|min_length[8]|xss_clean');
        $this->form_validation->set_rules('address', 'lang:address', 'trim|required|xss_clean');
        $this->form_validation->set_rules('postal_code', 'lang:postal_code', 'trim|required|numeric|xss_clean');
        $this->form_validation->set_rules('content', 'lang:content', 'trim|required|xss_clean');
        $this->form_validation->set_error_delimiters("<div class='text-danger'>", '</div>');
    }
}
