<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My404 extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index()
    {
        $data['title'] = "404";
        $this->load->view("header", $data);
        $this->load->view("error_screen");
        $this->load->view("footer");
    }
}
