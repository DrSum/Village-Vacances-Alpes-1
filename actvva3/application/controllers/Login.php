<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->model('EZ_query');
    }

    public function index()
    {
        $this->form_validation->set_rules('password',
                                          'Password',
                                          'trim|required|callback_login_check');
        $this->form_validation->set_rules('username',
                                          'Username',
                                          'trim|required');
        $this->form_validation->set_error_delimiters('<br>', '</br>');

        $data['title'] = 'Login';
        $data['active'] = "Login";

        $form_data['header_title'] = 'Connexion';
        $form_data['header_subtitle'] = 'Remplissez les champs afin d\'accéder à votre compte';
        $form_data['destination'] = 'login';
        $form_data['form_elements'] = array(array('label'       =>'Nom d\'Utilisateur *',
                                                  'name'        =>'username',
                                                  'class'       =>'form-control',
                                                  'required'    =>'required',
                                                  'oninvalid'   =>"setCustomValidity('Veuillez renseigner le nom d\'utilisateur.')",
                                                  'oninput'     =>"setCustomValidity('')",
                                                  'sur_type'    =>'classic'),
                                            array('label'       =>'Mot de Passe *',
                                                  'name'        =>'password',
                                                  'class'       =>'form-control',
                                                  'required'    =>'required',
                                                  'oninvalid'   =>"setCustomValidity('Veuillez renseigner le mot de passe.')",
                                                  'oninput'     =>"setCustomValidity('')",
                                                  'sur_type'    =>'password'));
        $form_data['form_button_attributes'] = array('name'=>'submit',
                                                     'value'=>'Se Connecter',
                                                     'class'=>'btn btn-primary btn-lg');

        if ($this->form_validation->run() == FALSE) {
            //loading view as long as it is not correct
            $this->load->view('header', $data);
            $this->load->view('form', $form_data);
            $this->load->view('footer');
        } else {
            $this->set_session_variables();

            $data['title'] = $this->session->fname . " " . $this->session->name;
            $data['active'] = "Accueil";
            $data['session'] = $this->session->userdata();
            $this->load->view('header', $data);
            $this->load->view('welcome_screen');
            $this->load->view('footer');
        }
    }

    public function login_check()
    {
        $usr = $this->input->post('username');
        $pwd = $this->input->post('password');

        $result = $this->EZ_query->exists_user($usr, $pwd);

        if ($result == FALSE) {
            $this->form_validation->set_message('login_check', 'Nom d\'utilisateur ou mot de passe erroné.');
            return FALSE;
        }
        return TRUE;
    }

    public function set_session_variables()
    {
        $usr = $this->input->post('username');
        $pwd = $this->input->post('password');

        $result = $this->EZ_query->get_user_details($usr, $pwd);

        $user_details = $result->row();
        $row2;
        $user;

        switch($user_details->TYPEPROFIL) {
            case 'en':
                $encadrant = $this->EZ_query->get_encadrant($usr);
                $row2 = $encadrant->row();

                $user = array('no'        => $row2->NOENCADRANT,
                              'name'      => $row2->NOMPROFIL,
                              'fname'     => $row2->PRENOMPROFIL,
                              'type'      => $row2->TYPEPROFIL,
                              'connected' => TRUE);
                break;

            case 'lo':
                $loisant = $this->EZ_query->get_loisant($usr);
                $row2 = $loisant->row();

                $user = array('no'         => $row2->NOLOISANT,
                              'date_debut' => $row2->DATEDEBSEJOUR,
                              'date_fin'   => $row2->DATEFINSEJOUR,
                              'name'       => $row2->NOMPROFIL,
                              'fname'      => $row2->PRENOMPROFIL,
                              'age'        => $this->get_age($row2->DATENAISLOISANT),
                              'type'       => $row2->TYPEPROFIL,
                              'connected'  => TRUE);
                break;

            default:
                break;
        }

        $this->session->set_userdata($user);
    }

    public function get_age($dob) {
        $date = new DateTime($dob);
        $now = new DateTime();
        $interval = $now->diff($date);
        return $interval->y;
    }
}
