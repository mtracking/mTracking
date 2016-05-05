<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot_password extends CI_Controller {

    private $user = NULL;
    public function __construct()
    {
        parent::__construct();
        if (!session_site_lang())
        {
            $site_lang = 'english';
            set_session_site_lang($site_lang);
        }
        $this->lang->load('forgot_password', session_site_lang());
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
            $data['status'] = FALSE;
            $data['messages'] = $this->lang->line('forgot_password_failure');
            $new_password = $this->reset_password();
            if (!is_null($new_password))
            {
                if ($this->send_mail($new_password))
                {
                    $data['status'] = TRUE;
                    $data['messages'] = $this->lang->line('forgot_password_success');
                }
            }
        }
        echo json_encode($data);
    }

    public function form_validation_rules()
    {
        $this->config->set_item('language', session_site_lang());
        $this->load->helper('security');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'lang:email', 'trim|required|min_length[5]|xss_clean|callback_check_email');
        $this->form_validation->set_error_delimiters("<div class='text-danger'>", '</div>');
    }

    public function check_email($email)
    {
        $this->load->model('users_model');
        $user = $this->users_model->is_user_exist($email);
        if (is_null($user))
        {
            $this->form_validation->set_message('check_email', $this->lang->line('check_email'));
            return FALSE;
        }
        else $this->user = $user;
    }

    public function reset_password()
    {
        $new_password = generate_random_string_without_date(12);
        $this->load->model('users_model');
        $result = $this->users_model->change_password($this->user->id, $new_password);
        return ($result) ? $new_password : NULL;
    }

    public function send_mail($new_password)
    {
        $this->load->library('email');
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => 'michael.winestore@gmail.com',
            'smtp_pass' => 'enclaveit@123',
            'mailtype'  => 'html',
            'auth' => true,
            'charset'   => 'iso-8859-1'
        );
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->from('michael.winestore@gmail.com', 'Wine Store');
        $this->email->to($this->user->email);
        $this->email->subject('Wine Store');
        $this->email->message('Hi, '.$this->user->full_name.'. This is your new password: '. $new_password);
        return $this->email->send();
    }

}
