<?php
class Genqrcode extends CI_Controller {

    private $CI;

    function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->library('ciqrcode');
    }

    function generate($data)
    {
        $param = array();
        $param['data'] = $data['content'];
        $param['level'] = 'M';
        $param['size'] = 10;
        $param['savename'] = APPPATH. LINK_TO_SAVE_QRCODE. $data['file_name'].'.png';
        $this->CI->ciqrcode->generate($param);
        chmod($param['savename'], 0755);
    }
}