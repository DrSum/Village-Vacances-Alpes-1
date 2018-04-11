<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Animation extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('EZ_query');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function index($success_msg = null) {
        $data_header['title'] = "Animations";
        $data_header['active'] = "Liste Animations";

        $data['type_anims'] = $this->EZ_query->get_type_animation();

        $this->load->view('header', $data_header);

        if($this->session->type == 'en') {
            $data['success'] = $success_msg;
            $data['anims'] = $this->EZ_query->get_animations_array();
            $this->load->view('animation_list_screen', $data);
        } else {
            $data['anims'] = $this->EZ_query->get_future_animations();
            $this->load->view('read_only_animation_list_screen', $data);
        }

        $this->load->view('footer');
    }

    public function add_categorie() {
        if ($this->session->type == 'en') {
            $this->form_validation->set_rules('code_type_animation',
                                              'Code Type Animation',
                                              'trim|required|max_length[5]|callback_code_type_anim_check');
            $this->form_validation->set_rules('nom_type_animation',
                                              'Nom Type Animation',
                                              'trim|required');

            $this->form_validation->set_error_delimiters('<br>', '</br>');

            $data_header['title'] = "Animations";
            $data_header['active'] = "Ajouter Catégorie d\'Animation";

            $form_data['header_title'] = 'Ajouter une catégorie d\'animation';
            $form_data['header_subtitle'] = 'Remplissez les champs et validez afin de créer une nouvelle catégorie d\'animation';
            $form_data['destination'] = 'animation/add_categorie';
            $form_data['form_elements'] = array(array('label'       =>'Code Type Animation *',
                                                      'name'        =>'code_type_animation',
                                                      'class'       =>'form-control',
                                                      'required'    =>'required',
                                                      'oninvalid'   =>"setCustomValidity('Veuillez renseigner le code du type d\'animation.')",
                                                      'oninput'     =>"setCustomValidity('')",
                                                      'sur_type'    =>'classic',
                                                      'type'        =>'text',
                                                      'maxlength'  =>'5'),
                                                array('label'       =>'Nom Type Animation *',
                                                      'name'        =>'nom_type_animation',
                                                      'class'       =>'form-control',
                                                      'required'    =>'required',
                                                      'oninvalid'   =>"setCustomValidity('Veuillez renseigner le nom du type d\'animation.')",
                                                      'oninput'     =>"setCustomValidity('')",
                                                      'sur_type'    =>'classic',
                                                      'type'        =>'text',
                                                      'max_length'  =>'50'));
            $form_data['form_button_attributes'] = array('name'=>'submit',
                                                         'value'=>'Ajouter',
                                                         'class'=>'btn btn-primary btn-lg');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('header', $data_header);
                $this->load->view('form', $form_data);
                $this->load->view('footer');
            } else {
                $code = $this->input->post('code_type_animation');
                $nom = $this->input->post('nom_type_animation');

                $this->EZ_query->insert_categorie_animation($code, $nom);
                $form_data['success'] = "La nouvelle catégorie a bien été ajouté";

                $this->load->view('header', $data_header);
                $this->load->view('form', $form_data);
                $this->load->view('footer');
            }
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function code_type_anim_check()
    {
        $code = $this->input->post('code_type_animation');

        $result = $this->EZ_query->exists_type_animation($code);

        if($result == TRUE) {
            $this->form_validation->set_message('code_type_anim_check', 'Ce code de type d\'animation est déjà utilisé.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function add_animation() {
        $data_header['title']  = "Animations";
        $data_header['active'] = "Ajouter Animation";

        $validation_rules = array(array('field' => 'cd_anim',
                                        'label' => 'Code Animation',
                                        'rules' => 'callback_check_code_animation|trim|required|max_length[8]'),
                                  array('field' => 'nom_type_anim',
                                        'label' => 'Nom Type Animation',
                                        'rules' => 'required'),
                                  array('field' => 'nom_anim',
                                        'label' => 'Nom Animation',
                                        'rules' => 'trim|required'),
                                  array('field' => 'debut_anim',
                                        'label' => 'Début Animation',
                                        'rules' => 'trim|required'),
                                  array('field' => 'fin_anim',
                                        'label' => 'Fin Animation',
                                        'rules' => 'trim|required'),
                                  array('field' => 'duree_anim',
                                        'label' => 'Durée Animation',
                                        'rules' => 'trim|required'),
                                  array('field' => 'lim_age',
                                        'label' => 'Limite Age',
                                        'rules' => 'trim|required|numeric'),
                                  array('field' => 'tarif_anim',
                                        'label' => 'Tarif Animation',
                                        'rules' => 'trim|required|numeric'),
                                  array('field' => 'nb_places_anim',
                                        'label' => 'Nombre Places Animation',
                                        'rules' => 'trim|required|numeric'),
                                  array('field' => 'desc_anim',
                                        'label' => 'Description Animation'),
                                  array('field' => 'comm_anim',
                                        'label' => 'Commentaires Animation'),
                                  array('field' => 'diff_anim',
                                        'label' => 'Difficulté Animation',
                                        'rules' => 'trim|required|numeric'));

        $this->form_validation->set_rules($validation_rules);
        $this->form_validation->set_error_delimiters('<br>', '</br>');

        $form_data['header_title']    = 'Ajouter une animation';
        $form_data['header_subtitle'] = 'Remplissez les champs et validez afin de créer une nouvelle animation';
        $form_data['destination']     = 'animation/add_animation';
        $form_data['form_elements'] = array(array('label'       =>'Code Animation *',
                                                  'name'        =>'cd_anim',
                                                  'class'       =>'form-control',
                                                  'required'    =>'required',
                                                  'oninvalid'   =>"setCustomValidity('Veuillez renseigner le code de l\'animation.')",
                                                  'oninput'     =>"setCustomValidity('')",
                                                  'sur_type'    =>'classic',
                                                  'type'        =>'text',
                                                  'maxlength'  =>'8'),
                                            array('label'       =>'Nom Animation *',
                                                  'name'        =>'nom_anim',
                                                  'class'       =>'form-control',
                                                  'required'    =>'required',
                                                  'oninvalid'   =>"setCustomValidity('Veuillez renseigner le nom de l\'animation.')",
                                                  'oninput'     =>"setCustomValidity('')",
                                                  'sur_type'    =>'classic',
                                                  'type'        =>'text',
                                                  'maxlength'   =>'40'),
                                            array('label'       =>'Nom Type Animation *',
                                                  'name'        =>'nom_type_anim',
                                                  'class'       =>'form-control',
                                                  'required'    =>'required',
                                                  'oninvalid'   =>"setCustomValidity('Veuillez renseigner le nom du type d\'animation.')",
                                                  'oninput'     =>"setCustomValidity('')",
                                                  'sur_type'    =>'dropdown'),
                                            array('label'       =>'Début Animation *',
                                                  'name'        =>'debut_anim',
                                                  'class'       =>'form-control',
                                                  'value'       => date('d-m-Y'),
                                                  'required'    =>'required',
                                                  'oninvalid'   =>"setCustomValidity('Veuillez renseigner la date de début de l\'animation.')",
                                                  'oninput'     =>"setCustomValidity('')",
                                                  'sur_type'    =>'datepicker'),
                                            array('label'       =>'Fin Animation *',
                                                  'name'        =>'fin_anim',
                                                  'class'       =>'form-control',
                                                  'value'       => date('d-m-Y'),
                                                  'required'    =>'required',
                                                  'oninvalid'   =>"setCustomValidity('Veuillez renseigner la date de fin l\'animation.')",
                                                  'oninput'     =>"setCustomValidity('')",
                                                  'sur_type'    =>'datepicker'),
                                            array('label'       =>'Durée Animation *',
                                                  'name'        =>'duree_anim',
                                                  'class'       =>'form-control',
                                                  'required'    =>'required',
                                                  'oninvalid'   =>"setCustomValidity('Veuillez renseigner la durée de l\'animation.')",
                                                  'oninput'     =>"setCustomValidity('')",
                                                  'sur_type'    =>'classic',
                                                  'type'        =>'numeric'),
                                            array('label'       =>'Limite d\'Age *',
                                                  'name'        =>'lim_age',
                                                  'class'       =>'form-control',
                                                  'required'    =>'required',
                                                  'oninvalid'   =>"setCustomValidity('Veuillez renseigner la limite d\'age pour l\'animation.')",
                                                  'oninput'     =>"setCustomValidity('')",
                                                  'sur_type'    =>'classic',
                                                  'type'        =>'numeric',
                                                  'min'         =>'0',
                                                  'max'         =>'99'),
                                            array('label'       =>'Tarif Animation *',
                                                  'name'        =>'tarif_anim',
                                                  'class'       =>'form-control',
                                                  'required'    =>'required',
                                                  'oninvalid'   =>"setCustomValidity('Veuillez renseigner le tarif de l\'animation.')",
                                                  'oninput'     =>"setCustomValidity('')",
                                                  'sur_type'    =>'classic',
                                                  'type'        =>'numeric'),
                                            array('label'       =>'Nombre de Places *',
                                                  'name'        =>'nb_places_anim',
                                                  'class'       =>'form-control',
                                                  'required'    =>'required',
                                                  'oninvalid'   =>"setCustomValidity('Veuillez renseigner le nombre de places pour l\'animation.')",
                                                  'oninput'     =>"setCustomValidity('')",
                                                  'sur_type'    =>'classic',
                                                  'type'        =>'numeric',
                                                  'min'         =>'1',
                                                  'max'         =>'99'),
                                            array('label'       =>'Description',
                                                  'name'        =>'desc_anim',
                                                  'class'       =>'form-control',
                                                  'sur_type'    =>'textarea',
                                                  'type'        =>'text',
                                                  'maxlength'   =>'255'),
                                            array('label'       =>'Commentaires',
                                                  'name'        =>'comm_anim',
                                                  'class'       =>'form-control',
                                                  'sur_type'    =>'textarea',
                                                  'type'        =>'text',
                                                  'maxlength'   =>'255'),
                                            array('label'       =>'Difficulté *',
                                                  'name'        =>'diff_anim',
                                                  'class'       =>'form-control',
                                                  'required'    =>'required',
                                                  'oninvalid'   =>"setCustomValidity('Veuillez renseigner la difficulté de l\'animation.')",
                                                  'oninput'     =>"setCustomValidity('')",
                                                  'sur_type'    =>'classic',
                                                  'type'        =>'number',
                                                  'min'         =>'0',
                                                  'max'         =>'10'));
        $form_data['dropdown_elements'] = $this->EZ_query->get_type_animation();
        $form_data['form_button_attributes'] = array('name'=>'submit',
                                                     'value'=>'Ajouter',
                                                     'class'=>'btn btn-primary btn-lg');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('header', $data_header);
            $this->load->view('form', $form_data);
            $this->load->view('footer');
        } else {
            $this->EZ_query->insert_animation($this->input->post());
            redirect('index.php/animation');
        }
    }

    public function check_code_animation($code_animation)
    {
        $result = $this->EZ_query->exists_code_animation($code_animation);

        if ($result == TRUE) {
            return TRUE;
        } else {
            $this->form_validation->set_message('check_code_animation', 'Code Animation existe déjà');
            return FALSE;
        }
    }

    public function modify_animation($cd_anim)
    {
        $data_header['title']  = "Animations";
        $data_header['active'] = "Liste Animation";

        $validation_rules = array(array('field' => 'nom_type_anim',
                                        'label' => 'Nom Type Animation',
                                        'rules' => 'trim|required'),
                                  array('field' => 'nom_anim',
                                        'label' => 'Nom Animation',
                                        'rules' => 'trim|required'),
                                  array('field' => 'debut_anim',
                                        'label' => 'Début Animation',
                                        'rules' => 'trim|required'),
                                  array('field' => 'fin_anim',
                                        'label' => 'Fin Animation',
                                        'rules' => 'trim|required'),
                                  array('field' => 'duree_anim',
                                        'label' => 'Durée Animation',
                                        'rules' => 'trim|required'),
                                  array('field' => 'lim_age',
                                        'label' => 'Limite Age',
                                        'rules' => 'trim|required|numeric'),
                                  array('field' => 'tarif_anim',
                                        'label' => 'Tarif Animation',
                                        'rules' => 'trim|required|numeric'),
                                  array('field' => 'nb_places_anim',
                                        'label' => 'Nombre Places Animation',
                                        'rules' => 'trim|required|numeric'),
                                  array('field' => 'desc_anim',
                                        'label' => 'Description Animation'),
                                  array('field' => 'comm_anim',
                                        'label' => 'Commentaires Animation'),
                                  array('field' => 'diff_anim',
                                        'label' => 'Difficulté Animation',
                                        'rules' => 'trim|required|numeric'));

        $this->form_validation->set_rules($validation_rules);
        $this->form_validation->set_error_delimiters('<br>', '</br>');

        $form_data['header_title']    = 'Modifier une animation';
        $form_data['header_subtitle'] = 'Remplissez les champs et validez afin de modifier l\'animation';
        $form_data['destination']     = 'animation/modify_animation/'.$cd_anim;

        $anim = $this->EZ_query->get_one_animation($cd_anim);

        $form_data['form_elements'] = array(array('label'       =>'Code Animation *',
                                                  'name'        =>'cd_anim',
                                                  'value'       =>$anim['CODEANIM'],
                                                  'class'       =>'form-control',
                                                  'required'    =>'required',
                                                  'oninvalid'   =>"setCustomValidity('Veuillez renseigner le code de l\'animation.')",
                                                  'oninput'     =>"setCustomValidity('')",
                                                  'sur_type'    =>'classic',
                                                  'readonly'    =>'true'),
                                            array('label'       =>'Nom Animation *',
                                                  'name'        =>'nom_anim',
                                                  'value'       =>$anim['NOMANIM'],
                                                  'class'       =>'form-control',
                                                  'required'    =>'required',
                                                  'oninvalid'   =>"setCustomValidity('Veuillez renseigner le nom de l\'animation.')",
                                                  'oninput'     =>"setCustomValidity('')",
                                                  'sur_type'    =>'classic',
                                                  'type'        =>'text',
                                                  'maxlength'   =>'40'),
                                            array('label'       =>'Nom Type Animation *',
                                                  'name'        =>'nom_type_anim',
                                                  'set_select'  =>$anim['NOMTYPEANIM'],
                                                  'class'       =>'form-control',
                                                  'required'    =>'required',
                                                  'oninvalid'   =>"setCustomValidity('Veuillez renseigner le nom du type d\'animation.')",
                                                  'oninput'     =>"setCustomValidity('')",
                                                  'sur_type'    =>'dropdown'),
                                            array('label'       =>'Début Animation *',
                                                  'name'        =>'debut_anim',
                                                  'value'       =>date('d-m-Y', strtotime($anim['DATECREATIONANIM'])),
                                                  'class'       =>'form-control',
                                                  'required'    =>'required',
                                                  'oninvalid'   =>"setCustomValidity('Veuillez renseigner la date de début de l\'animation.')",
                                                  'oninput'     =>"setCustomValidity('')",
                                                  'sur_type'    =>'datepicker'),
                                            array('label'       =>'Fin Animation *',
                                                  'name'        =>'fin_anim',
                                                  'value'       =>date('d-m-Y', strtotime($anim['DATEVALIDITEANIM'])),
                                                  'class'       =>'form-control',
                                                  'required'    =>'required',
                                                  'oninvalid'   =>"setCustomValidity('Veuillez renseigner la date de fin l\'animation.')",
                                                  'oninput'     =>"setCustomValidity('')",
                                                  'sur_type'    =>'datepicker'),
                                            array('label'       =>'Durée Animation *',
                                                  'name'        =>'duree_anim',
                                                  'value'       =>$anim['DUREEANIM'],
                                                  'class'       =>'form-control',
                                                  'required'    =>'required',
                                                  'oninvalid'   =>"setCustomValidity('Veuillez renseigner la durée de l\'animation.')",
                                                  'oninput'     =>"setCustomValidity('')",
                                                  'sur_type'    =>'classic',
                                                  'type'        =>'numeric'),
                                            array('label'       =>'Limite d\'Age *',
                                                  'name'        =>'lim_age',
                                                  'value'       =>$anim['LIMITEAGE'],
                                                  'class'       =>'form-control',
                                                  'required'    =>'required',
                                                  'oninvalid'   =>"setCustomValidity('Veuillez renseigner la limite d\'age pour l\'animation.')",
                                                  'oninput'     =>"setCustomValidity('')",
                                                  'sur_type'    =>'classic',
                                                  'min'         =>'0',
                                                  'max'         =>'99'),
                                            array('label'       =>'Tarif Animation *',
                                                  'name'        =>'tarif_anim',
                                                  'value'       =>$anim['TARIFANIM'],
                                                  'class'       =>'form-control',
                                                  'required'    =>'required',
                                                  'oninvalid'   =>"setCustomValidity('Veuillez renseigner le tarif de l\'animation.')",
                                                  'oninput'     =>"setCustomValidity('')",
                                                  'sur_type'    =>'classic',
                                                  'type'        =>'numeric'),
                                            array('label'       =>'Nombre de Places *',
                                                  'name'        =>'nb_places_anim',
                                                  'value'       =>$anim['NBREPLACEANIM'],
                                                  'class'       =>'form-control',
                                                  'required'    =>'required',
                                                  'oninvalid'   =>"setCustomValidity('Veuillez renseigner le nombre de places pour l\'animation.')",
                                                  'oninput'     =>"setCustomValidity('')",
                                                  'sur_type'    =>'classic',
                                                  'type'        =>'numeric',
                                                  'min'         =>'1',
                                                  'max'         =>'99'),
                                            array('label'       =>'Description',
                                                  'name'        =>'desc_anim',
                                                  'value'       =>$anim['DESCRIPTANIM'],
                                                  'class'       =>'form-control',
                                                  'sur_type'    =>'textarea',
                                                  'type'        =>'text',
                                                  'maxlength'   =>'255'),
                                            array('label'       =>'Commentaires',
                                                  'name'        =>'comm_anim',
                                                  'value'       =>$anim['COMMENTANIM'],
                                                  'class'       =>'form-control',
                                                  'sur_type'    =>'textarea',
                                                  'type'        =>'text',
                                                  'maxlength'   =>'255'),
                                            array('label'       =>'Difficulté *',
                                                  'name'        =>'diff_anim',
                                                  'value'       =>$anim['DIFFICULTEANIM'],
                                                  'class'       =>'form-control',
                                                  'required'    =>'required',
                                                  'oninvalid'   =>"setCustomValidity('Veuillez renseigner la difficulté de l\'animation.')",
                                                  'oninput'     =>"setCustomValidity('')",
                                                  'sur_type'    =>'classic',
                                                  'type'        =>'number',
                                                  'min'         =>'0',
                                                  'max'         =>'10'));

        $form_data['dropdown_elements'] = $this->EZ_query->get_type_animation();

        $form_data['form_button_attributes'] = array('name'=>'submit',
                                                     'value'=>'Modifier',
                                                     'class'=>'btn btn-primary btn-lg');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('header', $data_header);
            $this->load->view('form', $form_data);
            $this->load->view('footer');
        } else {
            $this->EZ_query->modify_animation($this->input->post());
            redirect('index.php/animation');
        }
    }

    public function delete_animation($cd_anim)
    {
        $this->EZ_query->delete_animation($cd_anim);
        redirect('index.php/animation');
    }

}
