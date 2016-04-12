<?php
namespace App\Http\Controllers;

use App\CustomerModel;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Redirector;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AdminPanelController extends Controller
{
    /**
     * This is for registered authintication.
     * If anybody try to go the authinticated link.
     * Then they need to login first
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * This is for admin registration
     * @return bool|static
     */
    public function adminRegistration()
    {
        $data = json_decode(file_get_contents("php://input"));
        $sql = User::all();
        $x = false;
        foreach ($sql as $row) {
            if ($row->email == $data->email) {
                $x = true;
            }
        }
        if ($x == false) {
            User::create(array(
                'name' => $data->name,
                'email' => $data->email,
                'password' => bcrypt($data->password)
            ));
            return 'success';
        } else {
            return 'false';
        }

    }

    /**
     * @return customer view
     */
    public function getCustomer()
    {
        return view('admin.include.customer_panel');
    }

    /**
     * @params $id expect id of the Customer table
     * @return Customer table json data
     */
    public function getData($id = null)
    {
        if ($id == null) {
            $data = CustomerModel::all();
            return $data;
        } else {
            $data = CustomerModel::find($id);
            return $data;
        }
    }

    /**
     * @param $to expect where the email will send
     * @param $subject email subject
     * @param $msg email message
     * @return bool
     */
    public function sendMail($to, $subject, $msg)
    {
        // To send HTML mail, the Content-type header must be set
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Additional headers
        $headers .= 'To: User <' . $to . '>' . "\r\n";
        $headers .= 'From: KP Online <noreplay@jaidulit.com>' . "\r\n";
        $headers .= 'Cc: ' . $to . '' . "\r\n";
        $headers .= 'Bcc: ' . $to . '' . "\r\n";

        // Mail it
        return mail($to, $subject, $msg, $headers);
    }


    /**
     * @data variable expect json data form js/Controller.js
     * @return customer active and block system
     */
    public function getActiveOrBlock()
    {
        $data = json_decode(file_get_contents("php://input"));
        $sql = CustomerModel::find($data->id);
        $name = $sql->firstname;
        $to = $sql->email;
        $reference_id = $sql->reference_id;
        if ($sql->active == 1) {
            $sql->active = 0;
            $sql->save();
        } else {
            $sql->active = 1;
            $sql->new_customer = 0;
            if ($data->status == 1) {
                //Email sending to Customer
                $msg = "<h2>Hi " . $name . "</h2>
               <h4>Congratulation! Your account on KP Online is now activated. You can login on the link below.</h4>
               <p>Login Link: " . url('customer/login') . "</p>
               <p>Regards KP System</p>";
                $subject = "Account activated";
                $sql->save();
                $this->sendMail($to, $subject, $msg);
            } else {
                $sql->save();
            }

        }

        return $this->getData();
    }

    /**
     * @return Delete customer from table
     */
    public function getDelete()
    {
        $data = json_decode(file_get_contents("php://input"));
        $delete = CustomerModel::find($data->id);
        $delete->delete($delete);
        return $this->getData();
    }

    /**
     * @prama expect json_data from js/Controller.js
     * @return new Customer create
     * @or
     * @return only string (If there is already a email exist what is requested)
     */
    public function getCreate()
    {
        $data = json_decode(file_get_contents("php://input"));
        $x = false;

        foreach ($this->getData() as $row) {
            if ($data->email == $row->email) {
                $x = true;
                break;
            }
        }

        if ($x == false) {
            CustomerModel::create(array(
                'firstname'         => $data->firstname,
                'lastname'          => $data->lastname,
                'email'             => $data->email,
                'password'          => bcrypt($data->password),
                'company_name'      => $data->company_name,
                'address'           => $data->address,
                'postal_code'       => $data->postal_code,
                'city'              => $data->city,
                'phone'             => $data->phone,
                'active'            => 0,
                'reference_id'      => uniqid(),
                'new_customer'      => 1
            ));

            return $this->getData();
        } else {
            return 'false';
        }
    }

    /**
     * @return Customer information edit by json data from js/Controller.js
     */
    public function getView()
    {
        $data = json_decode(file_get_contents("php://input"));
        return $this->getData($data->id);
    }

    /**
     * @return Customer information edit by json data from js/Controller.js
     */
    public function getEdit()
    {
        $data = json_decode(file_get_contents("php://input"));
        $sql = CustomerModel::find($data->id);

        $sql->firstname     = $data->firstname;
        $sql->lastname      = $data->lastname;
        $sql->email         = $data->email;
        $sql->company_name  = $data->company_name;
        $sql->address       = $data->address;
        $sql->postal_code   = $data->postal_code;
        $sql->city          = $data->city;
        $sql->phone = $data->phone;

        $sql->save();
        return $this->getData();
    }

    /**
     * @params month and id expect by json_data from js/Controller.js
     * @return This method will return how many month the customer account will live
     */
    public function getLive()
    {
        date_default_timezone_set('Europe/Stockholm');
        $data = json_decode(file_get_contents("php://input"));
        $sql = CustomerModel::find($data->id);
        if ($data->month == 12) {
            $start_date = date("Y-m-d");
            $year = date("Y") + 1;
            $end_date = date("" . $year . "-m-d");

            $sql->start_at = $start_date;
            $sql->end_at = $end_date;
            $sql->never_expired = 0;
            $sql->expired = 0;
            $sql->save();

            return $this->getData();

        } else if ($data->month == 0) {
            $start_date = date("Y-m-d");

            $sql->start_at = $start_date;
            $sql->end_at = date("0000-00-00");
            $sql->never_expired = 1;
            $sql->expired = 0;
            $sql->save();

            return $this->getData();
        } else {
            $start_date = date("Y-m-d");
            $month = date('m') + $data->month;
            $end_date = date("Y-" . $month . "-d");

            $sql->start_at = $start_date;
            $sql->end_at = $end_date;
            $sql->never_expired = 0;
            $sql->expired = 0;
            $sql->save();

            return $this->getData();

        }
    }

    /**
     * This is working for sending email before 7 days of expiration
     */
    public function getCheckBeforeExpiration()
    {
        date_default_timezone_set('Europe/Stockholm');
        $sql = CustomerModel::all();
        $email = false;
        //Retrieving Starting data and Ending date and check the difference between.
        foreach ($sql as $row) {
            $start = $row->start_at;
            $end = $row->end_at;
            $starting = explode("-", $start);
            $ending = explode("-", $end);
            $live_month = $ending[1] - $starting[1];

            $current = Carbon::today();

            //This is working on notification of expiration before 7 days for time span of one year.
            if ($live_month == 0) {
                if ($current->toDateString() == $current->month($starting[1])->day($starting[2])->year($starting[0])->addYear(1)->subDays(7)->toDateString()) {
                    //Email body
                    $to = $row->eamil;
                    $msg = "<h2>Hi " . $row->firstname . "</h2>
                   <h4>Your account on KP Online will expire in 7 days. Please contact us if you want to extend your subscription..</h4>
                   <p>Regards KP System</p>";
                    $subject = "KP Online";
                    $this->sendMail($to, $subject, $msg);
                    $email = true;
                }
                //This is working on notification of expiration before 7 days for time span of particular month.
            } else if ($live_month > 0) {
                if ($current->toDateString() == $current->month($starting[1])->day($starting[2])->addMonths($live_month)->subDays(7)->toDateString()) {
                    //Email body
                    $to = $row->eamil;
                    $msg = "<h2>Hi " . $row->firstname . "</h2>
                   <h4>Your account on KP Online will expire in 7 days. Please contact us if you want to extend your subscription..</h4>
                   <p>Regards KP System</p>";
                    $subject = "KP Online";
                    $this->sendMail($to, $subject, $msg);
                    $email = true;
                }
            }
        }
        if($email == true) {
            echo 'Email has been sent before 7 days';
        } else if($email == false) {
            echo 'The date has not come yet for sending email before 7 days';
        }
        return dd($this->getData());
    }

    /**
     * This is working for doing block the account based on expiration
     */
    public function getExpired()
    {
        date_default_timezone_set('Europe/Stockholm');
        $sql = CustomerModel::all();
        //Retrieving Starting data and Ending date and check the difference between.
        foreach ($sql as $row) {
            $end = $row->end_at;
            //Matching date for expiration.
            if (date("Y-m-d") >= $end) {
                $row->active = 0;
                $row->expired = 1;
                $row->save();
            }
        }
        return dd($this->getData());
    }

    public function getAdminSetting()
    {
        return view('admin.include.setting');
    }

    public function postAdminSetting(Requests\AdminSettingRequest $request)
    {
        if($request->input('password_confirmation') != $request->input('new_password')) {
            $validator = array(
                'new_password' => 'Please confirm the password'
            );
            return view('admin.include.setting')->withErrors($validator);
        } else {
            $sql = User::find(Auth::user()->id);
            if(Hash::check($request->input('old_password'), $sql->password)) {
                $sql->password = bcrypt($request->input('new_password'));
                if($sql->save()) {
                    Auth::logout();
                    return redirect('/login')->with('admin_password_change', 'Password has changed successfully');
                }
            } else {
                $validator = array(
                    'old_password' => 'Old password does not match'
                );
                return redirect('dashboard/setting')->withErrors($validator);
            }
        }
    }

    public function getTest()
    {
        if($this->sendMail('jaidul26@gmail.com', 'Cron Job Test', 'This is for the test purpose')) {
            return "E-mail test Passed";
        } else {
            return "OPPS!! There is some problem";
        }
    }
}
