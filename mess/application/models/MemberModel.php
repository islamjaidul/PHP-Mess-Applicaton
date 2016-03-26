<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class MemberModel is for CURD of member
 */
class MemberModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->load->library('session');
        $this->load->model('MessAccountsModel');
        $this->load->model('MealModel');
        $this->load->model('ExpenditureModel');
    }

    private function date() {
        date_default_timezone_set('Asia/Dhaka');
        $date = date('Y-m-d h:i:s');
        return $date;
    }

    /**
     * @createMember method is working for insert data into mess_member table
     */
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

    /**
     *@collectMember method is working for fetching data from mess_member
     *As session id
     */
    public function collectMember($x = null)
    {
        if($x != null) {
            $sql = $this->db->query('select * from mess_member where usersid = '.$_SESSION['id'].' and id = '.$x.';');
        } else {
            $sql = $this->db->query('select * from mess_member where usersid = '.$_SESSION['id'].';');
        }
        return $sql->result();
    }


    public function updateMember() {
        $data = array(
            'name' => $this->input->post('name'),
            'address' => $this->input->post('address'),
            'mobile' => $this->input->post('mobile'),
            'email' => $this->input->post('email'),
            'occupation' => $this->input->post('occupation'),
            'updated_at' => $this->date()
        );

        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $sql = $this->db->update('mess_member', $data);
        return $sql;
    }

    /**
     * @this method belong to delete from 4 table because of foreign key
     * @param $x is the id of member (mess_member table)
     * @return null
     */
    public function deleteMember($x) {
        $system = $this->MealModel->collectSystem($x);
        $range = count($system);
        for($i = 1; $i <= $range; $i++) {
            $sql = $this->db->where('mess_memberid', $x);
            $sql = $this->db->delete('system');
        }

        $meal = $this->MealModel->collectMeal($x);
        $range = count($meal);
        for($i = 1; $i <= $range; $i++) {
            $sql = $this->db->where('mess_memberid', $x);
            $sql = $this->db->delete('mess_meal');
        }

        $expenditure = $this->ExpenditureModel->collectExpenditure($x);
        $range = count($expenditure);
        for($i = 1; $i <= $range; $i++) {
            $sql = $this->db->where('mess_memberid', $x);
            $sql = $this->db->delete('expenditure');
        }

        $accounts = $this->MessAccountsModel->collectMessAccounts($x);
        $range = count($accounts);
        $sql = null;
        for($i = 1; $i <= $range; $i++) {
            $sql = $this->db->where('mess_memberid', $x);
            $sql = $this->db->delete('mess_accounts');
        }

        $sql = $this->db->where('id', $x);
        $sql = $this->db->delete('mess_member');
        return $sql;
    }
}