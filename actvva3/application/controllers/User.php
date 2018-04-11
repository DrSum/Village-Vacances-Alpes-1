<?php
class User extends CI_Controller {
    private $user_name
    private $first_name;
    private $last_name;
    private $type;
    private $no;

    function __construct(){
        parent::__construct();
    }

    public function __get($property) {
        if ($property === 'user_name') {
            return $user_name;
        }
        else if ($property === 'first_name') {
            return $first_name;
        }
        else if ($property === 'last_name') {
            return $last_name;
        }
        else if ($property === 'type') {
            return $type;
        }
        else if ($property === 'no') {
            return $no;
        }
        else {
            throw new Exception("Propriété invalide !");
        }
    }

    public function __set($property,$value) {
        if ($property === 'user_name') {
            $this->user_name = $value;
        }
        else if ($property === 'first_name'){
            $this->first_name = $value;
        }
        else if ($property === 'last_name'){
            $this->last_name = $value;
        }
        else if ($property === 'type'){
            $this->type = $value;
        }
        else if ($property === 'no'){
            $this->no = $value;
        }
    }

}
?>
