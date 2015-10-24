<?php

class MemberModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->load->library('session');
    }

    public function createMember()
    {
        $data = array(
            'name' => $this->input->post('name'),
            'address' => $this->input->post('address'),
            'mobile' => $this->input->post('mobile'),
            'email' => $this->input->post('email'),
            'occupation' => $this->input->post('occupation'),
            'usersid' => $this->session->userdata('id'),
            'created_at' => date("Y-m-d h:m:s")
        );
        $sql = $this->db->insert('mess_member', $data);
        return $sql;
    }

    public function collectMember()
    {
        $sql = $this->db->get_where('mess_member', array('usersid' => $this->session->userdata('id')));
        return $sql->result();
    }
}