<?php
class UserPanelModel extends CI_Model{
    public function __construct() {
        $this->load->database();
    }

    public function date() {
        date_default_timezone_set('Asia/Dhaka');
        $date = date('Y-m-d h:i:s');
        return $date;
    }

    public function Password($x)
    {          //Make Hash Password
        $options = [
            'cost' => 11,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        ];
        return password_hash($x, PASSWORD_BCRYPT, $options);
    }

    public function collectUserPanel() {
        $sql = $this->db->get('mess_panel');
        return $sql->result();
    }

    public function createUserPanel() {
        $password = $this->input->post('password');
        $data = array(
            'mess_name' => $this->input->post('mess_name'),
            'password' => $this->Password($password),
            'usersid' => $_SESSION['id'],
            'created_at' => $this->date()
        );

        return $this->db->insert('mess_panel', $data);
    }

}