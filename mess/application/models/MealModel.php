<?php
class MealModel extends CI_Model{
    public function __construct() {
        $this->load->database();
        $this->load->library('calendar');
    }

    public function data() {
        date_default_timezone_set('Asia/Dhaka');
        $date = date('Y-m-d h:i:s');
        return $date;
    }

    public function collectMember() {
        $sql = $this->db->get_where('mess_member', array('usersid' => $_SESSION['id']));
        return $sql->result();
    }

    public function getLastDate() {
        $sql = $this->db->query('SELECT date FROM mess_meal ORDER by id DESC;');
        foreach($sql->result() as $row) {
            return $row->date;
        }
    }

    public function createMeal() {
        date_default_timezone_set('Asia/Dhaka');
        $month =  date('m');
        $year = date('Y');
        $day = date('d');
        $lastDate = $this->getLastDate();
        $total =  $this->calendar->get_total_days($month, $year);

        if($this->getLastDate() < $day) {
            for($i = $lastDate; $i < $day; $i++) {
                $lastDate++;
                $data = array(
                    'breakfast_meal' => 1,
                    'lunch_meal' => 1,
                    'dinner_meal' => 1,
                    'date' => $lastDate
                );
                $sql = $this->db->insert('mess_meal', $data);
            }
            return $sql;
        } else {
            return FALSE;
        }
    }

}