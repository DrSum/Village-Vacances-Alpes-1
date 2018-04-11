<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class A_propos extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index()
    {
        $data['title'] = "A Propos";
        $data['active'] = "A Propos";
        $this->load->view("header", $data);
        #$this->load->view("a_propos");
        $this->load->view("footer");
    }
}
