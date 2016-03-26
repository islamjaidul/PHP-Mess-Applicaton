<?php
/**
 * Class Report
 */
class Report extends MY_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('ReportModel');
    }
    /**
     * @getReport for fetching data from database of report
     */
    public function getReport() {
        if ($this->session->has_userdata('id')) {
            $data['heading'] = 'Report';
            $data['page'] = 'report';
            $data['member'] = $this->ReportModel->getMember();
            $data['expenditure'] = $this->ReportModel->getExpenditure();
            $data['accounts'] = $this->ReportModel->getAccounts();
            $this->load->view('dashboard', $data);
        } else {
            $data['login_error'] = "Please login first";
            $this->load->view('login', $data);
        }

    }
    public function test() {
        if ($this->session->has_userdata('id')) {

        } else {
            $data['login_error'] = "Please login first";
            $this->load->view('login', $data);
        }
    }
}