<?php

class MemberModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->load->library('session');
    }
    private function date() {
        date_default_timezone_set('Asia/Dhaka');
        $date = date('Y-m-d h:i:s');
        return $date;
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
            'created_at' => $this->date()
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