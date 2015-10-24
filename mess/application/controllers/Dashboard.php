<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('MemberModel');
    }

    public function test()
    {
        $data['page'] = 'test';
        $data['heading'] = "Hello World";
        $this->load->view('dashboard', $data);

    }

    public function getMember()
    {
        $data['page'] = 'member';
        $data['heading'] = 'Member';
        $data['rows'] = $this->MemberModel->collectMember();
        $this->load->view('dashboard', $data);
    }

    public function getNewMember()
    {
        $data['page'] = 'newmember';
        $data['heading'] = 'New Member';
        $this->load->view('dashboard', $data);
    }

    public function postNewMember()
    {
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

}