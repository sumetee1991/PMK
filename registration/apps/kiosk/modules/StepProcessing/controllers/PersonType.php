<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PersonType extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Md_PersonType');
    }

    public function Discard_queue()
    {


        $result = $this->Md_PersonType->update_queue();
        echo json_encode($result);
    }

    public function Get_Worklist()
    {

        $result = $this->Md_PersonType->getworklist();
        echo json_encode($result);
    }

    public function Get_persontype()
    {
        $result = $this->Md_PersonType->getpersontype();
        echo json_encode($result);
    }

    public function Get_payor()
    {
        $result = $this->Md_PersonType->getpayor();
        echo json_encode($result);
    }
}
