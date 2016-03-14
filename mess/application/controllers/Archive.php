<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class Archive
 */
class Archive extends MY_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('ArchiveModel');
        $this->load->model('ReportModel');
    }

    /**
     * @getMonthName() has come from MY_Controller (core folder)
     */
    public function getMealArchive() {
        $data['page'] = 'archive';
        $data['heading'] = 'Meal Archive';
        $rows = $this->ArchiveModel->getMonth();
        $store = 0; $x = 0; $i = 0; $month_number = array(); $month = array();
        foreach($rows as $row) {
            $row = $row->month;
            if($row > $store) {
                $month[$x] = $this->getMonthName($row);
                $month_number[$i] = $row;
                $store = $row;
                $x++;
                $i++;
            }
        }
        $data['month'] = $month;
        $data['month_number'] = $month_number;
        $this->load->view('dashboard', $data);
    }

    public function getMealMonth($x) {
        $data['page'] = 'archivemonth';
        $data['heading'] = $this->getMonthName($x);
        $data['rows'] = $this->ArchiveModel->getMealArchiveResult($x);
        $this->load->view('dashboard', $data);
    }

    public function getReportArchive() {
        $data['page'] = 'archive_report';
        $data['heading'] = 'Report Archive';
        $rows = $this->ArchiveModel->getMonth();
        $store = 0; $x = 0; $i = 0; $month_number = array(); $month = array();
        foreach($rows as $row) {
            $row = $row->month;
            if($row > $store) {
                $month[$x] = $this->getMonthName($row);
                $month_number[$i] = $row;
                $store = $row;
                $x++;
                $i++;
            }
        }
        $data['month'] = $month;
        $data['month_number'] = $month_number;
        $this->load->view('dashboard', $data);
    }

    public function getArchiveMonth($x) {
        $data['page'] = 'archive_report_month';
        $data['heading'] = $this->getMonthName($x);
        $data['member'] = $this->ReportModel->getMember($x);
        $data['expenditure'] = $this->ReportModel->getExpenditure($x);
        $data['accounts'] = $this->ReportModel->getAccounts($x);
        $this->load->view('dashboard', $data);
    }
}