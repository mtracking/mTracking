<?php
require_once(APPPATH.'controllers/admin/Base_Controller.php');

class Batches extends Base_Controller {
    private $limit = 5;
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('batches', session_site_lang());
    }

    public function index()
    {
        $this->load->model('batches_model');
        $search_batch = $this->input->get('search', TRUE);
        $batches = $this->batches_model->all($this->limit, $search_batch);
        $total_rows = $this->batches_model->count($search_batch);
        $this->load->helper('pagination');
        $page_links = pagination($total_rows, $this->limit, base_url('admin/batches'));
        load_main_views('batches/index', array('batches' => $batches, 'page_links' => $page_links));
    }

    public function label($id)
    {
        $this->load->model('batches_model');
        $batch = $this->batches_model->find($id);
        $this->load->view('admin/batches/label', compact('batch'), FALSE);
    }

    public function export($id)
    {
        $this->load->model('products_model');
        $products = $this->products_model->get_products_of_batch($id);
        $view = $this->load->view('admin/batches/export', compact('products'), TRUE);
        $this->pdf_report($view, $products[0]->batch_lot);
    }

    public function add()
    {
        $this->load->model('categories_model');
        $categories = $this->categories_model->get_all_categories();
        $types = array();
        $subtypes = array();
        if (!empty($categories))
        {
            $this->load->model('types_model');
            $types = $this->types_model->belong_to_category(0, $categories[0]->id);
            if (!empty($types))
            {
                $this->load->model('subtypes_model');
                $subtypes = $this->subtypes_model->belong_to_type($types[0]->id);
            }
        }
        load_main_views('batches/batch', compact('categories', 'types', 'subtypes'));
    }

    public function store()
    {
        if ($this->input->is_ajax_request())
        {
            $this->form_validation_rules();
            if ($this->form_validation->run() == FALSE)
            {
                $data['status'] = FALSE;
                $data['messages'] = validation_errors();
            }
            else
            {
                if ($this->update_batch())
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

    public function update($id)
    {
        if ($this->input->is_ajax_request())
        {
            $this->form_validation_rules('update');
            if ($this->form_validation->run() == FALSE)
            {
                $data['status'] = FALSE;
                $data['messages'] = validation_errors();
            }
            else
            {
                if ($this->update_batch($id))
                {
                    $data['status'] = TRUE;
                    $data['messages'] = $this->lang->line('update_success');
                }
                else
                {
                    $data['status'] = FALSE;
                    $data['messages'] = $this->lang->line('update_failure');
                }
            }
            echo json_encode($data);
        }
    }

    public function delete($id)
    {
        $data = array();
        $data['status'] = FALSE;
        $data['messages'] = $this->lang->line('delete_failure');
        if ($this->input->is_ajax_request())
        {
            $this->load->model('batches_model');
            $result = $this->batches_model->delete($id);
            if ($result)
            {
                $data['status'] = TRUE;
                $data['messages'] = $this->lang->line('delete_success');
            }
        }
        echo json_encode($data);
    }

    public function update_status($id)
    {
        $response_data = array();
        if ($this->input->is_ajax_request())
        {
            $is_active = $this->input->get('is_active', TRUE);
            $this->load->model('batches_model');
            $batch_data = array('id' => $id, 'is_active'=> $is_active);
            $result = $this->batches_model->update($batch_data);
            if ($result)
            {
                $response_data['status'] = TRUE;
                $response_data['messages'] = $this->lang->line('update_success_msg');
            }
            else
            {
                $response_data['status'] = FALSE;
                $response_data['messages'] = $this->lang->line('update_failed_msg');
            }
        }
        echo json_encode($response_data);
    }

    public function update_batch($id = NULL)
    {
        $this->load->model('batches_model');
        if (is_null($id))
        {
            $batch_data = array(
            'lot' => $this->generate_lot_of_batch(),
            'producing_date' => $this->input->post('producing_date'),
            'expiry_date' => $this->input->post('expiry_date'),
            'quantity' => $this->input->post('quantity'),
            'volume' => $this->input->post('volume'),
            'subtype_id' => $this->input->post('subtype'),
            'is_active' => ACTIVE
            );
            $this->db->trans_begin();
            list($result, $id) = $this->batches_model->insert($batch_data);
            if ($result)
            {
                $batch_data['id'] = $id;
                $batch_data['type_id'] = $this->input->post('type');
                $products = $this->create_products($batch_data);
                $this->load->model('products_model');
                $this->products_model->insert($products);
                if ($this->db->trans_status() === FALSE)
                {
                    $this->db->trans_rollback();
                    return FALSE;
                }
                else
                {
                    $this->db->trans_commit();
                    return $this->generate_qrcode($products);
                }
            }
        }
        else
        {
            $batch_data['id'] = $id;
            return $this->batches_model->update($batch_data);
        }
    }

    public function generate_lot_of_batch()
    {
        $producing_date = $this->input->post('producing_date');
        $count_batches_have_same_date = $this->batches_model->get_batches_with_date($producing_date);
        $lot = date('m-d-Y', strtotime($producing_date)). "_".++$count_batches_have_same_date;
        return $lot;
    }

    public function create_products($batch_data)
    {
        $this->load->helper('common');
        $products = array();
        for ($i = 0; $i < $batch_data['quantity']; $i++)
        {
            $product = array();
            $product['serial_no'] = generate_random_string(8);
            $product['serial_active'] = generate_random_string_without_date(4);
            $product['batch_id'] = $batch_data['id'];
            $product['status_product'] = PRODUCT_NOT_OPENED_STATUS;
            list($qrcode1, $qrcode2) = $this->create_qrcode($batch_data, $product);
            $product['qrcode1'] = $qrcode1;
            $product['qrcode2'] = $qrcode2;
            array_push($products, $product);
        }
        return $products;
    }

    public function create_qrcode($batch_data, $product)
    {
        $this->load->model('types_model');
        $type = $this->types_model->find($batch_data['type_id']);
        $qrcode1 = array(
            'serial_no' => $product['serial_no'],
            'producing_date' => $batch_data['producing_date'],
            'expiry_date' => $batch_data['expiry_date'],
            'name' => $type->name,
            'storage_temperature' => $type->storage_temp,
            'characteristics' => $type->characteristics,
            'country' => $type->country,
            'detail' => base_url('client/products/view/'. $product['serial_no'])
            );
        $hash_serial_no = $product['serial_no']. '-'. $product['serial_active'];
        $qrcode2 = array(
            'update_status' => base_url('client/products/status/'. $hash_serial_no)
            );
        return [json_encode($qrcode1), json_encode($qrcode2)];
    }

    public function form_validation_rules($view = 'add')
    {
        $this->config->set_item('language', session_site_lang());
        $this->load->helper('security');
        $this->load->library('form_validation');
        if ($view == 'add')
        {
            $this->form_validation->set_rules('subtype', 'lang:subtype', 'trim|required|xss_clean');
            $this->form_validation->set_rules('producing_date', 'lang:producing_date', 'trim|required|xss_clean');
            $this->form_validation->set_rules('expiry_date', 'lang:expiry_date', 'trim|xss_clean');
            $this->form_validation->set_rules('quantity', 'lang:quantity', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('volume', 'lang:volume', 'trim|required|numeric|xss_clean');
        }
    }

    public function generate_qrcode($products)
    {
        $this->load->library('genqrcode');
        set_time_limit(0);
        foreach ($products as $key => $product)
        {
            $data = array();
            $data['content'] = serialize_qrcode1($product['qrcode1']);
            $data['file_name'] = $product['serial_no']. QRCODE1;
            $data2 = array();
            $data2['content'] = serialize_qrcode2($product['qrcode2']);
            $data2['file_name'] = $product['serial_no']. QRCODE2;
            $this->genqrcode->generate($data);
            $this->genqrcode->generate($data2);
        }
        return TRUE;
    }

    public function pdf_report($html, $batch_lot)
    {
        ini_set('memory_limit','-1');
        $pdfFilePath = "export-".date('m-d-Y').".pdf";
        $this->load->library('m_pdf');
        $pdf = $this->m_pdf->load();
        $pdf->SetFooter('Batch: '.$batch_lot. '|{PAGENO}|'. date('D, d M Y'));
        $pdf->WriteHTML($html);
        $pdf->Output($pdfFilePath, "D");
    }

}
