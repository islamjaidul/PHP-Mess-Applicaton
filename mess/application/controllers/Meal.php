<?php
class Meal extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('MealModel');
        $this->MealModel->createMeal();
        //$this->load->library('calendar');
    }

    public function getMeal() {
        $data['page'] = 'meal';
        $data['heading'] = 'Meal panel';
        $this->load->view('dashboard', $data);
    }

}