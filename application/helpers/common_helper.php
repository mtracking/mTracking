<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function is_admin()
{
    $CI = & get_instance();
    $logged_in = session_logged_in();
    if (is_logged_in() && $logged_in['role_id'] == ADMIN)
    {
        return TRUE;
    }
    else return FALSE;
}

function is_customer()
{
    $CI = & get_instance();
    $logged_in = session_logged_in();
    if (is_logged_in() && $logged_in['role_id'] == CUSTOMER)
    {
        return TRUE;
    }
    else return FALSE;
}

function is_distributor()
{
    $CI = & get_instance();
    $logged_in = session_logged_in();
    if (is_logged_in() && $logged_in['role_id'] == DISTRIBUTOR)
    {
        return TRUE;
    }
    else return FALSE;
}

function session_logged_in()
{
    $CI = & get_instance();
    return $CI->session->userdata('logged_in');
}

function set_session_logged_in($logged_in)
{
    $CI = & get_instance();
    $CI->session->set_userdata('logged_in', $logged_in);
}

function unset_session_logged_in()
{
    $CI = & get_instance();
    $CI->session->unset_userdata('logged_in');
}

function session_site_lang()
{
    $CI = & get_instance();
    return $CI->session->userdata('site_lang');
}

function set_session_site_lang($site_lang)
{
    $CI = & get_instance();
    $CI->session->set_userdata('site_lang', $site_lang);
}

function is_logged_in()
{
    $CI = & get_instance();
    if ($CI->session->has_userdata('logged_in'))
    {
        return TRUE;
    }
    else return FALSE;
}

function is_url_exist($url)
{
    $headers = get_headers($url);
    return stripos($headers[0],"200 OK") ? TRUE : FALSE;
}

function generate_random_string($length = 8)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        if ($i==4) $randomString .= '-';
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return date('is-').$randomString;
}

function generate_random_string_without_date($length = 8)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        if ($i==4) $randomString .= '-';
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function decode_serial_no($hash_serial_no)
{
    $index = strripos($hash_serial_no, '-');
    $serial_no = substr($hash_serial_no, 0, $index);
    $serial_active = substr($hash_serial_no, $index + 1, strlen($hash_serial_no));
    return [$serial_no, $serial_active];
}

function serialize_qrcode1($qrcode1)
{
    $qrcode1 = json_decode($qrcode1);
    $string = "";
    // $string .= "Scan QR#2 under cap to remove from inventory database to complete ensuring authentic bottle and ENJOY \r\n";
    // $string .= 'Check product detail : '.$qrcode1->detail."\r\n";
    $string .= 'SCAN ME NOW';
    $string .= $qrcode1->detail;
    return $string;
}

function serialize_qrcode2($qrcode2)
{
    $qrcode2 = json_decode($qrcode2);
    $string = $qrcode2->update_status;
    return $string;
}

function get_last_location($locations)
{
    if (!is_null($locations)) return end($locations);
}

function encode_encrypt($string)
{
    $string = str_replace(array('+', '/', '='), array('-', '_', '~'), $string);
    return $string;
}

function decode_encrypt($string)
{
    $string = str_replace(array('-', '_', '~'), array('+', '/', '='), $string);
    return $string;
}

function convert_img_to_base64($path)
{
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    return $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
}
?>