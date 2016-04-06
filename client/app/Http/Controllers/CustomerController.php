<?php

namespace App\Http\Controllers;

use App\CustomerModel;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Redirector;
use Hash;

class CustomerController extends Controller
{

    /**
     * returns customer registration view
     */
    public function getCustomer()
    {
        return view('customer.include.registration');
    }

    /**
     * returns post data for customer registration
     */
    public function postCustomer(Requests\CustomerRequest $request)
    {
        $active = 0;
        $create = CustomerModel::create(array(
               'firstname'      => $request->input('firstname'),
               'surname'        => $request->input('surname'),
               'email'          => $request->input('email'),
               'password'       => bcrypt($request->input('password')),
               'company_name'    => $request->input('companyname'),
               'address'        => $request->input('address'),
               'post_number'     => $request->input('postnumber'),
               'city'           => $request->input('city'),
               'active'         => $active
        ));
        //$request->session()->flash('global', 'Task was successful!');
        return redirect('customer/register')->with('global', 'Customer created successfully');
	
    }

    /**
     * @return customer login page
     */
    public function getLoginCustomer()
    {
        return view('customer.include.login');
    }

    /**
     * @param Requests\CustomerLoginRequest $request expect validation
     * @return intended page after login
     */
    public function postLoginCustomer(Requests\CustomerLoginRequest $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $table = CustomerModel::all();
        $id = $this->loginMatch($table, $email, $password);
        if($id) {
            $data = CustomerModel::where('id', $id)->get();
            foreach($data as $row) {
                $request->session()->put('id', $row->id);
                $request->session()->put('firstname', $row->firstname);
                $request->session()->put('email', $row->email);
                $request->session()->put('active', $row->active);
                $request->session()->put('token', $row->remember_token);
            }
            //Redirect intended page
            return redirect()->intended('/customer/portal');
        } else {
            return redirect('/customer/login')->with('global', 'Invalid Email / Password');
        }
    }

    /**
     * @param $table expect table name
     * @param $email expect email address
     * @param $password expect hashed password
     * @return matched row id
     */
    protected function loginMatch($table, $email, $password)
    {
        foreach($table as $row) {
            if($row->email == $email) {
                if(Hash::check($password, $row->password)) {
                    return $row->id;
                }
            }
        }
    }

    public function getCustomerPortal(Request $request)
    {
        if($request->session()->has('active') == 1) {
            return 'This is the customer portal';
        } else {
            return redirect('/customer/login')->with('global', 'You are not activated');
        }
    }
}
