<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function load_main_views($view_content, $data)
{
    $CI = & get_instance();
    if (!$CI->input->is_ajax_request())
    {
	    $CI->lang->load(array('main_sidebar'), session_site_lang());
	    $CI->load->view('admin/templates/header');
	    $CI->load->view('admin/templates/main_sidebar');
	    $CI->load->view('admin/templates/main_container');
	}
    $CI->load->view('admin/'. $view_content, $data);
    if (!$CI->input->is_ajax_request())
    {
    	$CI->load->view('admin/templates/footer');
    }
}

function load_client_views($view_content, $data)
{
    $CI = & get_instance();
    $CI->load->model(array('customize_model', 'pages_model'));
    $customize = $CI->customize_model->get();
    $pages = $CI->pages_model->get_pages_is_available();
    $data_header = array();
    $data_footer = array();
    if (!is_null($customize))
    {
        $data_header = array(
            'site_title' => $customize->site_title,
            'background_file_name' => $customize->background_file_name,
            'title' => ((!empty($data['title'])) ? $data['title'] : NULL),
            'pages' => $pages);
        $data_footer = array('footer' => $customize->footer);
    }
    if (!$CI->input->is_ajax_request())
    {
        $CI->lang->load(array('client/templates'), session_site_lang());
        $CI->load->view('client/templates/header', $data_header);
    }
    $CI->load->view('client/'. $view_content, $data);
    if (!$CI->input->is_ajax_request())
    {
        $CI->load->view('client/templates/footer', $data_footer);
    }
}