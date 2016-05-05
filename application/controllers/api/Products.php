<?php

class Products extends CI_Controller {

    private $fake_ip = "203.119.44.0";
    private $api_url = "http://ip-api.com/json/";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('language');
        $this->lang->load('products', $this->session->userdata('site_lang'));
    }

    public function current($serial_no)
    {
        $result = $this->update($serial_no);
        echo json_encode($result);
    }

    public function open($serial_no)
    {
        $result = $this->update($serial_no, PRODUCT_OPENED_STATUS);
        echo json_encode($result);
    }

    private function update($serial_no, $status = NULL)
    {
        $res_mes['status'] = FALSE;
        $res_mes['message'] = $this->lang->line('update_failed_text');

        $this->load->model('products_model');
        $old_location = $this->products_model->find($serial_no);
        if ($old_location->status_product != PRODUCT_OPENED_STATUS)
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
                        $res_mes['message'] = $this->lang->line('update_success_text');
                    }

                } else
                {
                    $res_mes['message'] = $this->lang->line('ip_invalid');
                }
            }
        } else
        {
            $res_mes['message'] = $this->lang->line('product_opened_text');
        }

        return $res_mes;
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
}