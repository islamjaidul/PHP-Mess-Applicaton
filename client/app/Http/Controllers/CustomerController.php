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
        $headers .= 'From: KP Online <noreplay@jaidulit.com>' . "\r\n";
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
               'surname'        => $request->input('surname'),
               'email'          => $request->input('email'),
               'password'       => bcrypt($request->input('password')),
               'company_name'   => $request->input('companyname'),
               'address'        => $request->input('address'),
               'post_number'    => $request->input('postnumber'),
               'city'           => $request->input('city'),
               'active'         => 0,
               'reference_id'   => uniqid()
        ));
        $table = DB::table('customer')->orderBy('id', 'desc')->get();
        $reference_id = null;
        foreach($table as $row) {
            $reference_id = $row->reference_id;
            break;
        }

        //Email sending to Customer
        $name = $request->input('firstname');
        $msg = "<h2>Dear ".$name."</h2>
               <h4>Thank you for registration</h4>
               <h4>Please wait for confirmation, your account is under review</h4>
               <p>Regards</p>
               <p>Fredrik</p>";
        $to = $request->input('email');
        $subject = "Account Creation";

        //Email sending to admin.
        $to_admin = "frlo@frlo.se";
        $msg_admin = "<h2>Customer: ".$name."</h2>
               <h4>Reference ID: ".$reference_id."</h4>
               <h4>Please click the below to active him</h4>
               <p>".url('/login')."</p>";
        $subject_admin = "Account Activation";

        $this->sendMail($to_admin, $subject_admin, $msg_admin);

        if($this->sendMail($to, $subject, $msg)) {
            return redirect('customer/email/notification')->with('global', 'Email has been sent.');
        }
    }

    public function getEmailNotification()
    {
        return view('customer.include.email_notification');
    }

    public function getAccountActivation($id) {
        $id = Crypt::decrypt($id);
        $sql = CustomerModel::first($id);
        $sql->active = 1;
        if($sql->save()) {
         return redirect('customer/email/notification')->with('active', 'Congratulation your account is now activated');
        }
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
