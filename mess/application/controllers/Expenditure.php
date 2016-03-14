<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class Expenditure
 * Description - Mess Expenditure
 */
class Expenditure extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('ExpenditureModel');
        $this->load->model('MessAccountsModel');
    }

    /**
     * @Get last month of expenditure table by altering loop
     */
    private function getLastMonth() {
        $rows = $this->ExpenditureModel->collectExpenditure();
        $x = count($this->ExpenditureModel->collectExpenditure());
        $last_month = 0;
        for($i = 1; $i <= $x; $i++) {
            $last_month = $rows[$x - $i]->month;
            break;
        }
        return $last_month;
    }

    /**
     * @getExpenditure method is for showing table of expenditure
     */
    public function getExpenditure() {
        $data['page'] = 'expenditure';
        $data['heading'] = 'Expenditure';
        $data['last_month'] = $this->getLastMonth();
        $data['rows'] = $this->ExpenditureModel->collectExpenditure();
        $this->load->view('dashboard', $data);

    }

    /**
     * @getNewExpenditure method is for insert new expenditure in the database
     */
    public function getNewExpenditure() {
        $data['page'] = 'newexpenditure';
        $data['heading'] = 'New Expenditure';
        $data['rows'] = $this->ExpenditureModel->collectMember();
        $data['mess_accounts'] = $this->MessAccountsModel->collectMessAccounts();
        $data['expense_amount'] = $this->ExpenditureModel->collectExpenditure();
        $this->load->view('dashboard', $data);
    }

    /**
     * @postNewExpenditure is for create new expenditure
     */
    public function postNewExpenditure() {
        $this->form_validation->set_rules('expense_amount', 'Expense Amount', 'trim|required|numeric|max_length[15]');
        $this->form_validation->set_rules('shopping', 'Shopping', 'trim|required');

        if($this->form_validation->run() === FALSE) {
            $data['page'] = 'newexpenditure';
            $data['heading'] = 'New Expenditure';
            $data['rows'] = $this->ExpenditureModel->collectMember();
            $data['mess_accounts'] = $this->MessAccountsModel->collectMessAccounts();
            $data['expense_amount'] = $this->ExpenditureModel->collectExpenditure();
            $this->load->view('dashboard', $data);
        } else {
            $this->ExpenditureModel->createExpenditure();
            $this->session->set_flashdata('msg', 'New Expenditure Saved Successfully');
            redirect('dashboard/expenditure/new');
        }
    }
}