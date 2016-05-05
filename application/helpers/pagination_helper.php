<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function pagination($total_rows, $per_page, $base_url = NULL, $uri_segment = 3)
{
    $CI = & get_instance();
    if (is_null($base_url))
    {
        $segment[] = $CI->router->fetch_class();
        $segment[] = $CI->router->fetch_method();
        $url = implode('/', $segment);
        $base_url = base_url('admin/'.$url);
    }
    $config['base_url'] = $base_url;
    $config['total_rows'] = $total_rows;
    $config['per_page'] = $per_page;
    $config['uri_segment'] = $uri_segment;
    $CI->load->library('pagination');
    $CI->pagination->initialize($config);
    return $CI->pagination->create_links();
}
?>