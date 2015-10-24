<?php

class AccountModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function Password($x)
    {          //Make Hash Password
        $options = [
            'cost' => 11,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        ];
        return password_hash($x, PASSWORD_BCRYPT, $options);
    }

    public function accountCreate()
    {               //Account Create
        $password = $this->input->post('password');
        $data = array(
            'username' => $this->input->post('username'),
            'password' => $this->Password($password),
            'email' => $this->input->post('email'),
            'mobile' => $this->input->post('mobile'),
            'rule' => 'U',
            'active' => 0,
            'created_at' => date("Y-m-d h:i:s")
        );

        $sql = $this->db->insert('users', $data);
        return $sql;
    }

    private function getPassword($username, $password)
    {            //Password maching basis of user input
        $sql = $this->db->get_where('users', array('username' => $username));
        $result = $sql->result();
        foreach ($result as $row)
            if (password_verify($password, $row->password))
                return $row->password;
    }

    public function login()
    {           //User login information
        $password = $this->input->post('password');
        $username = $this->input->post('username');
        $sql = $this->db->get_where('users', array('password' => $this->getPassword($username, $password)));
        return $sql->result();
    }

}