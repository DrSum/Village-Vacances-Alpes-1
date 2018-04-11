<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 function __construct() {
         parent::__construct();
     }

     public function index()
     {
		 if ($this->session->userdata("connected") == FALSE) {
			 $data['title'] = "Accueil";
		 } else {
			 $data['title'] = $this->session->fname . " " . $this->session->name;
		 }

         $data['active'] = "Accueil";
         $data['page'] = "homepage";
         $this->load->view('header', $data);
         $this->load->view('welcome_screen');
         $this->load->view('footer');
     }

	 public function disconnect()
	 {
		 $this->session->sess_destroy();
		 $this->session->set_userdata('connected', FALSE);
		 redirect('index.php/welcome');
	 }
}
