<?php
class Expenditure extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('ExpenditureModel');
    }

    public function getExpenditure() {
        $data['page'] = 'expenditure';
        $data['heading'] = 'Expenditure';
        $data['rows'] = $this->ExpenditureModel->collectExpenditure();
        $this->load->view('dashboard', $data);
    }

    public function getNewExpenditure() {
        $data['page'] = 'newexpenditure';
        $data['heading'] = 'New Expenditure';
        $data['rows'] = $this->ExpenditureModel->collectMember();
        $this->load->view('dashboard', $data);
    }

    public function postNewExpenditure() {
        $this->form_validation->set_rules('expense_amount', 'Expense Amount', 'trim|required|numeric|max_length[15]');
        $this->form_validation->set_rules('shopping', 'Shopping', 'trim|required');

        if($this->form_validation->run() === FALSE) {
            $data['page'] = 'newexpenditure';
            $data['heading'] = 'New Expenditure';
            $this->load->view('dashboard', $data);
        } else {
            $this->ExpenditureModel->createExpenditure();
            $this->session->set_flashdata('msg', 'New Expenditure Saved Successfully');
            redirect('dashboard/expenditure/new');
        }
    }
}