<?php
class Auth {
    private $CI;

    function __construct()
    {
        $this->CI = &get_instance();
    }

    function check_login()
    {
        if (!$this->CI->session->userdata('logged_in'))
        {
            // redirect('login', 'refresh');
        }
    }
}