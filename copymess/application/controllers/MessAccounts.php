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
    private function getLastMonth()
    {
        if ($this->session->has_userdata('id')) {
            $rows = $this->MessAccountsModel->collectMessAccounts();
            $x = count($this->MessAccountsModel->collectMessAccounts());
            $last_month = 0;
            for($i = 1; $i <= $x; $i++) {
                $last_month = $rows[$x - $i]->month;
                break;
            }
            return $last_month;
        } else {
            $data['login_error'] = "Please login first";
            $this->load->view('login', $data);
        }
    }

    private function getLastAmount()
    {
        if ($this->session->has_userdata('id')) {
            $rows = $this->MessAccountsModel->collectMessAccounts();
            $x = count($this->MessAccountsModel->collectMessAccounts());
            $last_amount = 0;
            for($i = 1; $i <= $x; $i++) {
                $last_amount = $rows[$x - $i]->amount;
                break;
            }
            return $last_amount;
        } else {
            $data['login_error'] = "Please login first";
            $this->load->view('login', $data);
        }
    }

    /**
     * @getMessAccount is fetching data in the table
     */
    public function getMessAccounts()
    {
        if ($this->session->has_userdata('id')) {
            $data['page'] = 'messaccount';
            $data['heading'] = 'Mess Accounts';
            $data['last_month'] = $this->getLastMonth();
            $data['rows'] = $this->MessAccountsModel->collectMessAccounts();
            $data['amount'] = $this->getLastAmount();
            $this->load->view('dashboard', $data);
        } else {
            $data['login_error'] = "Please login first";
            $this->load->view('login', $data);
        }
    }

    /**
     * @getNewMessAccount method is for load new mess account
     */
    public function getNewMessAccounts()
    {
        if ($this->session->has_userdata('id')) {
            $data['page'] = 'newmessaccount';
            $data['heading'] = 'Add Cash';
            $data['rows'] = $this->MessAccountsModel->collectMember();
            $this->load->view('dashboard', $data);
        } else {
            $data['login_error'] = "Please login first";
            $this->load->view('login', $data);
        }
    }

    /**
     * @postNewMessAccount method is for create new mess account data
     */
    public function postNewMessAccounts()
    {
        if ($this->session->has_userdata('id')) {
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
        } else {
            $data['login_error'] = "Please login first";
            $this->load->view('login', $data);
        }
    }

    public function getEdit($x)
    {
        if ($this->session->has_userdata('id')) {
            $data['page'] = 'edit_accounts';
            $data['heading'] = 'Edit Accounts';
            $data['rows'] = $this->MessAccountsModel->editMessAccounts($x);
            $this->load->view('dashboard', $data);
        } else {
            $data['login_error'] = "Please login first";
            $this->load->view('login', $data);
        }
    }

    public function postEdit()
    {
        if ($this->session->has_userdata('id')) {
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            $this->form_validation->set_rules('memberid', 'Member', 'required');
            if ($this->form_validation->run() === FALSE) {
                $data['heading'] = 'Edit Accounts';
                $data['page'] = 'edit_accounts';
                $this->load->view('dashboard', $data);
            } else {
                $this->MessAccountsModel->updateAccounts();
                $this->session->set_flashdata('msg', 'Mess Accounts Updated Successfully');
                redirect('dashboard/accounts');
            }
        } else {
            $data['login_error'] = "Please login first";
            $this->load->view('login', $data);
        }
    }

    public function getDelete($x)
    {
        if ($this->session->has_userdata('id')) {
            $delete = $this->MessAccountsModel->deleteMessAccounts($this->encrypt->decode($x));
            if($delete) {
                $this->session->set_flashdata('alert-msg', 'Successfully Deleted');
                redirect('dashboard/accounts');
            }
        } else {
            $data['login_error'] = "Please login first";
            $this->load->view('login', $data);
        }
    }


}