<?php
class UserGuide extends MY_Controller {
    public function getUserGuide()
    {
        if ($this->session->has_userdata('id')) {
            $data['page'] = 'user_guide';
            $data['heading'] = 'Documentation';
            $this->load->view('dashboard', $data);
        } else {
            $data['login_error'] = "Please login first";
            $this->load->view('login', $data);
        }
    }
}