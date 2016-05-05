<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function load_language($file_language)
{
    $CI = & get_instance();
    $site_lang = session_site_lang();
    $CI->lang->load(array('header', 'main_sidebar', 'main_container', $file_language ,'footer'), $site_lang);
}

function check_language()
{
    $CI = & get_instance();
    if (!session_site_lang())
    {
        $site_lang = 'english';
        set_session_site_lang($site_lang);
    }
}
?>