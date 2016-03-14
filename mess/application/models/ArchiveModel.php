<?php
/**
 * Class ArchiveModel
 */
class ArchiveModel extends CI_Model
{
    public function __construct() {
        $this->load->database();
    }

    /**
     * @return month name
     */
    public function getMonth() {
        $sql = $this->db->query('select month from mess_meal WHERE usersid = '.$_SESSION['id'].';');
        return $sql->result();
    }

    public function getMealArchiveResult($x) {
        $sql = $this->db->query('select ml.*, mm.name, mm.id from mess_meal as ml, mess_member as mm WHERE ml.mess_memberid = mm.id and ml.month = '.$x.' and ml.usersid = '.$_SESSION['id'].' order by ml.id desc;');
        return $sql->result();
    }
}