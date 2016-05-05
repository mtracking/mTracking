<?php
require_once(APPPATH.'controllers/client/Base_Controller.php');

class Products extends Base_Controller {

    private $fake_ip = "203.119.44.0";
    private $api_url = "http://ip-api.com/json/";
    private $limit = 12;

    public function __construct()
    {
        parent::__construct();
        $this->lang->load(array('client/products'), session_site_lang());
    }

    public function view($serial_no)
    {
        $this->load->model('products_model');
        $product = $this->products_model->find($serial_no);
        if ($product)
        {
            $product->picture_url = (!empty($product->image_file_name)) ? $product->image_file_name : DEFAULT_IMAGE;
            load_client_views('products/detail', compact('product'));
        }
        else show_404();
    }

    public function status($hash_serial_no)
    {
        list($serial_no, $serial_active) = decode_serial_no($hash_serial_no);
        $this->load->model('products_model');
        $product = $this->products_model->confirm_products($serial_no, $serial_active);
        $result = $this->open($serial_no);
        if ($result['status'] == TRUE)
        {
            if (is_customer() OR is_distributor())
            {
                $user_id = session_logged_in()['user_id'];
                if ($this->products_model->update_user($serial_no, $user_id))
                {
                    $result['need_to_login'] = FALSE;
                    $result['messages'] = $this->lang->line('update_location_and_user_success');
                }
                else
                {
                    $result['status_update_user'] = FALSE;
                }
            }
            elseif (is_admin())
            {
                $result['messages'] = $this->lang->line('log_out_of_admin_account');
                $result['need_to_login'] = FALSE;
            }
            else
            {
                $result['need_to_login'] = TRUE;
            }
        }
        load_client_views('products/status', compact('product', 'result'));
    }

    public function current($serial_no)
    {
        $result = $this->update($serial_no);
        echo json_encode($result);
    }

    public function open($serial_no)
    {
        $result = $this->update($serial_no, PRODUCT_OPENED_STATUS);
        return $result;
    }

    private function update($serial_no, $status = NULL)
    {
        $res_mes['status'] = FALSE;
        $res_mes['messages'] = $this->lang->line('update_failed_text');
        $res_mes['need_to_login'] = FALSE;
        $this->load->model('products_model');
        $product = $this->products_model->find($serial_no);
        if ($product && $product->status_product != PRODUCT_OPENED_STATUS)
        {
            $res_json = $this->get_location_data($this->api_url.$this->input->ip_address());
            if ($res_json)
            {
                if ( !(strcmp ($res_json['status'], MAP_API_FAIL) == 0) )
                {
                    $new_location = $this->products_model->update_product_location($serial_no, $res_json, $status);
                    if ($new_location)
                    {
                        $res_mes['status'] = TRUE;
                        $res_mes['messages'] = $this->lang->line('update_success_text');
                    }
                }
                else
                {
                    $res_mes['messages'] = $this->lang->line('ip_invalid');
                }
            }
        }
        elseif ($product && $product->status_product == PRODUCT_OPENED_STATUS)
        {
            $res_mes['messages'] = $this->lang->line('product_opened_text');
            $res_mes['time_opened'] = $this->get_last_location(json_decode($product->location))->time;
        }

        return $res_mes;
    }

    public function update_user()
    {
        $data = array();
        $data['status'] = FALSE;
        $data['messages'] = $this->lang->line('update_user_failure');
        if ($this->input->is_ajax_request())
        {
            if (is_customer())
            {
                $this->load->model('products_model');
                $user_id = session_logged_in()['user_id'];
                $serial_no = $this->input->post('serial_no', TRUE);
                if ($this->products_model->update_user($serial_no, $user_id))
                {
                    $data['status'] = TRUE;
                    $data['messages'] = $this->lang->line('update_user_success');
                }
                else
                {
                    $data['status'] = FALSE;
                }
            }
            else
            {
                $data['status'] = FALSE;
                $data['messages'] = $this->lang->line('log_out_of_admin_account');
            }
        }
        echo json_encode($data);
    }

    private function get_location_data($url)
    {
        $req = curl_init();
        curl_setopt($req, CURLOPT_URL, $url);
        curl_setopt($req, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($req);
        $res_json = json_decode($res, true);
        curl_close($req);

        return $res_json;
    }

    public function get_last_location($locations)
    {
        if (!is_null($locations)) return end($locations);
    }
}