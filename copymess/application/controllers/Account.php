<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Account
 * Description - Account Controller is for create account of Manager
 */
class Account extends MY_Controller
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
        $this->load->library('encrypt');
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
            $to = $this->input->post('email');
            $subject = 'Registration Activation Link';

            $account = $this->AccountModel->collectUsers();
            $id = 0;
            foreach($account as $row) {
                $id = $row->id + 1;
                break;
            }
            $msg = "<h4>Please click the link below to activate your account</h4><br/><b>Link: </b><p>".base_url('active/'.$this->encrypt->encode($id).'');

            if($this->sendMail($to, $subject, $msg)) {
                $this->AccountModel->accountCreate();
                $this->load->view('success');
            }
        }
    }

   public function sendMail($to, $subject, $msg) {
        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Additional headers
        $headers .= 'To: User <'.$to.'>' . "\r\n";
        $headers .= 'From: Mess Finder <noreplay@jaidulit.com>' . "\r\n";
        $headers .= 'Cc: '.$to.'' . "\r\n";
        $headers .= 'Bcc: '.$to.'' . "\r\n";

        // Mail it
        return mail($to, $subject, $msg, $headers);
    }

    public function getActiveAccount($x) {
        $x = $this->encrypt->decode($x);
       $active = $this->AccountModel->activeAccount($x);
        if($active) {
            echo '<h3 style="color">Your Account Activated Successfully</h3><br/><p>Now you can login in your account</p>';
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
                    redirect('dashboard/panel');
                } else {
                    show_404();
                }
            } else {
                $data['login_error'] = "Your Username / Password is Invalid";
                $this->load->view('login', $data);
            }
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
            $this->session->unset_userdata('id');
            $this->session->unset_userdata('role');
            redirect(base_url());
        } else {
            show_404();
        }
    }
}
