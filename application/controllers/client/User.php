<?php
require_once(APPPATH.'controllers/client/Base_Controller.php');

class User extends Base_Controller {

    private $user_id;

    public function __construct()
    {
        parent::__construct();
        $this->lang->load('client/user', session_site_lang());
        $this->user_id = session_logged_in()['user_id'];
    }

    public function index()
    {
        $this->load->model('products_model');
        $products_bought = count($this->products_model->buy_from_user(0, $this->user_id));
        load_client_views('user/profile', compact('products_bought'));
    }

    public function upload_avatar()
    {
        $data = array(
            'status' => FALSE,
            'messages' => $this->lang->line('update_failure'));
        if ($this->input->is_ajax_request())
        {
            $this->load->library('gallery');
            list($result, $image_data) = $this->gallery->image_upload(LINK_TO_SAVE_USERS_IMAGE);
            if ($result)
            {
                $update_user_data = array('avatar_file_name' => $image_data['file_name']);
                $this->load->model('users_model');
                if ($this->users_model->update_user($this->user_id, $update_user_data))
                {
                    $old_image_file_name = session_logged_in()['avatar_file_name'];
                    if (!is_null($old_image_file_name)) $this->gallery->image_delete(LINK_TO_SAVE_USERS_IMAGE. $old_image_file_name);
                    $this->update_session_avatar($update_user_data);
                    $data['status'] = TRUE;
                    $data['messages'] = $this->lang->line('update_profile_success');
                    $data['data'] = session_logged_in();
                }
            }
        }
        echo json_encode($data);
    }

    public function edit($request_name = 'profile')
    {
        if ($this->input->is_ajax_request())
        {
            ($request_name == 'profile') ? $this->form_profile_validation_rules() : $this->form_password_validation_rules();
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
                $data = $this->update($request_name);
            }
            echo json_encode($data);
        }
    }

    public function update($request_name = 'profile')
    {
        $data = array(
            'status' => FALSE,
            'messages' => $this->lang->line('update_failure'));
        $this->load->model('users_model');
        if ($request_name == 'profile')
        {
            $update_user_data = array(
                'full_name' => $this->input->post('full_name'),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address'),
                'postal_code' => $this->input->post('postal_code'));
            if ($this->users_model->update_user($this->user_id, $update_user_data))
            {
                $this->update_session_profile($update_user_data);
                $data['status'] = TRUE;
                $data['messages'] = $this->lang->line('update_profile_success');
                $data['data'] = session_logged_in();
            }
        }
        else
        {
            if ($this->users_model->change_password($this->user_id, $this->input->post('new_password')))
            {
                $data['status'] = TRUE;
                $data['messages'] = $this->lang->line('update_password_success');
            }
        }
        return $data;
    }

    public function update_session_profile($update_user_data)
    {
        $user_session = session_logged_in();
        $user_session['full_name'] = $update_user_data['full_name'];
        $user_session['phone'] = $update_user_data['phone'];
        $user_session['address'] = $update_user_data['address'];
        $user_session['postal_code'] = $update_user_data['postal_code'];
        set_session_logged_in($user_session);
    }

    public function update_session_avatar($update_user_data)
    {
        $user_session = session_logged_in();
        $user_session['avatar_file_name'] = $update_user_data['avatar_file_name'];
        $user_session['avatar'] = base_url(LINK_TO_GET_USERS_IMAGE. $update_user_data['avatar_file_name']);
        set_session_logged_in($user_session);
    }

    public function form_profile_validation_rules()
    {
        $this->config->set_item('language', session_site_lang());
        $this->load->helper('security');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('full_name', 'lang:full_name', 'trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('phone', 'lang:phone', 'trim|required|min_length[8]|xss_clean');
        $this->form_validation->set_rules('address', 'lang:address', 'trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('postal_code', 'lang:postal_code', 'trim|required|numeric|xss_clean');
        $this->form_validation->set_error_delimiters("<div class='text-danger'>", '</div>');
    }

    public function form_password_validation_rules()
    {
        $this->config->set_item('language', session_site_lang());
        $this->load->helper('security');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('current_password', 'lang:current_password', 'trim|required|min_length[5]|xss_clean|callback_check_password');
        $this->form_validation->set_rules('new_password', 'lang:new_password', 'trim|required|min_length[5]|xss_clean');
        $this->form_validation->set_rules('password_confirm', 'lang:password_confirm', 'trim|required|min_length[5]|matches[new_password]|xss_clean');
        $this->form_validation->set_error_delimiters("<div class='text-danger'>", '</div>');
    }

    public function check_password($current_password)
    {
        $this->load->model('users_model');
        if ($this->users_model->check_old_pwd($this->user_id, $current_password))
        {

            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('check_password', $this->lang->line('check_password'));
            return FALSE;
        }
    }
}