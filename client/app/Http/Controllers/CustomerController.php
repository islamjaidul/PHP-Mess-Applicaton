<?php

namespace App\Http\Controllers;

use App\CustomerModel;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Redirector;
use Hash;
use Crypt;
use DB;

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
     * @param $to expect where the email will send
     * @param $subject email subject
     * @param $msg email message
     * @return bool
     */
    public function sendMail($to, $subject, $msg) {
        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Additional headers
        $headers .= 'To: User <'.$to.'>' . "\r\n";
        $headers .= 'From: KP System <noreplay@kponline.se>' . "\r\n";
        $headers .= 'Cc: '.$to.'' . "\r\n";
        $headers .= 'Bcc: '.$to.'' . "\r\n";

        // Mail it
        return mail($to, $subject, $msg, $headers);
    }

    /**
     * returns post data for customer registration
     */
    public function postCustomer(Requests\CustomerRequest $request)
    {
        $create = CustomerModel::create(array(
               'firstname'      => $request->input('firstname'),
               'lastname'        => $request->input('lastname'),
               'email'          => $request->input('email'),
               'password'       => bcrypt($request->input('password')),
               'company_name'   => $request->input('companyname'),
               'address'        => $request->input('address'),
               'postal_code'    => $request->input('postal_code'),
               'city'           => $request->input('city'),
               'phone'          => $request->input('phone'),
               'active'         => 0,
               'reference_id'   => uniqid(),
               'new_customer'   => 1
        ));
        $table = DB::table('customer')->orderBy('id', 'desc')->get();
        $reference_id = null;
        foreach($table as $row) {
            $reference_id = $row->reference_id;
            break;
        }

        //Email sending to Customer after registration
        $name = $request->input('firstname');
        $msg = "<h2>Hi ".$name."</h2>
               <h4>Thank you for registering to KP Online!</h4>
               <h4>Your request has been sent to us for evaluation. You will receive a confirmation email when your account has been approved and activated.</h4>
               <p>Regards KP System</p>";
        $to = $request->input('email');
        $subject = "Thank you for registering!";

        //Email sending to admin after registration
        $to_admin = "frlo@frlo.se";
        $msg_admin = "<h2>New Customer: ".$name."</h2>
                <h4>Company: ".$request->input('companyname')."</h4>
               <h4>Reference ID: ".$reference_id."</h4>
               <h4>Please click the below to active him</h4>
               <p>".url('/login')."</p>";
        $subject_admin = "KP Online – New Customer";

        $this->sendMail($to_admin, $subject_admin, $msg_admin);

        if($this->sendMail($to, $subject, $msg)) {
            return redirect('customer/email/notification')->with('global', 'Email has been sent.');
        }
    }

    /**
     * @return E-mail notification after completing registration
     */
    public function getEmailNotification()
    {
        return view('customer.include.email_notification');
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
            $data = CustomerModel::find($id);
            if($data->active == 1) {
                $request->session()->put('id', $id);
                //Redirect intended page
                return redirect()->intended('/customer/portal');
            } else {
                return redirect('/customer/login')->with('global', 'You are not activated');
            }
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

    /**
     * @param Request $request
     * @return This is for customer portal page
     */
    public function getCustomerPortal(Request $request)
    {
        if($request->session()->has('id') == 1) {
            return view('customer.include.customer_portal');
        } else {
            return redirect('/customer/login')->with('global', 'Please login first');
        }
    }

    /**
     * @param Request $request
     * @return Customer log out
     */
    public function getLogoutCustomer(Request $request)
    {
        if ($request->session()->has('id')) {
            $request->session()->forget('id');
        }
        return redirect('customer/login');
    }

    public function getAccountExtend()
    {
        return view('customer.include.account_extension');
    }
}
