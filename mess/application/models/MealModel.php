<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class MealModel is for insert meal in mess_meal table
 * by using system table information
 */
class MealModel extends CI_Model
{
    public function __construct() {
        $this->load->database();
        $this->load->library('calendar');
    }
    /**
     * @date method
     * Local Time zone
     */
    public function date() {
        date_default_timezone_set('Asia/Dhaka');
        $date = date('Y-m-d h:i:s');
        return $date;
    }

    /**
     * @collectSystem method working for fetch data from system table
     * For the purpose of automatic insert in mess_meal table
     */

    public function collectSystem($x = null) {
        if($x != null) {
            $sql = $this->db->query('select s.*, m.name from system as s, mess_member as m where s.mess_memberid = m.id and s.usersid = '.$_SESSION['id'].' and s.mess_memberid = '.$x.';');
        } else {
            $sql = $this->db->query('select s.*, m.name from system as s, mess_member as m where s.mess_memberid = m.id and s.usersid = '.$_SESSION['id'].';');
        }
        return $sql->result();
    }
    /**
     *@getLastDate method working for fetch last date from the mess_meal table.
     * This method fetching data for session userid data
     */
    public function getLastDate() {
        $sql = $this->db->query('SELECT date FROM mess_meal WHERE usersid = '.$_SESSION['id'].' order by id desc;');
        foreach($sql->result() as $row) {
            return (int)$row->date;
        }
    }

    /**
     * getLastMonth method
     * @return last month
     */
    public function getLastMonth() {
        $sql = $this->db->query('SELECT created_at FROM mess_meal WHERE usersid = '.$_SESSION['id'].' order by id desc;');
        foreach($sql->result() as $row) {
            $x = explode('-', $row->created_at);
            return (int)$x[1];
        }
    }

    /**
     * getLastYear method
     * @return last year
     */
    public function getLastYear() {
        $sql = $this->db->query('SELECT created_at FROM mess_meal WHERE usersid = '.$_SESSION['id'].' order by id desc;');
        foreach($sql->result() as $row) {
            $x = explode('-', $row->created_at);
            return (int)$x[0];
        }
    }

    /**
     * @createMeal method is used for create meal automatically.
     * Insert data depends on the collecSystem method
     */
    public function createMeal() {
        date_default_timezone_set('Asia/Dhaka');
        $month =  (int)date('m');
        $year = (int)date('Y');
        $day = (int)date('d');
        $lastDate = $this->getLastDate();
        $total =  (int)$this->calendar->get_total_days($month, $year);
        if($this->getLastDate() < $day) {
            $sql = null;
            for($i = $lastDate; $i < $day-1; $i++) {
                $lastDate++;
                foreach($this->collectSystem() as $row) {
                    $data = array(
                        'mess_memberid'    => $row->mess_memberid,
                        'usersid'           => $row->usersid,
                        'breakfast_meal'    => $row->breakfast_meal,
                        'lunch_meal'        => $row->lunch_meal,
                        'dinner_meal'       => $row->dinner_meal,
                        'date'              => $lastDate,
                        'month'             => $month,
                        'created_at'        => date('Y-m-'.$lastDate.' h:i:s')
                    );
                    $sql = $this->db->insert('mess_meal', $data);
                }
            }
            return $sql;
        } else if($this->getLastMonth() < $month) {
            $sql = null;
            $lastDate = $day;
            for($i = $day; $i <= $day; $i++) {
                foreach($this->collectSystem() as $row) {
                    $data = array(
                        'mess_memberid'    => $row->mess_memberid,
                        'usersid'           => $row->usersid,
                        'breakfast_meal'    => $row->breakfast_meal,
                        'lunch_meal'        => $row->lunch_meal,
                        'dinner_meal'       => $row->dinner_meal,
                        'date'              => $lastDate,
                        'month'             => $month,
                        'created_at'        => date('Y-m-'.$lastDate.' h:i:s')
                    );
                    $sql = $this->db->insert('mess_meal', $data);
                }
                $lastDate++;
            }
            return $sql;
        } else if($this->getLastYear() < $year) {
            $sql = $this->db->query('TRUNCATE TABLE mess_meal;');
            return $sql;
        } else {
            return false;
        }
    }

    public function collectMeal($x = null, $y = null) {
        if($x != null) {
            $sql = $this->db->query('SELECT * FROM mess_meal WHERE usersid = '.$_SESSION['id'].' and mess_memberid = '.$x.';');
        } else if($x == null && $y == null) {
            $sql = $this->db->query('SELECT * FROM mess_meal WHERE usersid = '.$_SESSION['id'].';');
        } else {
            $sql = $this->db->query('SELECT meal.*, member.id as member_id, member.name FROM mess_meal as meal, mess_member as member WHERE meal.mess_memberid = member.id and meal.usersid = '.$_SESSION['id'].' and meal.id = '.$y.';');
        }
        return $sql->result();
    }

    public function updateMeal() {
        $data = array(
            'breakfast_meal'        => $this->input->post('breakfast_meal'),
            'lunch_meal'            => $this->input->post('lunch_meal'),
            'dinner_meal'           => $this->input->post('dinner_meal'),
            'updated_at'            => $this->date()
        );
        $id = $this->input->post('id');
        $sql = $this->db->where('id', $id);
        $sql = $this->db->update('mess_meal', $data);
        return $sql;
    }

}