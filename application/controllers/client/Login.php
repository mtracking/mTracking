<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!session_site_lang())
        {
            $site_lang = 'english';
            set_session_site_lang($site_lang);
        }
        $this->lang->load('login', session_site_lang());
    }

    public function index()
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
            $data['status'] = TRUE;
        }
        echo json_encode($data);
    }

    public function form_validation_rules()
    {
        $this->config->set_item('language', session_site_lang());
        $this->load->helper('security');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'lang:email', 'trim|required|min_length[5]|xss_clean');
        $this->form_validation->set_rules('password', 'lang:password', 'trim|required|min_length[5]|xss_clean|callback_check_login');
        $this->form_validation->set_error_delimiters("<div class='text-danger'>", '</div>');
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
        $session_array = array(
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'full_name' => $user->full_name,
                    'phone' => $user->phone,
                    'role_id' => $user->role_id,
                    'address' => $user->address,
                    'postal_code' => $user->postal_code,
                    'logged_in' => TRUE);
        if (!is_null($user->avatar_file_name))
        {
            $session_array['avatar'] = base_url(LINK_TO_GET_USERS_IMAGE. $user->avatar_file_name);
            $session_array['avatar_file_name'] = $user->avatar_file_name;
        }
        else
        {
            $session_array['avatar'] = NULL;
            $session_array['avatar_file_name'] = NULL;
        }
        set_session_logged_in($session_array);
        return TRUE;
    }

    public function logout()
    {
        unset_session_logged_in();
        redirect('client/store','refresh');
    }

}
