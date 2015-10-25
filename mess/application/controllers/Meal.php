<?php
class Meal extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('MealModel');
        //$this->load->library('calendar');
    }

    public function getMeal() {
        $data['page'] = 'meal';
        $data['heading'] = 'Meal List';
        $this->load->view('dashboard', $data);
    }

    public function getNewMeal() {
        $data['page'] = 'newmeal';
        $data['heading'] = 'Add Meal';
        $data['rows'] = $this->MealModel->collectMember();
        $this->load->view('dashboard', $data);
    }

    public function postNewMeal() {

    }
}