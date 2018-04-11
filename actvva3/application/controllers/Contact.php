<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index()
    {
        $data['title'] = "Contact";
        $data['active'] = "Contact";
        $this->load->view('header', $data);
        #$this->load->view(contact);
        $this->load->view('footer');
    }
}
