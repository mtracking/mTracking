<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->check_auth();
    }

    function check_auth()
    {
        if (!session_logged_in())
        {
            redirect('login');
        }
    }

}

/* End of file Base_Controller.php */
/* Location: ./application/controllers/Base_Controller.php */
?>