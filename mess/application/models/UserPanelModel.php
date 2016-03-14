<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class UserPanelModel is for user.
 * Manager can create an account from the manager panel
 * User / Mess border can use this username and password for save or update their meal
 */

class UserPanelModel extends CI_Model{
    public function __construct() {
        $this->load->database();
    }

    public function date() {
        date_default_timezone_set('Asia/Dhaka');
        $date = date('Y-m-d h:i:s');
        return $date;
    }

    /**
     * @Password method is for matching password with user input to database
     */
    public function Password($x)
    {          //Make Hash Password
        $options = [
            'cost' => 11,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        ];
        return password_hash($x, PASSWORD_BCRYPT, $options);
    }

    /**
     * @collectUserPanel method is for fetching data in user panel with session id
     */
    public function collectUserPanel() {
        $sql = $this->db->get_where('mess_panel', array('usersid' => $_SESSION['id']));
        return $sql->result();
    }

    /**
     * @createUserPanel method is for insert or update meal by user
     */
    public function createUserPanel() {
        $password = $this->input->post('password');
        $data = array(
            'username'      => $this->input->post('username'),
            'password'      => $this->Password($password),
            'usersid'       => $_SESSION['id'],
            'role'          => 'U',
            'created_at'    => $this->date()
        );

        return $this->db->insert('mess_panel', $data);
    }

}