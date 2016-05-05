<?php
require_once(APPPATH.'controllers/client/Base_Controller.php');

class Shopping_cart extends Base_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->lang->load('client/cart', session_site_lang());
    }

    public function index()
    {
        $this->load->model('shopping_cart_model');
        $user_id = session_logged_in()['user_id'];
        $carts = array();
        if (is_distributor())
        {
            $carts = $this->shopping_cart_model->all(0, $user_id);
        }
        // else
        // {
        //     $carts = $this->session->userdata('carts');
        //     $carts = json_decode(json_encode($carts), FALSE);
        // }
        load_client_views('cart/index', compact('carts'));
    }

    public function checkout()
    {
        $this->load->view('client/cart/checkout');
    }

    public function order()
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
                $data = array(
                'status' => FALSE,
                'messages' => $this->lang->line('request_failure'));
                $types = json_decode($this->input->post('types', TRUE));
                if ($types != NULL && is_distributor())
                {
                    $content = "I want to buy \r\n";
                    foreach ($types as $type)
                    {
                        $content .= 'Name: '. $type->name. ', Quantity: '. $type->quantity."\r\n";
                    }
                    $message_data = array(
                    'email' => $this->input->post('email', TRUE),
                    'phone_number' => $this->input->post('phone_number', TRUE),
                    'address' => $this->input->post('address', TRUE),
                    'postal_code' => $this->input->post('postal_code', TRUE),
                    'name' => $this->input->post('name', TRUE),
                    'total_money' => $this->input->post('total_money', TRUE),
                    'content' => $content,
                    'status_order' => ORDER);
                    $this->load->model(array('orders_model', 'shopping_cart_model'));
                    $this->db->trans_begin();
                    $this->orders_model->insert($message_data);
                    $user_session = session_logged_in();
                    $this->shopping_cart_model->delete_cart_of_user($user_session['user_id']);
                    // else
                    // {
                    //     $this->session->unset_userdata('carts');
                    // }
                    if ($this->db->trans_status() === FALSE)
                    {
                        $this->db->trans_rollback();
                    }
                    else
                    {
                        $this->db->trans_commit();
                        $data['status'] = TRUE;
                        $data['messages'] = $this->lang->line('order_success');
                    }
                }
            }
        }
        echo json_encode($data);
    }

    public function buy_now()
    {
        $data = $this->update_cart_ajax('buy_now');
        echo json_encode($data);
    }

    public function add_cart()
    {
        $data = $data = $this->update_cart_ajax('add_cart');
        echo json_encode($data);
    }

    public function update_cart_ajax($view = 'add_cart')
    {
        $data = array();
        $data['status'] = FALSE;
        $data['messages'] = $this->lang->line('request_failure');
        if ($this->input->is_ajax_request())
        {
            if (is_distributor())
            {
                list($result, $shopping_cart) = $this->update_cart_in_db();
                if ($result)
                {
                    $data['status'] = TRUE;
                    $data['is_increase_quantity'] = ($shopping_cart) ? TRUE : FALSE;
                    if ($shopping_cart)
                    {
                        $data['is_increase_quantity'] = TRUE;
                        $data['messages'] = $this->lang->line('increase_quantity_success');
                    }
                    else
                    {
                        $data['is_increase_quantity'] = FALSE;
                        $data['messages'] = $this->lang->line('add_cart_success');
                    }
                    $data['redirect_url'] = ($view == 'buy_now') ? base_url('client/shopping_cart') : NULL;
                }
            }
            // else
            // {
            //     //$this->session->unset_userdata('carts');
            //     $data = $this->update_cart_in_session();
            //     $data['redirect_url'] = ($view == 'buy_now') ? base_url('client/shopping_cart') : NULL;
            // }
        }
        return $data;
    }

    public function update_cart_in_db()
    {
        $type_id = $this->input->post('type_id', TRUE);
        $user_id = $this->session->userdata('logged_in')['user_id'];
        $this->load->model('shopping_cart_model');
        $shopping_cart = $this->shopping_cart_model->find($user_id, $type_id);
        if ($shopping_cart)
        {
            $quantity = $shopping_cart->quantity + 1;
            $result = $this->shopping_cart_model->update($shopping_cart->id, $quantity);
        }
        else
        {
            $shopping_cart_data = array();
            $shopping_cart_data['user_id'] = $user_id;
            $shopping_cart_data['type_id'] = $type_id;
            $shopping_cart_data['quantity'] = 1;
            $result = $this->shopping_cart_model->insert($shopping_cart_data);
        }
        return [$result, $shopping_cart];
    }

    public function update_cart_in_session()
    {
        $carts = array();
        $data = array();
        $data['status'] = TRUE;
        $data['is_increase_quantity'] = FALSE;
        $data['messages'] = $this->lang->line('add_cart_success');
        $type_id = $this->input->post('type_id');
        $type_name = $this->input->post('type_name');
        $type_price = $this->input->post('type_price');
        $type_image = $this->input->post('type_image');
        if ($this->session->has_userdata('carts'))
        {
            $carts = $this->session->userdata('carts');
            foreach ($carts as $key => $cart)
            {
                if ($cart['type_id'] === $type_id)
                {
                    $cart_temp = array(
                        'type_id' => $type_id,
                        'type_name' => $type_name,
                        'type_image' => $type_image,
                        'price' => $type_price,
                        'quantity' => $cart['quantity'] + 1);
                    unset($carts[$key]);
                    $carts[] = $cart_temp;
                    $this->session->set_userdata('carts', $carts);
                    $data['is_increase_quantity'] = TRUE;
                    $data['messages'] = $this->lang->line('increase_quantity_success');
                    return $data;
                }
            }
        }
        $cart = array(
                'type_id' => $type_id,
                'type_name' => $type_name,
                'price' => $type_price,
                'type_image' => $type_image,
                'quantity' => 1);
        $carts[] = $cart;
        $this->session->set_userdata('carts', $carts);
        return $data;
    }

    public function remove_cart()
    {
        $data = array();
        $data['status'] = FALSE;
        $data['messages'] = $this->lang->line('request_failure');
        if ($this->input->is_ajax_request())
        {
            $cart_item = $this->input->post('cart_item', TRUE)[0];
            // $carts = $this->session->userdata('carts');
            // if ($carts)
            // {
            //     if ($this->remove_cart_in_session($cart_item, $carts))
            //     {
            //         $data['status'] = TRUE;
            //         $data['messages'] = $this->lang->line('remove_cart_success');
            //     }
            // }
            if (is_distributor())
            {
                if ($this->remove_cart_in_db($cart_item))
                {
                    $data['status'] = TRUE;
                    $data['messages'] = $this->lang->line('remove_cart_success');
                }
            }
        }
        echo json_encode($data);
    }

    public function remove_cart_in_db($cart_item)
    {
        $this->load->model('shopping_cart_model');
        $user_id = $this->session->userdata('logged_in')['user_id'];
        $result = $this->shopping_cart_model->delete($cart_item, $user_id);
        return $result;
    }

    public function remove_cart_in_session($cart_item, $carts)
    {
        foreach ($carts as $key => $cart)
        {
            if ($cart['type_id'] == $cart_item)
            {
                unset($carts[$key]);
                $this->session->set_userdata('carts', $carts);
                return TRUE;
            }
        }
        return FALSE;
    }

    public function form_validation_rules()
    {
        $this->config->set_item('language', session_site_lang());
        $this->load->helper('security');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'lang:name', 'trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('email', 'lang:email', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('phone_number', 'lang:phone_number', 'required|trim|min_length[9]|xss_clean');
        $this->form_validation->set_rules('address', 'lang:address', 'trim|required|xss_clean');
        $this->form_validation->set_rules('postal_code', 'lang:postal_code', 'trim|required|numeric|xss_clean');
        $this->form_validation->set_error_delimiters("<div class='text-danger'>", '</div>');
    }

}

?>