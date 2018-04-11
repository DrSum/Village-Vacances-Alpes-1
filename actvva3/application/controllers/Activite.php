<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activite extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('EZ_query');
        $this->load->helper('form', 'url');
        $this->load->library('form_validation');
    }

    public function index($cd_anim = null) {
        if ($this->session->type == 'en') {
            $data_header['title']  = "Activites";
            $data_header['active'] = "Activité";

            $data['header_title'] = "Activités";
            $data['header_subtitle'] = "";
            $data['retour'] = FALSE;
            $activites;

            $this->load->view('header', $data_header);

            if (is_null($cd_anim))
            {
                $data['header_subtitle'] = "Calendrier des activités.";

                $activites = $this->EZ_query->get_activites();
                $data['events'] = $this->array_to_json($activites);
                $data['planning'] = $this->EZ_query->get_my_planning($this->session->no);
                $data['encadrants'] = $this->EZ_query->get_encadrants();
                $this->load->view('calendar_common',$data);
            } else {
                $data['retour'] = TRUE;
                $anim = $this->EZ_query->get_one_animation($cd_anim);

                $data['header_subtitle'] = "Calendrier des activités concernant <u>".$anim['NOMANIM'].'</u>.  </br>'."Ajoutez, modifiez ou supprimer des activités ici.";
                $data['anim'] = $anim;

                $activites = $this->EZ_query->get_activites($cd_anim);
                $data['events'] = $this->array_to_json($activites);
                $this->load->view('calendar_static', $data);
            }
        } elseif ($this->session->type == 'lo') {
            if (is_null($cd_anim)) {
                $data_header['title']  = "Activites";
                $data_header['active'] = "Planning";
                $this->load->view('header', $data_header);

                $data['header_title'] = "Activités";
                $data['header_subtitle'] = "Votre Calendrier des activités";
                $data['events'] = $this->array_to_json($this->EZ_query->get_registered_activites($this->session->no));
                $this->load->view('read_only_calendar',$data);
            } else {
                //CHECK PERSON DATA -> AGE
                $anim = $this->EZ_query->get_one_animation($cd_anim);
                if($this->session->age >= $anim['LIMITEAGE']) {
                    $data_header['title']  = "Activites";
                    $data_header['active'] = "Liste Animations";
                    $this->load->view('header', $data_header);

                    $data['header_title'] = "Activités";
                    $data['header_subtitle'] = "Inscrivez vous aux ativités qui vous plaisent.";
                    $data['events'] = $this->array_to_json($this->EZ_query->get_future_activites($cd_anim));
                    $this->load->view('read_only_calendar2',$data);
                } else {

                }

            }
        }
        $this->load->view('footer');
    }

    public function array_to_json($old_array){
        $newarray = array();
        for($i = 0; $i< count($old_array); $i++) {
            if($old_array[$i]['CODEETATACT'] == '1') {
                $newarray[$i] = array('id'      => $old_array[$i]['CODEANIM'].' '.$old_array[$i]['DATEACT'],
                                      'title'   => $old_array[$i]['CODEANIM'],
                                      'nom'     => $old_array[$i]['NOMANIM'],
                                      'start'   => $old_array[$i]['DATEACT'].'T'.$old_array[$i]['HRRDVACT'],
                                      'end'     => $old_array[$i]['DATEACT'].'T'.$old_array[$i]['HRFINACT'],
                                      'color'   => 'green',
                                      'responsable'=> $old_array[$i]['NOENCADRANT']);
            } elseif ($old_array[$i]['CODEETATACT'] == '2') {
                $newarray[$i] = array('id'      => $old_array[$i]['CODEANIM'].' '.$old_array[$i]['DATEACT'],
                                      'title'   => $old_array[$i]['CODEANIM'],
                                      'nom'     => $old_array[$i]['NOMANIM'],
                                      'start'   => $old_array[$i]['DATEACT'].'T'.$old_array[$i]['HRRDVACT'],
                                      'end'     => $old_array[$i]['DATEACT'].'T'.$old_array[$i]['HRFINACT'],
                                      'color'   => 'red',
                                      'responsable'=> $old_array[$i]['NOENCADRANT']);
            }
        }
        return json_encode($newarray);
    }

    public function add_activite() {
        if ($this->session->type == 'en') {
            $id    = $this->get_id();

            $datetime_start = strtotime($_POST['start']);
            $datetime_end   = strtotime($_POST['end']);

            $date   = date('Y-m-d', $datetime_start);
            $start  = date('H:i:s', $datetime_start);
            $end    = date('H:i:s', $datetime_end);

            $anim = $this->EZ_query->get_one_animation($id);
            if($anim["DATECREATIONANIM"] <= $date && $anim["DATEVALIDITEANIM"] >= $date) {
                $this->EZ_query->insert_activite($id, $date, $start, $end, $this->session->userdata('no'), $this->EZ_query->get_one_animation($id)['TARIFANIM']);
                $this->EZ_query->add_planning($id, $date, $this->session->userdata('no'));
            } else {
                echo "Les dates de l'activité doivent être comprises entre le ".date('d-m-Y', strtotime($anim["DATECREATIONANIM"]))." et le ".date('d-m-Y', strtotime($anim["DATEVALIDITEANIM"])).".";
            }
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function modify_activite() {
        if ($this->session->type == 'en') {
            $id    = $this->get_id();
            $origin = $this->get_date();

            $datetime_start = strtotime($_POST['start']);
            $datetime_end   = strtotime($_POST['end']);

            $date   = date('Y-m-d', $datetime_start);
            $start  = date('H:i:s', $datetime_start);
            $end    = date('H:i:s', $datetime_end);

            $this->EZ_query->modify_activite($id, $date, $start, $end, $origin);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function delete_activite() {
        if ($this->session->type == 'en') {
            $id     = $this->get_id();
            $date   = $this->get_date();

            $this->EZ_query->delete_activite($date, $id);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function cancel_activite() {
        if ($this->session->type == 'en') {
            $id     = $this->get_id();
            $date   = $this->get_date();

            $this->EZ_query->cancel_activite($id, $date);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function get_id() {
        return explode(" ", $_POST['id'])[0];
    }

    public function get_date() {
        return explode(" ", $_POST['id'])[1];
    }

    public function planning_encadrants() {
        if ($this->session->type == 'en') {
            $id = $this->input->post("id");
            $date = $this->input->post("date");

            $encadrants = $this->input->post($id.'_'.$date.'_encadrants[]');
            $this->EZ_query->delete_encadrants_planning($id, $date);

            if ($encadrants != null) {
                foreach ($encadrants as $key => $no) {
                    $this->EZ_query->add_planning($id, $date, $no);
                }
            }
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function count_participants() {
        $result = $this->EZ_query->count_participants($this->input->post("id"), $this->input->post("date"));
        if (isset($result["NBPARTICIPANTS"])){
            echo $result["NBPARTICIPANTS"];
        } else {
            echo "0";
        }
    }

    public function list_participants() {
        if ($this->session->type == 'en') {
            $result = $this->EZ_query->get_participants($this->input->post("id"), $this->input->post("date"));
            if (isset($result)){
                echo json_encode($result);
            }
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function change_etat_activite() {
        if ($this->session->type == 'en') {
            $this->EZ_query->activate_activite($this->input->post("id"), $this->input->post("date"), $this->input->post("activate"));
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function get_etat_activite() {
        if ($this->session->type == 'en') {
            $activite = $this->EZ_query->get_one_activite($this->input->post("date"), $this->input->post("id"));
            echo $activite['CODEETATACT'];
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function register_activite() {
        if ($this->session->type == 'lo') {

            $id = $this->input->post("id");
            $date = $this->input->post("date");

            //check dates
            if ($date >= $this->session->date_debut && $date <= $this->session->date_fin)
            {
                //check ids
                $empty_array_or_not = $this->EZ_query->check_no_inscription($id, $date, $this->session->no);
                if (empty($empty_array_or_not["NOINSCRIP"])) {

                    //check room
                    $anim = $this->EZ_query->get_one_animation($id);
                    $nb_participants = $this->EZ_query->count_participants($this->input->post("id"), $this->input->post("date"));
                    if($nb_participants["NBPARTICIPANTS"] < $anim["NBREPLACEANIM"]) {

                        $no = $this->EZ_query->get_next_no_incription()["NOINSCRIP"];
                        $this->EZ_query->register_activite($id, $no, $date, $this->session->no);
                        echo "Inscription enregistrée!";
                    } else {
                        echo "Aucune place disponible";
                    }
                } else {
                    echo "Vous êtes déjà inscrits!";
                }
            } else {
                echo "Vous n'êtes plus en vacances!";
            }

        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function unregister_activite() {
        if ($this->session->type == 'lo') {
            $this->EZ_query->unregister_activite($this->input->post("id"), $this->input->post("date"), $this->session->no);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function details_activite() {
        $details = $this->EZ_query->get_one_activite($this->input->post("date"), $this->input->post("id"));

        foreach ($details as $key => $value) {
            switch ($key) {
                case "CODEANIM":
                case "DATEACT":
                case "NOENCADRANT":
                case "CODEETATACT":
                case "DATEANNULATIONACT":
                    unset($details[$key]);
                    break;
                case "PRIXACT":
                    $details["Prix"] = $value."€";
                    unset($details[$key]);
                    break;
                case "HRRDVACT":
                    $details["Heure de rendez-vous"] = date('H:i:s', strtotime($value));
                    unset($details[$key]);
                    break;
                case "HRDEBUTACT":
                    $details["Début"] = date('H:i:s', strtotime($value));
                    unset($details[$key]);
                    break;
                case "HRFINACT":
                    $details["Fin"] = date('H:i:s', strtotime($value));
                    unset($details[$key]);
                    break;
                case "OBJECTIFACT":
                    $details["Objectif"] = $value;
                    unset($details[$key]);
                    break;
            }
        }

        $additional_details = $this->EZ_query->get_one_animation($this->input->post("id"));
        foreach ($additional_details as $key => $value) {
            switch ($key) {
                case "DIFFICULTEANIM":
                    $details["Difficulté"] = $value."/5";
                    break;
                case "LIMITEAGE":
                    $details["Limite d'age"] = $value;
                    break;
                case "NBREPLACEANIM":
                    $nb_participants = $this->EZ_query->count_participants($this->input->post("id"), $this->input->post("date"));
                    $places_libres = $value - $nb_participants["NBPARTICIPANTS"];
                    $details["Nombre de places"] = $places_libres." places libres sur ". $value . " au total";
                    break;
                case "DESCRIPTANIM":
                    $details["Description"] = $value;
                    break;
                case "COMMENTANIM":
                    $details["Commentaires"] = $value;
                    break;
            }
        }


        echo json_encode($details);
    }

    public function encadrants_participants()
    {
        $encadrants = $this->EZ_query->get_encadrants_on_activite($this->input->post("id"), $this->input->post("date"));
        $responsable = $this->EZ_query->get_responsable_activite($this->input->post("id"), $this->input->post("date"));

        foreach($encadrants as $key => $value){
            if ($encadrants[$key]['NOENCADRANT'] == $responsable['NOENCADRANT']) {
                $encadrants[$key]["RESPONSABLE"] = "true";
            }
        }
        echo json_encode($encadrants);
    }

    public function check_age()
    {
        $anim = $this->EZ_query->get_one_animation($this->input->post('cd'));
        if($this->session->age >= $anim['LIMITEAGE']) {
            echo json_encode("true");
        } else {
            echo json_encode("Il faut avoir au minimum ".$anim['LIMITEAGE']." ans afin de participer a cette animation");
        }
    }
}
