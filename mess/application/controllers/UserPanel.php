<?php
class UserPanel extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('UserPanelModel');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function getUserPanel() {
        $data['page'] = 'userpanel';
        $data['heading'] = 'User Panel';
        $data['rows'] = $this->UserPanelModel->collectUserPanel();
        $this->load->view('dashboard', $data);
    }

    public function postNewUserPanel() {
        $this->form_validation->set_rules('mess_name', 'Mess Name', 'trim|required|max_length[200]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|max_length[80]');

        if($this->form_validation->run() === FALSE) {
            $data['page'] = 'userpanel';
            $data['heading'] = 'User Panel';
            $this->load->view('dashboard', $data);
        } else {
            $this->UserPanelModel->createUserPanel();
            $this->session->set_flashdata('msg', 'User Panel Saved Successfully');
            redirect('dashboard/userpanel');
        }
    }
}