<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Member
 * Description - Use for fetch and create Member
 */
class Member extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('MemberModel');
        $this->load->model('MealModel');
    }

    /**
     * @getMember method is use for fetch data for table
     */
    public function getMember() {
        $data['page'] = 'member';
        $data['heading'] = 'Member';
        $data['rows'] = $this->MemberModel->collectMember();
        $this->load->view('dashboard', $data);
    }

    /**
     * @getNewMember method is use for load new member page
     */
    public function getNewMember() {
        $data['page'] = 'newmember';
        $data['heading'] = 'New Member';
        $this->load->view('dashboard', $data);
    }

    /**
     * @postNewMember method is use for create new member to database
     */
    public function postNewMember() {
        $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[20]');
        $this->form_validation->set_rules('address', 'Address', 'trim|required|max_length[20]');
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|numeric|max_length[15]');
        $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|max_length[50]');
        $this->form_validation->set_rules('occupation', 'Occupation', 'trim|in_list[Student,Service]');
        if ($this->form_validation->run() === FALSE) {
            $data['heading'] = 'New Member';
            $data['page'] = 'newmember';
            $this->load->view('dashboard', $data);
        } else {
            $this->MemberModel->createMember();
            $this->session->set_flashdata('msg', 'New Member Saved Successfully');
            redirect('dashboard/member/new');
        }
    }

    public function getEdit($x) {
        $data['page'] = 'edit_member';
        $data['heading'] = 'Edit Member';
        $data['rows'] = $this->MemberModel->collectMember($x);
        $this->load->view('dashboard', $data);
    }

    public function postEdit() {
        $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[20]');
        $this->form_validation->set_rules('address', 'Address', 'trim|required|max_length[20]');
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|numeric|max_length[15]');
        $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|max_length[50]');
        $this->form_validation->set_rules('occupation', 'Occupation', 'trim|in_list[Student,Service]');

        if ($this->form_validation->run() === FALSE) {
            $data['heading'] = 'Edit Member';
            $data['page'] = 'edit_member';
            $this->load->view('dashboard', $data);
        } else {
            $this->MemberModel->updateMember();
            $this->session->set_flashdata('msg', 'Member Updated Successfully');
            redirect('dashboard/member');
        }
    }

    public function getDelete($x) {
        /*$delete = $this->MemberModel->deleteMember($x);
        if($delete) {
            $this->session->set_flashdata('msg', 'Successfully Deleted');
            redirect('dashboard/member');
        }*/
        $system = $this->MealModel->collectSystem($x);
        $sum = 0;
        foreach($system as $row) {
            $sum = $row->breakfast_meal + $row->lunch_meal + $row->dinner_meal;
            break;
        }
        if($sum == 0) {
            $delete = $this->MemberModel->deleteMember($x);
            if($delete) {
                $this->session->set_flashdata('alert-msg', 'Successfully Deleted');
                redirect('dashboard/member');
            }
        } else {
            $this->session->set_flashdata('alert-msg', 'This member is include the mess meal');
            redirect('dashboard/member');
        }
    }
}