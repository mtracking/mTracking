<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!session_site_lang())
        {
            $site_lang = 'english';
            set_session_site_lang($site_lang);
        }
        $this->lang->load('register', session_site_lang());
    }

    public function index()
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
                $result = $this->insert_user();
                $data = array();
                if ($result)
                {
                    $data['status'] = TRUE;
                    $data['messages'] = $this->lang->line('register_success');
                }
                else
                {
                    $data['status'] = FALSE;
                    $data['messages'] = $this->lang->line('register_failure');
                }
            }
        }
        echo json_encode($data);
    }

    public function insert_user()
    {
        $this->load->library('bcrypt');
        $user_data = array(
            'email' => $this->input->post('email'),
            'full_name' => $this->input->post('full_name'),
            'address' => $this->input->post('address'),
            'postal_code' => $this->input->post('postal_code'),
            'phone' => $this->input->post('phone'),
            'encrypted_password' => $this->bcrypt->hash_password($this->input->post('password')));
        $this->load->model('users_model');
        list($result, $user_id) = $this->users_model->insert($user_data);
        if ($result)
        {
            $session_array = array(
                'user_id' => $user_id,
                'email' => $user_data['email'],
                'full_name' => $user_data['full_name'],
                'phone' => $user_data['phone'],
                'address' => $user_data['address'],
                'postal_code' => $user_data['postal_code'],
                'role_id' => CUSTOMER,
                'avatar' => NULL,
                'avatar_file_name' => NULL,
                'logged_in' => TRUE);
            set_session_logged_in($session_array);
            return TRUE;
        }
        return FALSE;

    }

    public function form_validation_rules()
    {
        $this->config->set_item('language', session_site_lang());
        $this->load->helper('security');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'lang:email', 'trim|required|min_length[5]|callback_check_email|xss_clean');
        $this->form_validation->set_rules('full_name', 'lang:full_name', 'trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('address', 'lang:address', 'trim|required|xss_clean');
        $this->form_validation->set_rules('phone', 'lang:phone', 'trim|required|min_length[8]|xss_clean');
        $this->form_validation->set_rules('postal_code', 'lang:postal_code', 'trim|required|numeric|xss_clean');
        $this->form_validation->set_rules('password', 'lang:password', 'trim|required|min_length[5]|xss_clean');
        $this->form_validation->set_rules('confirm_password', 'lang:confirm_password', 'trim|required|min_length[5]|matches[password]|xss_clean');
        $this->form_validation->set_error_delimiters("<div class='text-danger'>", '</div>');
    }

    public function check_email($email)
    {
        $this->load->model('users_model');
        if (!$this->users_model->is_email_existed($email))
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('check_email', $this->lang->line('check_email'));
            return FALSE;
        }
    }

}
