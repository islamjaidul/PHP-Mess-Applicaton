<?php

class MessAccounts extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('MessAccountsModel');
    }

    public function getMessAccounts()
    {
        $data['page'] = 'messaccount';
        $data['heading'] = 'Mess Accounts';
        $this->load->view('dashboard', $data);
    }

    public function getNewMessAccounts()
    {
        $data['page'] = 'newmessaccount';
        $data['heading'] = 'Add Cash';
        $data['rows'] = $this->MessAccountsModel->collectMember();
        $this->load->view('dashboard', $data);
    }

    public function postNewMessAccounts()
    {
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
        if ($this->form_validation->run() === FALSE) {
            $data['heading'] = 'Add Cash';
            $data['page'] = 'newmessaccount';
            $this->load->view('dashboard', $data);
        } else {

        }
    }
}