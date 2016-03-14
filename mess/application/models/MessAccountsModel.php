<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 @MessAccountsModel is for expense account of the mess.
 * Manager will deal with it.
 */
class MessAccountsModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->load->library('session');
        $this->load->model('ReportModel');
    }

    /**
     @collectMember method is for collect member for accounts menu in manager panel
     */
    public function collectMember()
    {
        $sql = $this->db->get_where('mess_member', array('usersid' => $this->session->userdata('id')));
        return $sql->result();
    }

    /**
     @date method is for local time zone
     */
    private function date() {
        date_default_timezone_set('Asia/Dhaka');
        $date = date('Y-m-d h:i:s');
        return $date;
    }

    /**
     * @return an array of mess_member absence id in mess_accounts table
     */
    public function getNullAccountsID() {
        $member = $this->collectMember();
        $accounts = $this->ReportModel->getAccounts();
        $x = 0;
        foreach($member as $row) {
            $member[$x] = $row->id;
            $x++;
        }

        $y = 0;
        foreach($accounts as $rows) {
            foreach($rows as $row) {
                $accounts[$y] = $row->mess_memberid;
            }
            $y++;
        }

        //Insert 0 in mess_accounts table for mess_memberid field to balance with mess_member table
        if(count($accounts) != count($member)) {
            for($i = count($accounts); $i < count($member); $i++) {
                $accounts[$i] = 0;
            }
        }

        //Checking for id which is not match between mess_member and mess_accounts (Field: mess_memberid) table
        $z = 0; $result = array();
        for($i = 0; $i < count($member); $i++) {
            if($member[$i] != $accounts[$i]) {
               $result[$z] = $member[$i];
                $z++;
            }
        }

        return $result;

    }

    public function createNullAccountsID() {
        date_default_timezone_set('Asia/Dhaka');
        $id = $this->getNullAccountsID(); $sql = array();
        if(count($id) != 0) {
            for($i = 0; $i < count($id); $i++) {
                $data = array(
                    'amount' => 0,
                    'mess_memberid' => $id[$i] ,
                    'usersid' => $_SESSION['id'],
                    'month'   => date('m'),
                    'created_at' => $this->date()
                );
                $sql = $this->db->insert('mess_accounts', $data);
            }
            return $sql;
        }
    }

    /**
     @createAccount for inserting data in mess_accounts for purpose of expense
     */
    public function createAccounts() {
        date_default_timezone_set('Asia/Dhaka');
        $data = array(
            'amount' => $this->input->post('amount'),
            'mess_memberid' => $this->input->post('memberid'),
            'usersid' => $_SESSION['id'],
            'month'   => date('m'),
            'created_at' => $this->date()
        );

        $sql = $this->db->insert('mess_accounts', $data);
        return $sql;
    }

    /**
     @collectMessAccounts method is for fetching data fom mess_accounts
     */
    public function collectMessAccounts() {
        $sql = $this->db->query('select a.*, m.name from mess_accounts as a, mess_member as m where a.mess_memberid = m.id and a.month = '.date('m').' and a.usersid = '.$_SESSION['id'].';');
        /*$sql = $this->db->select('amount', 'created_at', 'usersid', 'name')
                        ->from('mess_accounts', 'mess_member')
                        ->join('mess_member', 'mess_member.id = mess_accounts.mess_memberid')
                        ->join('users', 'mess_accounts.usersid = '.$_SESSION['id'].'')
                        ->get();*/
        return $sql->result();
    }
}