<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Base_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('language');
        $this->load->helper('views');
        check_language();
    }

    function check_auth()
    {
        if (!session_logged_in())
        {
            redirect('client/login');
        }
    }

}

/* End of file Base_Controller.php */
/* Location: ./application/controllers/Base_Controller.php */
?>