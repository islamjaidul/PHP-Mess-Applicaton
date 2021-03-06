<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('MemberModel');
        $this->load->model('MessAccountsModel');
        $this->load->model('ExpenditureModel');
        $this->load->model('MealModel');
    }

    public function getDashboard() {
        $data['page'] = 'dashboard';
        $data['heading'] = 'Dashboard';
        $data['member'] = $this->MemberModel->collectMember();
        $data['accounts'] = $this->MessAccountsModel->collectMessAccounts();
        $data['expenditure'] = $this->ExpenditureModel->collectExpenditure();
        $data['meal'] = $this->MealModel->collectMeal();
        $this->load->view('dashboard', $data);
    }
}