<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notfound extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $heading = '404 Page Not Found';
        $message = 'The page you requested was not found.';
        $this->load->view('errors/html/error_404', compact('heading', 'message'));
    }
}