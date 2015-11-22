<?php
class Panel extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('PanelModel');
        $this->load->library('form_validation');
        $this->load->library('session');
    }
    public function getPanel() {
        $data['heading'] = 'Panel';
        $data['page'] = 'panel';
        $data['rows'] = $this->PanelModel->collectMember();
        $this->load->view('dashboard', $data);
    }

    public function postPanel() {
        $this->form_validation->set_rules('breakfast_meal', 'Breakfast Meal', 'trim|required|numeric');
        $this->form_validation->set_rules('lunch_meal', 'Lunch Meal', 'trim|required|numeric');
        $this->form_validation->set_rules('dinner_meal', 'Dinner Meal', 'trim|required|numeric');

        if($this->form_validation->run() === FALSE) {
            $data['heading'] = 'Panel';
            $data['page'] = 'panel';
            $this->load->view('dashboard', $data);
        } else {
            $this->PanelModel->createPanel();
            $this->session->set_flashdata('msg', 'Meal Saved Successfully');
            redirect('dashboard/panel');
        }
    }
}