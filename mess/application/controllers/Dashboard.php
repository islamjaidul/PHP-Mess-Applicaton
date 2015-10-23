<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends MY_Controller {
    public function test() {
        $this->load->library('session');
        $data['page'] = 'test';
        $data['heading'] = "Hello World";
        $this->load->view('dashboard', $data);

    }
}