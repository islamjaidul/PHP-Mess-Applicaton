<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller
{
    public function index() {
        $this->load->view('login');             //Showing Login Page
    }

    public function getCreate() {               //Account Create Page
        $this->load->view('registration');
    }

    public function __construct() {             //Every thing is loaded here by constructor
        parent::__construct();
        $this->load->model('AccountModel');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function postCreate() {              //Account Create Page for Post Value
        $this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[20]|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|max_length[20]');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[password]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[60]|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|numeric|min_length[11]|max_length[20]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('registration');
        } else {
            $this->AccountModel->accountCreate();
            $this->load->view('success');
        }
    }

    private function active() {             //Checking user active or not
        $rows = $this->AccountModel->managerLogin();
        foreach ($rows as $row)
            return $row->active;
    }

    public function getLogin() {               //Login
        $input = $this->input->post('role');
        if($input == 'M') {
            if ($this->AccountModel->managerLogin()) {
                if ($this->active() != 0) {
                    $data = $this->AccountModel->managerLogin();
                    foreach ($data as $row) {
                        $this->session->set_userdata('id', $row->id);
                        $this->session->set_userdata('role', $row->role);
                    }
                    if ($this->session->has_userdata('id')) {
                        redirect('dashboard');
                    } else {
                        show_404();
                    }
                } else {
                    $data['login_error'] = "You are not active. Please check your mail";
                    $this->load->view('login', $data);
                }
            } else {
                $data['login_error'] = "Your Username / Password is Invalid";
                $this->load->view('login', $data);
            }
        } elseif($input == 'U') {
            if($this->AccountModel->usersLogin()) {
                $data = $this->AccountModel->usersLogin();
                foreach ($data as $row) {
                    $this->session->set_userdata('id', $row->id);
                    $this->session->set_userdata('usersid', $row->usersid);
                    $this->session->set_userdata('role', $row->role);
                }
                if ($this->session->has_userdata('id')) {
                    redirect('dashboard');
                } else {
                    show_404();
                }
            } else {
                $data['login_error'] = "Your Username / Password is Invalid";
                $this->load->view('login', $data);
            }

        } else if($input == 'A') {
            echo 'Admin Panel';
        } else {
            $data['login_error'] = "Invalid login attempt";
            $this->load->view('login', $data);
        }
    }

    public function getDashboard() {                   //Users page after login
        if ($this->session->has_userdata('id')) {
            $this->load->view('dashboard');
        } else {
            $data['login_error'] = "Please login first";
            $this->load->view('login', $data);
        }
    }

    public function getLogout() {
        if ($this->session->has_userdata('id')) {
            $this->session->unset_userdata('usersid');
            $this->session->unset_userdata('role');
            redirect(base_url());
        } else {
            show_404();
        }
    }
}