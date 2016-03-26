<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class Meal
 * Description - Showing Meal Table
 */
class Meal extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('MealModel');
        $this->MealModel->createMeal();
        //$this->load->library('calendar');
    }

    public function getMeal()
    {
        if ($this->session->has_userdata('id')) {
            $data['page'] = 'meal';
            $data['heading'] = 'Meal panel';
            $this->load->view('dashboard', $data);
        } else {
            $data['login_error'] = "Please login first";
            $this->load->view('login', $data);
        }
    }

    /**
     * dailyMeal method return collectSystem array which include all information of daily meal of users
     */
    public function dailyMeal()
    {
        if ($this->session->has_userdata('id')) {
            $data['page'] = 'daily_meal';
            $data['heading'] = 'Daily Meal';
            $data['rows'] = $this->MealModel->collectSystem();
            $this->load->view('dashboard', $data);
        } else {
            $data['login_error'] = "Please login first";
            $this->load->view('login', $data);
        }
    }

    public function getEdit($y)
    {
        if ($this->session->has_userdata('id')) {
            $data['page'] = 'edit_meal';
            $data['heading'] = 'Edit Meal';
            $data['rows'] = $this->MealModel->collectMeal($x = null, $y);
            $this->load->view('dashboard', $data);
        } else {
            $data['login_error'] = "Please login first";
            $this->load->view('login', $data);
        }
    }

    public function postEdit()
    {
        if ($this->session->has_userdata('id')) {
            $this->form_validation->set_rules('breakfast_meal', 'Breakfast Meal', 'trim|required|numeric');
            $this->form_validation->set_rules('lunch_meal', 'Lunch Meal', 'trim|required|numeric');
            $this->form_validation->set_rules('dinner_meal', 'Dinner Meal', 'trim|required|numeric');

            if($this->form_validation->run() === FALSE) {
                $data['heading'] = 'Edit Meal';
                $data['page'] = 'edit_meal';
                $data['rows'] = array();
                $this->load->view('dashboard', $data);
            } else {
                $this->MealModel->updateMeal();
                $this->session->set_flashdata('msg', 'Meal Updated Successfully');
                redirect('dashboard/meal');
            }
        } else {
            $data['login_error'] = "Please login first";
            $this->load->view('login', $data);
        }
    }

}