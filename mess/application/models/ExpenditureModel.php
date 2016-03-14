<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class ExpenditureModel is for expense of the manager panel
 */
class ExpenditureModel extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    public function date() {
        date_default_timezone_set('Asia/Dhaka');
        $date = date('Y-m-d h:i:s');
        return $date;
    }

    /**
     @collectMember method is for collect member with session id
     */
    public function collectMember() {
        $sql = $this->db->get_where('mess_member', array('usersid' => $_SESSION['id']));
        return $sql->result();
    }


    /**
     @createExpenditure method is for insert expenditure in database
     */
    public function createExpenditure() {
        $data = array(
            'mess_memberid'     => $this->input->post('mess_memberid'),
            'expense_amount'    => $this->input->post('expense_amount'),
            'shopping'          => $this->input->post('shopping'),
            'usersid'           => $_SESSION['id'],
            'month'             => date('m'),
            'created_at'        => $this->date()
        );

        $sql = $this->db->insert('expenditure', $data);
        return $sql;
    }

    /**
     @collectExpenditure method is for fetching data from expenditure table
     */
    public function collectExpenditure() {
        $sql = $this->db->query('select m.name, e.id, e.expense_amount, e.created_at, e.usersid, e.shopping, e.month from expenditure as e, mess_member as m where e.mess_memberid = m.id and e.month = '.date('m').' and e.usersid = '.$_SESSION['id'].';');
        /*$sql = $this->db->select('name', 'expense_amount', 'created_at', 'usersid', 'shopping')
                        ->from('expenditure', 'mess_member')
                        ->join('mess_member', 'expenditure.mess_memberid = mess_member.id')
                        ->where('expenditure.usersid', $_SESSION['id'])
                        ->get();*/
        return $sql->result();
    }
}