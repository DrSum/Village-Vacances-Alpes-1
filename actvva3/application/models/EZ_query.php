<?php
class EZ_query extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function exists_user($usr, $pwd)
    {
        $sql = "SELECT *
        FROM PROFIL P
        WHERE USER = '$usr'
        AND MDP = '$pwd'";

        $query = $this->db->query($sql);

        if ($query->num_rows() == 1) {
            return TRUE;
        }
        return FALSE;
    }

    public function exists_type_animation($code)
    {
        $sql = "SELECT CODETYPEANIM, NOMTYPEANIM
        FROM type_anim
        WHERE CODETYPEANIM = '$code'";

        $query = $this->db->query($sql);

        if ($query->num_rows() == 1) {
            return TRUE;
        }
        return FALSE;
    }

    public function get_user_details($usr, $pwd)
    {
        $sql = "SELECT *
        FROM PROFIL P
        WHERE USER = '$usr'
        AND MDP = '$pwd'";

        return $this->db->query($sql);
    }

    public function get_encadrant($usr)
    {
        $query = "SELECT *
        FROM ENCADRANT E, PROFIL P
        WHERE P.USER = E.USER
        AND P.USER = '$usr'";

        return $this->db->query($query);
    }

    public function get_encadrants()
    {
        $sql = "SELECT *
                FROM ENCADRANT";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_loisant($usr)
    {
        $query = "SELECT *
        FROM LOISANT L, PROFIL P
        WHERE P.USER = L.USER
        AND P.USER = '$usr'";

        return $this->db->query($query);
    }

    public function get_type_animation()
    {
        $sql = "SELECT CODETYPEANIM, NOMTYPEANIM
        FROM type_anim";

        $query = $this->db->query($sql);
        return $query->result_array();
    }



    public function insert_animation($form_values)
    {
        $form_values['debut_anim'] = date('Y-m-d', strtotime($form_values['debut_anim']));
        $form_values['fin_anim'] = date('Y-m-d', strtotime($form_values['fin_anim']));

        $sql = "INSERT INTO Animation
        VALUES ('$form_values[cd_anim]',
            '$form_values[nom_type_anim]',
            '$form_values[nom_anim]',
            '$form_values[debut_anim]',
            '$form_values[fin_anim]',
            '$form_values[duree_anim]',
            '$form_values[lim_age]',
            '$form_values[tarif_anim]',
            '$form_values[nb_places_anim]',
            '$form_values[desc_anim]',
            '$form_values[comm_anim]',
            '$form_values[diff_anim]')";

            $this->db->query($sql);
        }

        public function exists_code_animation($code)
        {
            $sql = "SELECT CODEANIM
            FROM Animation
            WHERE CODEANIM = '$code'";

            $query = $this->db->query($sql);

            if ($query->num_rows() == 1) {
                return FALSE;
            } else {
                return TRUE;
            }
        }

        public function get_animations()
        {
            $sql = "SELECT *
            FROM Animation a, Type_Anim t
            WHERE a.CODETYPEANIM = t.CODETYPEANIM";

            $query = $this->db->query($sql);

            return $query->result();
        }

        public function get_animations_array()
        {
            $sql = "SELECT *
            FROM Animation a, Type_Anim t
            WHERE a.CODETYPEANIM = t.CODETYPEANIM";

            $query = $this->db->query($sql);

            return $query->result_array();
        }

        public function get_future_animations()
        {
            $sql = "SELECT *
            FROM Animation a, Type_Anim t
            WHERE a.CODETYPEANIM = t.CODETYPEANIM
            AND DATECREATIONANIM < CURDATE()
            AND DATEVALIDITEANIM > CURDATE()";

            $query = $this->db->query($sql);

            return $query->result_array();
        }

        public function get_one_animation($code_anim)
        {
            $sql = "SELECT *
            FROM Animation a, Type_Anim t
            WHERE a.CODETYPEANIM = t.CODETYPEANIM
            AND CODEANIM = '".$code_anim."'";

            $query = $this->db->query($sql);
            $result = $query->row_array();
            return $result;
        }

        public function modify_animation($form_values)
        {
            $form_values['debut_anim'] = date('Y-m-d', strtotime($form_values['debut_anim']));
            $form_values['fin_anim'] = date('Y-m-d', strtotime($form_values['fin_anim']));

            $array = array('COMMENTANIM'      => $form_values['comm_anim'],
            'DATECREATIONANIM' => $form_values['debut_anim'],
            'DATEVALIDITEANIM' => $form_values['fin_anim'],
            'DESCRIPTANIM'     => $form_values['desc_anim'],
            'DIFFICULTEANIM'   => $form_values['diff_anim'],
            'DUREEANIM'        => $form_values['duree_anim'],
            'LIMITEAGE'        => $form_values['lim_age'],
            'NBREPLACEANIM'    => $form_values['nb_places_anim'],
            'NOMANIM'          => $form_values['nom_anim'],
            'TARIFANIM'        => $form_values['tarif_anim']);
            $this->db->where('CODEANIM', $form_values['cd_anim']);
            $this->db->update('animation', $array);
        }

        public function delete_animation($cd)
        {
            foreach ($this->get_activites($cd) as $activite)
            {
                $this->delete_activite($activite['DATEACT'], $cd);
            }

            $this->db->where('CODEANIM', $cd);
            $this->db->delete('Animation');
        }

        public function insert_categorie_animation($code, $nom)
        {
            $query = "INSERT INTO TYPE_ANIM (CODETYPEANIM, NOMTYPEANIM)
            VALUE ('$code', '$nom')";

            if(!$this->db->query($query)) {
                $this->db->_error_message();
                $this->db->_error_number();
            }
        }

        public function insert_activite($cd, $date, $start, $end, $no_encadrant, $prix)
        {
            $hr_debut = date('H:i:s', strtotime('+30 minutes', strtotime($start)));

            $sql = "INSERT INTO activite (codeanim, dateact, noencadrant, codeetatact, HRRDVACT, HRDEBUTACT, HRFINACT, PRIXACT)
            VALUES ('$cd', '$date', '$no_encadrant', '1', '$start', '$hr_debut', '$end', '$prix')";
            $this->db->query($sql);
        }

        public function get_etat_activite()
        {
            $sql = "SELECT *
            FROM ETAT_ACT";

            $query = $this->db->query($sql);

            return $query->result_array();
        }

        public function get_activites($code = NULL)
        {
            if (is_null($code)) {
                $sql = "SELECT *
                FROM Activite ac, Animation an
                WHERE ac.CODEANIM = an.CODEANIM";
            } else {
                $sql = "SELECT *
                FROM Activite ac, Animation an
                WHERE ac.CODEANIM = an.CODEANIM
                AND ac.CODEANIM = '$code'";
            }

            $query = $this->db->query($sql);

            return $query->result_array();
        }

        public function get_future_activites($cd)
        {
            $sql = "SELECT *
                    FROM Activite ac, Animation an
                    WHERE ac.CODEANIM = an.CODEANIM
                    AND ac.CODEANIM = '$cd'
                    AND ac.DATEACT >= CURDATE()";

            $query = $this->db->query($sql);

            return $query->result_array();
        }

        public function get_one_activite($date, $code)
        {
            $sql = "SELECT *
                    FROM Activite
                    WHERE DATEACT = '$date'
                    AND CODEANIM = '$code'";

            $query = $this->db->query($sql);
            $result = $query->row_array();
            return $result;
        }

        public function exists_date_activite($date_activite, $anim)
        {
            $sql = "SELECT *
            FROM Activite ac, Animation an
            WHERE ac.DATEACT = '$date_activite'
            AND ac.CODEANIM = '$anim'
            AND ac.CODEANIM = an.CODEANIM";

            $query = $this->db->query($sql);

            if ($query->num_rows() == 1) {
                return FALSE;
            } else {
                return TRUE;
            }
        }

        public function delete_activite($date, $code)
        {
            $this->db->where('DATEACT', $date);
            $this->db->where('CODEANIM', $code);
            $this->db->delete('Activite');
        }

        public function modify_activite($cd, $date, $start, $end, $origin)
        {
            $hr_debut = date('H:i:s', strtotime('+30 minutes', strtotime($start)));

            $sql = "UPDATE ACTIVITE
                    SET DATEACT = '$date', HRRDVACT = '$start', HRFINACT = '$end', HRDEBUTACT = '$hr_debut'
                    WHERE CODEANIM = '$cd'
                    AND DATEACT = '$origin'";

            $this->db->query($sql);
        }

        public function get_array_encadrants()
        {
            $sql = "SELECT *
                    FROM encadrant";

            $query = $this->db->query($sql);

            return $query->result_array();
        }

        public function delete_encadrants_planning($cd, $date)
        {
            $sql = "DELETE FROM PLANNING
                    WHERE CODEANIM = '$cd'
                    AND DATEACT = '$date'";

            $this->db->query($sql);
        }

        public function add_planning($cd, $date, $no)
        {
            $sql = "INSERT INTO PLANNING
                    VALUES('$no', '$cd', '$date')";

            $this->db->query($sql);
        }

        public function get_my_planning($no)
        {
            $sql = "SELECT *
                    FROM PLANNING
                    WHERE NOENCADRANT = '$no'";

            $query = $this->db->query($sql);

            return $query->result_array();
        }

        public function get_encadrants_on_activite($cd, $date)
        {
            $sql = "SELECT e.NOENCADRANT, NOMENCADRANT, PRENOMENCADRANT
                    FROM ENCADRANT e, PLANNING p
                    WHERE p.NOENCADRANT = e.NOENCADRANT
                    AND p.CODEANIM = '$cd'
                    AND p.DATEACT = '$date'";

            $query = $this->db->query($sql);

            return $query->result_array();
        }

        public function get_responsable_activite($cd, $date)
        {
            $sql = "SELECT e.NOENCADRANT, NOMENCADRANT, PRENOMENCADRANT
                    FROM ENCADRANT e, ACTIVITE a
                    WHERE a.NOENCADRANT = e.NOENCADRANT
                    AND a.CODEANIM = '$cd'
                    AND a.DATEACT = '$date'";

            $query = $this->db->query($sql);

            return $query->row_array();
        }

        public function count_participants($cd, $date)
        {
            $sql = "SELECT COUNT(*) AS NBPARTICIPANTS
                    FROM inscription
                    WHERE CODEANIM = '$cd'
                    AND DATEACT = '$date'
                    AND (DATE_ANNULATION is null
                    OR DATE_ANNULATION = '0000-00-00')";

            $query = $this->db->query($sql);

            return $query->row_array();
        }

        public function get_participants($cd, $date)
        {
            $sql = "SELECT NOMLOISANT, PRENOMLOISANT
                    FROM LOISANT l, INSCRIPTION i
                    WHERE CODEANIM = '$cd'
                    AND DATEACT = '$date'
                    AND l.NOLOISANT = i.NOLOISANT
                    AND DATE_ANNULATION IS null";

            $query = $this->db->query($sql);

            return $query->result();
        }

        public function activate_activite($cd, $date, $etat)
        {
            $cancel_date = null;
            if ($etat == "1") {
                $etat = 2;
                $cancel_date = date('Y-m-d');
            } else {
                $etat = 1;
            }

            $sql = "UPDATE ACTIVITE
                    SET codeetatact = '$etat', DATEANNULATIONACT = '$cancel_date'
                    WHERE CODEANIM = '$cd'
                    AND DATEACT = '$date'";

            $this->db->query($sql);
        }

        public function get_planning_activite($cd, $date)
        {
            $sql = "SELECT *
                    FROM PLANNING
                    WHERE CODEANIM = '$cd'
                    AND DATEACT = '$date'";

            $query = $this->db->query($sql);

            return $query->result_array();
        }

        public function get_registered_activites($no)
        {
            $sql = "SELECT *
                    FROM ACTIVITE a, INSCRIPTION i, Animation an
                    WHERE i.CODEANIM = a.CODEANIM
                    AND i.DATEACT = a.DATEACT
                    AND a.CODEANIM = an.CODEANIM
                    AND a.CODEANIM = i.CODEANIM
                    AND NOLOISANT = '$no'
                    AND (DATEANNULATIONACT is null
                    OR DATEANNULATIONACT = '0000-00-00')
                    AND (DATE_ANNULATION is null
                    OR DATE_ANNULATION = '0000-00-00')";

            $query = $this->db->query($sql);

            return $query->result_array();
        }

        public function unregister_activite($cd, $date, $no)
        {
            $cancel_date = date('Y-m-d');

            $sql = "UPDATE INSCRIPTION
                    SET DATE_ANNULATION = '$cancel_date'
                    WHERE CODEANIM = '$cd'
                    AND DATEACT = '$date'
                    AND NOLOISANT = '$no'";

            $this->db->query($sql);
        }

        public function register_activite($cd, $inscrip_no, $date, $no)
        {
            $inscription_date = date('Y-m-d');

            $sql = "INSERT INTO INSCRIPTION
                    VALUES ('$no', '$inscrip_no', '$cd', '$date', '$inscription_date', '', '')";

            $this->db->query($sql);
        }

        public function check_no_inscription($cd, $date, $no)
        {
            $sql = "SELECT NOINSCRIP
                    FROM INSCRIPTION
                    WHERE NOLOISANT = '$no'
                    AND CODEANIM = '$cd'
                    AND DATEACT = '$date'
                    AND (DATE_ANNULATION is null
                    OR DATE_ANNULATION = '0000-00-00')";

            $query = $this->db->query($sql);

            return $query->row_array();
        }

        public function get_next_no_incription()
        {
            $sql = "SELECT MAX(NOINSCRIP)+1 AS NOINSCRIP
                    FROM INSCRIPTION";

            $query = $this->db->query($sql);

            return $query->row_array();
        }
    }
?>
