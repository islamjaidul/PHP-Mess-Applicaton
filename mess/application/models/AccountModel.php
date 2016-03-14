<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class AccountModel
 * working for create account for different role
 */
class AccountModel extends CI_Model
{
    public function __construct() {
        $this->load->database();
    }

    /**
     * @Password method return Hash Password
     */
    public function Password($x) {          
        $options = [
            'cost' => 11,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        ];
        return password_hash($x, PASSWORD_BCRYPT, $options);
    }

    private function date() { //Date Function for local time zone
        date_default_timezone_set('Asia/Dhaka');
        $date = date('Y-m-d h:i:s');
        return $date;
    }
    /**
     * @accountCreate method for create account for registration
     */
    public function accountCreate() {               //Account Create
        $password = $this->input->post('password');
        $data = array(
            'username' => $this->input->post('username'),
            'password' => $this->Password($password),
            'email' => $this->input->post('email'),
            'mobile' => $this->input->post('mobile'),
            'role' => 'U',
            'active' => 0,
            'created_at' => $this->date()
        );

        $sql = $this->db->insert('users', $data);
        return $sql;
    }

    /**
     * @getPassword method is for matching password of login with database password
     */
    private function getPassword($table, $username, $password) {            //Password maching basis of user input
        $sql = $this->db->get_where($table, array('username' => $username));
        $result = $sql->result();
        foreach ($result as $row)
            if (password_verify($password, $row->password))
                return $row->password;
    }

    /**
     * @managerLogin method is for Manager Login
     */
    public function managerLogin() {           //User login information
        $password = $this->input->post('password');
        $username = $this->input->post('username');
        $sql = $this->db->get_where('users', array('password' => $this->getPassword('users', $username, $password)));
        return $sql->result();
    }

    /**
     * @userLogin method is for Mess Member Login
     */
    public function usersLogin() {           //User login information
        $password = $this->input->post('password');
        $username = $this->input->post('username');
        $sql = $this->db->get_where('mess_panel', array('password' => $this->getPassword('mess_panel', $username, $password)));
        return $sql->result();
    }

}