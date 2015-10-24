<?php

class MessAccountsModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function collectMember()
    {
        $sql = $this->db->get('mess_member');
        return $sql->result();
    }
}