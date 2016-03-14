<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Dhaka');
        $CI = &get_instance();
        $CI->load->library('session');
        $CI->load->helper('url');
    }


    function getMonthName($x) {
        if($x == 1) {
            return 'January';
        } else if($x == 2) {
            return 'February';
        } else if($x == 3) {
            return 'March';
        } else if($x == 4) {
            return 'April';
        } else if($x == 5) {
            return 'May';
        } else if($x == 6) {
            return 'June';
        } else if($x == 7) {
            return 'July';
        } else if($x == 8) {
            return 'August';
        } else if($x == 9) {
            return 'September';
        } else if($x == 10) {
            return 'October';
        } else if($x == 11) {
            return 'November';
        } else {
            return 'December';
        }
    }
}

