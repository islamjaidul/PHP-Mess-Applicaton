<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class MessAccounts
 * Description - Mess accounts expense
 */
class MessAccounts extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('MessAccountsModel');
        $this->MessAccountsModel->createNullAccountsID();
    }

    /**
     * @Get last month of Mess Accounts table by altering loop
     */
    private function getLastMonth() {
        $rows = $this->MessAccountsModel->collectMessAccounts();
        $x = count($this->MessAccountsModel->collectMessAccounts());
        $last_month = 0;
        for($i = 1; $i <= $x; $i++) {
            $last_month = $rows[$x - $i]->month;
            break;
        }
        return $last_month;
    }

    private function getLastAmount() {
        $rows = $this->MessAccountsModel->collectMessAccounts();
        $x = count($this->MessAccountsModel->collectMessAccounts());
        $last_amount = 0;
        for($i = 1; $i <= $x; $i++) {
            $last_amount = $rows[$x - $i]->amount;
            break;
        }
        return $last_amount;
    }

    /**
     * @getMessAccount is fetching data in the table
     */
    public function getMessAccounts()
    {
        $data['page'] = 'messaccount';
        $data['heading'] = 'Mess Accounts';
        $data['last_month'] = $this->getLastMonth();
        $data['rows'] = $this->MessAccountsModel->collectMessAccounts();
        $data['amount'] = $this->getLastAmount();
        $this->load->view('dashboard', $data);
    }

    /**
     * @getNewMessAccount method is for load new mess account
     */
    public function getNewMessAccounts()
    {
        $data['page'] = 'newmessaccount';
        $data['heading'] = 'Add Cash';
        $data['rows'] = $this->MessAccountsModel->collectMember();
        $this->load->view('dashboard', $data);
    }

    /**
     * @postNewMessAccount method is for create new mess account data
     */
    public function postNewMessAccounts()
    {
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
        $this->form_validation->set_rules('memberid', 'Member', 'required');
        if ($this->form_validation->run() === FALSE) {
            $data['heading'] = 'Add Cash';
            $data['page'] = 'newmessaccount';
            $this->load->view('dashboard', $data);
        } else {
            $this->MessAccountsModel->createAccounts();
            $this->session->set_flashdata('msg', 'New Cash Saved Successfully');
            redirect('dashboard/accounts/new');
        }
    }


}