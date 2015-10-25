<?php

class MessAccountsModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->load->library('session');
    }

    public function collectMember()
    {
        $sql = $this->db->get_where('mess_member', array('usersid' => $this->session->userdata('id')));
        return $sql->result();
    }
    private function date() {
        date_default_timezone_set('Asia/Dhaka');
        $date = date('Y-m-d h:i:s');
        return $date;
    }
    public function createAccounts() {
        date_default_timezone_set("America/New_York");
        $data = array(
            'amount' => $this->input->post('amount'),
            'mess_memberid' => $this->input->post('memberid'),
            'usersid' => $_SESSION['id'],
            'created_at' => $this->date()
        );

        $sql = $this->db->insert('mess_accounts', $data);
        return $sql;
    }

    public function collectMessAccounts() {
        $sql = $this->db->query('select a.*, m.name from mess_accounts as a, mess_member as m where a.mess_memberid = m.id and a.usersid = '.$_SESSION['id'].';');
        /*$sql = $this->db->select('amount', 'created_at', 'usersid', 'name')
                        ->from('mess_accounts', 'mess_member')
                        ->join('mess_member', 'mess_member.id = mess_accounts.mess_memberid')
                        ->join('users', 'mess_accounts.usersid = '.$_SESSION['id'].'')
                        ->get();*/
        return $sql->result();
    }
}