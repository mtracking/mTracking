<?php
require_once(APPPATH.'controllers/admin/Base_Controller.php');

class Users extends Base_Controller {
    private $limit = 10;
    private $profile_view_link;
    private $profile_update_url;

    public function __construct()
    {
        parent::__construct();
        $this->init();
    }

    private function init()
    {
        $this->profile_view_link = 'users/profile';
        $this->lang->load('users', session_site_lang());
        $this->load->helper('views');
        $this->load->model('users_model');
        $this->load->helper('security');
    }

    public function index()
    {
        $this->load->model('users_model','users');
        $search_user_label = $this->input->get('search', TRUE);
        $users = $this->users->all($this->limit, $search_user_label);
        $total_rows = $this->users->count($search_user_label);
        $this->load->helper('pagination');
        $page_links = pagination($total_rows, $this->limit, base_url('admin/users'));
        load_main_views('users/index', array('users' => $users, 'page_links' => $page_links));
    }

    public function add()
    {
        load_main_views('users/user', NULL);
    }

    public function edit($id)
    {
        $this->session->unset_userdata('image_upload');
        $this->load->model('users_model');
        $user = $this->users_model->user($id);
        load_main_views('users/user', compact('user'));
    }

    public function profile()
    {
        $user_sess = session_logged_in();
        $user_id = $user_sess['user_id'];
        $user = $this->users_model->user($user_id);
        $data['profile_url'] = $this->profile_update_url;
        $data['user'] = $user;
        $data['label'] = $this->lang->line('update_profile_text');
        load_main_views($this->profile_view_link, compact('data'));
    }

    public function store()
    {
        if ($this->input->is_ajax_request())
        {
            $check_validation = $this->form_update_validation_rules('add');
            if ($check_validation == FALSE)
            {
                $data['status'] = FALSE;
                $data['messages'] = validation_errors();
            }
            else
            {
                if ($this->update_user())
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
            $check_validation = $this->form_update_validation_rules();
            if ($check_validation == FALSE)
            {
                $data['status'] = FALSE;
                $data['messages'] = validation_errors();
            }
            else
            {
                if ($this->update_user($id))
                {
                    $data['status'] = TRUE;
                    $data['messages'] = $this->lang->line('update_success');
                }
                else
                {
                    $data['status'] = FALSE;
                    $data['messages'] = $this->lang->line('update_failure');
                }
                $this->session->unset_userdata('image_upload');
            }
            echo json_encode($data);
        }
    }

    public function upload_avatar($user_id)
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
                $this->load->model('users_model');
                $old_image_file_name = $this->users_model->user($user_id)->avatar_file_name;
                $update_user_data = array('avatar_file_name' => $image_data['file_name']);
                if ($this->users_model->update_user($user_id, $update_user_data))
                {
                    if (!is_null($old_image_file_name)) $this->gallery->image_delete(LINK_TO_SAVE_USERS_IMAGE. $old_image_file_name);
                    $data['status'] = TRUE;
                    $data['messages'] = $this->lang->line('update_profile_success');
                    $data['data'] = base_url(LINK_TO_GET_USERS_IMAGE. $image_data['file_name']);
                }
            }
        }
        echo json_encode($data);
    }

    public function update_user($id = NULL)
    {
        $user_data = array(
            'full_name' => $this->input->post('full_name'),
            'address' => $this->input->post('address'),
            'phone' => $this->input->post('phone'),
            'role_id' => $this->input->post('role')
            );
        $this->load->library('bcrypt');
        if (!is_null($id))
        {
            $user_data['id'] = $id;
            if ($this->input->post('password') != '')
            {
                $user_data['encrypted_password'] = $this->bcrypt->hash_password($this->input->post('password'));
            }
        }
        else
        {
            $user_data['email'] = $this->input->post('email');
            $user_data['encrypted_password'] = $this->bcrypt->hash_password($this->input->post('password'));
        }
        $this->load->model('users_model');
        return (is_null($id)) ? $this->users_model->insert($user_data) : $this->users_model->update_user($user_data['id'], $user_data);
    }

    public function update_profile_of_user()
    {
        if ($this->input->is_ajax_request())
        {

            $response_data['status'] = FALSE;
            $response_data['messages'] = $this->lang->line('update_failed_msg');

            $check_validation = $this->update_profile_validation();
            if ($check_validation)
            {
                $result = $this->update_profile();
                if ($result)
                {
                    $response_data['status'] = TRUE;
                    $response_data['messages'] = $this->lang->line('update_success_msg');
                }
            } else
            {
                $response_data['messages'] = validation_errors();
            }
            echo json_encode($response_data);
        }
    }

    public function delete($id = NULL)
    {
        $this->load->model('users_model');
        if ($this->input->is_ajax_request())
        {
            $response_data['status'] = FALSE;
            $response_data['messages'] = $this->lang->line('update_failed_msg');
            if ($id)
            {
                $delete_result = $this->users_model->delete_users($id);
                if ($delete_result)
                {
                    $response_data['status'] = TRUE;
                    $response_data['messages'] = $this->lang->line('update_success_msg');
                }
            } else
            {
                $list_users = $this->input->post('listIdChecked');
                $delete_result = $this->users_model->delete($list_users);
                if ($delete_result)
                {
                    $response_data['status'] = TRUE;
                    $response_data['messages'] = $this->lang->line('update_success_msg');
                }
            }
        }
        echo json_encode($response_data);
    }

    public function change_password()
    {
        if ($this->input->is_ajax_request())
        {
            $check_validation = $this->change_pwd_form_validation();

            $response_data['status'] = FALSE;
            $response_data['messages'] = $this->lang->line('update_failed_msg');
            if ($check_validation)
            {
                $user_sess = session_logged_in();
                $user_id = $user_sess['user_id'];
                $new_password = $this->input->post('pwd_new');
                $result = $this->users_model->change_password($user_id, $new_password);
                if ($result)
                {
                    $response_data['status'] = TRUE;
                    $response_data['messages'] = $this->lang->line('update_success_msg');
                }
            } else
            {
                $response_data['messages'] = validation_errors();
            }
            echo json_encode($response_data);
        }
    }

    private function update_profile()
    {
        $user['full_name'] = $this->input->post('user_name');
        $user['email'] = $this->input->post('user_email');
        $user['phone'] = $this->input->post('phone_number');
        $user['updated_at'] = date('Y-m-d H:i:s');
        $user_sess = session_logged_in();
        $user_id = $user_sess['user_id'];

        return $this->users_model->update_user($user_id, $user);
    }

    private function form_update_validation_rules($view = NULL)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('full_name', 'lang:name_text', 'trim|required|min_length[3]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('address', 'lang:address_text', 'trim|required|max_length[255]|xss_clean');
        $this->form_validation->set_rules('role', 'lang:role', 'trim|required|numeric|xss_clean');
        $this->form_validation->set_rules('phone', 'lang:phone_text', 'trim|numeric|required|min_length[8]|max_length[15]|xss_clean');
        if ($view == 'add')
        {
            $this->form_validation->set_rules('email', 'lang:email_text', 'trim|required|max_length[255]|valid_email|xss_clean|callback_check_email');
            $this->form_validation->set_rules('password', 'lang:password_text', 'trim|required|min_length[5]|max_length[255]|xss_clean');
        }
        else
        {
            $this->form_validation->set_rules('password', 'lang:password_text', 'trim|min_length[5]|max_length[255]|xss_clean');
        }
        return $this->form_validation->run();
    }

    private function update_profile_validation()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_name', 'lang:name_text', 'trim|required|min_length[3]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('user_email', 'lang:email_text', 'trim|required|max_length[255]|valid_email|xss_clean');
        $this->form_validation->set_rules('phone_number', 'lang:phone_text', 'trim|numeric|required|min_length[8]|max_length[10]|xss_clean');
        return $this->form_validation->run();
    }

    private function change_pwd_form_validation()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('pwd_old', 'lang:old_password_text', 'trim|required|min_length[5]|max_length[255]|xss_clean|callback_check_old_password');
        $this->form_validation->set_rules('pwd_new', 'lang:new_password_text', 'trim|required|xss_clean|min_length[5]');
        $this->form_validation->set_rules('pwd_new_confirm', 'lang:new_password_confirm_text', 'trim|required|min_length[5]|xss_clean|callback_confirm_password');

        return $this->form_validation->run();
    }

    public function confirm_password($new_password_confirm)
    {
        $new_password = $this->input->post('pwd_new');
        if (strcmp($new_password, $new_password_confirm) == 0)
        {
            return TRUE;
        } else
        {
            $this->form_validation->set_message('confirm_password', $this->lang->line('mismatch_password_text'));
            return FALSE;
        }
    }

    public function check_old_password($old_password)
    {
        $user_sess = session_logged_in();
        $user_id = $user_sess['user_id'];
        $check_old_pwd = $this->users_model->check_old_pwd($user_id, $old_password);

        if ($check_old_pwd)
        {
            return TRUE;
        } else
        {
            $this->form_validation->set_message('check_old_password', $this->lang->line('wrong_password_text'));
            return FALSE;
        }
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