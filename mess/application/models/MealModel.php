<?php
class MealModel extends CI_Model{
    public function __construct() {
        $this->load->database();
        $this->load->library('calendar');
    }

    public function date() {
        date_default_timezone_set('Asia/Dhaka');
        $date = date('Y-m-d h:i:s');
        return $date;
    }

    public function collectMeal($rows = null) {
        $sql = $this->db->query('select ml.*, mm.name from mess_meal as ml, mess_member as mm WHERE ml.mess_memberid = mm.id and ml.usersid = '.$_SESSION['id'].' order by date desc;');
        return $sql->result();
    }

    public function collectSystem() {
        $sql = $this->db->get_where('system', array('usersid' => $_SESSION['id']));
        return $sql->result();
    }

    public function getLastDate() {
        $sql = $this->db->query('SELECT date FROM mess_meal WHERE usersid = '.$_SESSION['id'].' order by date desc;');
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
                foreach($this->collectSystem() as $row) {
                    $data = array(
                        'mess_memberid'    => $row->mess_memberid,
                        'usersid'           => $row->usersid,
                        'breakfast_meal'    => $row->breakfast_meal,
                        'lunch_meal'        => $row->lunch_meal,
                        'dinner_meal'       => $row->dinner_meal,
                        'date'              => $lastDate,
                        'created_at'        => date('Y-m-'.$lastDate    .' h:i:s')
                    );
                    $sql = $this->db->insert('mess_meal', $data);
                }
            }
            return $sql;
        } else {
            return FALSE;
        }
    }

}