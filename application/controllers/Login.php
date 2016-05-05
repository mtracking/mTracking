<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->has_userdata('site_lang'))
        {
            $site_lang = 'english';
            $this->session->set_userdata('site_lang', $site_lang);
        }
        $this->lang->load('login', session_site_lang());
    }

    public function index()
    {
        $this->load->view('login');
    }

    public function check()
    {
        $this->config->set_item('language', session_site_lang());
        $this->load->helper('security');
        $this->load->library('form_validation');
        //validation rules
        $this->form_validation->set_rules('email', 'lang:email', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('password', 'lang:password', 'trim|required|min_length[5]|xss_clean|callback_check_login');
        if ($this->form_validation->run() == FALSE)
        {
            $data['status'] = FALSE;
            $data['messages'] = validation_errors();

        }
        else
        {
            $data['status'] = TRUE;
            $data['messages'] = base_url('admin/home');
        }
        echo json_encode($data);
    }

    public function check_login($password)
    {
        $email = $this->input->post('email');
        $this->load->model('users_model');
        list($is_login, $user) = $this->users_model->login($email, $password);
        if (!$is_login)
        {
            $this->form_validation->set_message('check_login', $this->lang->line('check_login'));
            return FALSE;
        }
        if ($user->role_id == ADMIN)
        {
            $session_array = array(
                'user_id' => $user->id,
                'email' => $user->email,
                'full_name' => $user->full_name,
                'phone' => $user->phone,
                'role_id' => $user->role_id,
                'avatar' => base_url('/assets/img/users/'. $user->avatar_file_name),
                'avatar_file_name' => $user->avatar_file_name,
                'logged_in' => TRUE);
            $this->session->set_userdata('logged_in', $session_array);
        }
        else
        {
            $session_array = array(
                'user_id' => $user->id,
                'email' => $user->email,
                'full_name' => $user->full_name,
                'phone' => $user->phone,
                'address' => $user->address,
                'role_id' => $user->role_id,
                'avatar' => base_url('/assets/img/users/'. $user->avatar_file_name),
                'avatar_file_name' => $user->avatar_file_name,
                'logged_in' => TRUE);
            $this->session->set_userdata('client_logged_in', $session_array);
        }
        return TRUE;
    }

    public function logout()
    {
        $this->session->unset_userdata('logged_in');
        redirect('login','refresh');
    }

}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */
