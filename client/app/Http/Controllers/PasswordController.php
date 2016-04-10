<?php

namespace App\Http\Controllers;
use App\CustomerModel;
use App\PasswordReset;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests;

class PasswordController extends Controller
{
    public function getAdminReset()
    {
        return 'Admin password reset';
    }

    public function getCustomerReset()
    {
        return view('customer.include.reset');
    }

    public function postCustomerReset(Requests\PasswordReset $request)
    {
        $sql = CustomerModel::all();
        $x = false;
        $email = null;
        foreach($sql as $row) {
            if($row->email == $request->email) {
                $email = $row->email;
                $x = true;
                break;
            }
        }
        if($x == true) {
            PasswordReset::create(['email' => $email]);
           return redirect('customer/reset/password');
        } else {
            $validator = array(
                'email' => 'Email do not match'
            );
            return view('customer.include.reset')
                ->withErrors($validator);
        }
    }

    /**
     * @return New password reset form
     */
    public function getCustomerPasswordReset()
    {
        return view('customer.include.reset_password');
    }

    /**
     * @param Requests\NewPasswordResetRequest $request for validation
     * @return update the password of the Customer
     */
    public function postCustomerPasswordReset(Requests\NewPasswordResetRequest $request)
    {
        $sql = DB::table('password_resets')->orderBy('id', 'desc')->get();
        $email = null;
        foreach($sql as $row) {
            $email = $row->email;
            break;
        }
        $sql = CustomerModel::all();
        $id = null;
        $x = false;
        foreach($sql as $row) {
            if($row->email == $email) {
                $id = $row->id;
            }
        }

        $sql = CustomerModel::find($id);
        $sql->password = bcrypt($request->input('password'));
        $change = $sql->save();
        if($change) {
            return redirect('customer/login')->with('password_change', "Your password has successfully changed!");
        }

    }
}
