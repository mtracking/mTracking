<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Language extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    function switch_language($lang)
    {
        $this->load->library('user_agent');
        if (session_site_lang())
        {
            set_session_site_lang($lang);
        }
        redirect($this->agent->referrer());
    }

}

/* End of file Base_Controller.php */
/* Location: ./application/controllers/Base_Controller.php */
?>