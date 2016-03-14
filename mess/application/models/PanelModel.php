<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class PanelModel
 * Description - It is using for create and update the meal of user panel
 */
class PanelModel extends CI_Model {

    public function __construct() {
        $this->load->database();
        $this->load->library('calendar');
    }

    /**
     * @collectMember method
     * @return fetch data from mess_member for selecting member for user
     */
    public function collectMember() {
        $sql = $this->db->get_where('mess_member', array('usersid' => $_SESSION['usersid']));
        return $sql->result();
    }

    /**
     * @date method for local time zone
     * @return bool|string
     */
    public function date() {
        date_default_timezone_set('Asia/Dhaka');
        $date = date('Y-m-d h:i:s');
        return $date;
    }

    /**
     *@collectPanelMember method
     * @return mess_memberid for createPanel method
     */
    public function collectPanelMember() {
        $sql = $this->db->query('SELECT mess_memberid FROM system;');
        return $sql->result();
    }

    /**
     * @createPanel method is for create or update by using
     * @collectPanelMember id
     * @return mixed
     */
    public function createPanel() {
       $x = FALSE;
        foreach($this->collectPanelMember() as $row) {
            if($row->mess_memberid == $this->input->post('member')) {
                $x = TRUE;
                break;
            }
        }
        if($x) {
            date_default_timezone_set('Asia/Dhaka');
            $data = array(
                'mess_memberid'         => $this->input->post('member'),
                'usersid'               => $_SESSION['usersid'],
                'breakfast_meal'        => $this->input->post('breakfast_meal'),
                'lunch_meal'            => $this->input->post('lunch_meal'),
                'dinner_meal'           => $this->input->post('dinner_meal'),
                'date'                  => date("d"),
                'updated_at'            => $this->date()
            );
            $sql = $this->db->where('mess_memberid', $this->input->post('member'))
                            ->update('system', $data);
            return $sql;
        } else {
            date_default_timezone_set('Asia/Dhaka');
            $data = array(
                'mess_memberid'         => $this->input->post('member'),
                'usersid'               => $_SESSION['usersid'],
                'breakfast_meal'        => $this->input->post('breakfast_meal'),
                'lunch_meal'            => $this->input->post('lunch_meal'),
                'dinner_meal'           => $this->input->post('dinner_meal'),
                'date'                  => date("d"),
                'created_at'            => $this->date()
            );
            $sql = $this->db->insert('system', $data);
            return $sql;
        }

    }
}