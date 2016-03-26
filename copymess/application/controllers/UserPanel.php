<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class UserPanel extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserPanelModel');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    /**
     * @getUserPanel is for fetch data in the table
     */
    public function getUserPanel()
    {
        if ($this->session->has_userdata('id')) {
            $data['page'] = 'userpanel';
            $data['heading'] = 'User Panel';
            $data['rows'] = $this->UserPanelModel->collectUserPanel();
            $this->load->view('dashboard', $data);
        } else {
            $data['login_error'] = "Please login first";
            $this->load->view('login', $data);
        }
    }

    /**
     * @postNewUserPanel is for create user panel for user by Manager
     */
    public function postNewUserPanel()
    {
        if ($this->session->has_userdata('id')) {
            $this->form_validation->set_rules('username', 'Mess Name', 'trim|required|max_length[200]|is_unique[mess_panel.username]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|max_length[80]');

            if($this->form_validation->run() === FALSE) {
                $data['page'] = 'userpanel';
                $data['heading'] = 'User Panel';
                $data['rows'] = $this->UserPanelModel->collectUserPanel();
                $this->load->view('dashboard', $data);
            } else {
                $this->UserPanelModel->createUserPanel();
                $this->session->set_flashdata('msg', 'User Panel Saved Successfully');
                redirect('dashboard/userpanel');
            }
        } else {
            $data['login_error'] = "Please login first";
            $this->load->view('login', $data);
        }
    }
}