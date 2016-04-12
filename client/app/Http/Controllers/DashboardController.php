<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\CustomerModel;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDashboard()
    {
        $sql = CustomerModel::all();
        $total_customer = 0;
        $active = 0;
        $inactive = 0;
        $new_customer = 0;
        foreach($sql as $row) {
            if($row->active == 1) {
               $active++;
            } else if($row->new_customer == 1) {
                $new_customer++;
            } else if($row->active != 1 && $row->new_customer != 1) {
                $inactive++;
            }
            $total_customer++;
        }

        $data['active'] = $active;
        $data['inactive'] = $inactive;
        $data['total_customer'] = $total_customer;
        $data['new_customer'] = $new_customer;
        //echo 'New Customer'.' '.$data['new_customer'].'<br/>';
        //echo 'Total Customer'.' '.$data['total_customer'].'<br/>';
        //echo 'Active Customer'.' '.$data['active'].'<br/>';
        //echo 'Inactive Customer'.' '.($data['total_customer']-$data['active']).'<br/>';
        //echo 'New Expired Customer'.' '.$data['never_expired'].'<br/>';

        return view('admin.include.admin_dashboard', $data);
    }
}
