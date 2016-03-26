<?php
class ReportModel extends CI_Model
{
    public function __construct() {
        $this->load->database();
        date_default_timezone_set('Asia/Dhaka');
    }

    public function getExpenditure($date = null) {
        if($date == null) {
            $date = date('m');
        }
        $sql = $this->db->query('select * from expenditure where month = '.$date.' and usersid = '.$_SESSION['id'].';');
        return $sql->result();
    }


    public function getMember($date = null) {
        if($date == null) {
            $date = date('m');
        }
        $sql = $this->db->query('select * from mess_member WHERE usersid = '.$_SESSION['id'].';');
        $i = 0; $result = array();
        foreach($sql->result() as $row) {
            $result[$i] = $this->getMeal($row->id, $date);
            $i++;
        }
        return $result;
    }

    public function getMeal($x = null, $date) {
        $sql = $this->db->query('select ml.breakfast_meal, ml.lunch_meal, ml.dinner_meal, mm.name from mess_meal as ml, mess_member as mm where ml.mess_memberid = mm.id and ml.mess_memberid = '.$x.' and ml.usersid = '.$_SESSION['id'].' and ml.month = '.$date.';');
        return $sql->result();
    }

    /**
     * getAccounts return the accounts (money) from the mess member
     */
    public function getAccounts($date = null) {
        if($date == null) {
            $date = date('m');
        }
        $sql = $this->db->query('select mess_memberid from mess_accounts where usersid = '.$_SESSION['id'].' and month = '.$date.';');
        $sql =  $sql->result();
        $a = 0; $store = array();
        foreach($sql as $row) {
            $store[$a] = $row->mess_memberid;
            $a++;
        }

        sort($store);
        $sum = 0; $x = 0; $id = array();

        //Making sorting number into single number (1, 1, 1, 2, 2, 3) to (1, 2, 3)
        for($i = 0; $i < count($store); $i++) {
            if($sum < $store[$i]) {
                $sum = $store[$i];
                $id[$x] = $sum;
                $x++;
            }
        }
        //Retrieve data by using $id array and $store array
        $num = 0; $num2 = 0; $result = array();
        for($i = 0; $i < count($id); $i++) {
            for($j = 0; $j < count($store); $j++) {
                if($id[$i] == $store[$j]) {
                    $sql = $this->db->query('select * from mess_accounts where mess_memberid = '.$id[$i].' and usersid = '.$_SESSION['id'].' and month = '.$date.';');
                    $result[$num] =  $sql->result();
                }
                /*if($id[$i] == $store[$j]) {
                    $result[$num][$num2] = $id[$i];
                    $num2++;
                }*/
            }
            $num++;
        }
        return $result;
    }

}