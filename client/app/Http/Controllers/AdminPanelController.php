<?php
namespace App\Http\Controllers;

use App\CustomerModel;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Redirector;
use Carbon\Carbon;
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
        return view('admin.include.Customer');
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
        if ($sql->active == 1) {
            $sql->active = 0;
            $sql->save();
        } else {
            $sql->active = 1;
            $sql->new_customer = 0;
            if ($data->status == 1) {
                //Email sending to Customer
                $msg = "<h2>Dear " . $name . "</h2>
               <h4>Congratulation! Your account is activated on KP Online</h4>
               <h4>Now you can login on your account</h4>
               <p>Login Link: " . url('customer/login') . "</p>
               <p>Regards</p>
               <p>KP Online</p>";
                $subject = "Account Activated";
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
                'firstname' => $data->firstname,
                'surname' => $data->surname,
                'email' => $data->email,
                'password' => bcrypt($data->password),
                'company_name' => $data->company_name,
                'address' => $data->address,
                'post_number' => $data->post_number,
                'city' => $data->city,
                'active' => 0,
                'reference_id' => uniqid(),
                'new_customer' => 1
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

        $sql->firstname = $data->firstname;
        $sql->surname = $data->surname;
        $sql->email = $data->email;
        $sql->company_name = $data->company_name;
        $sql->address = $data->address;
        $sql->post_number = $data->post_number;
        $sql->city = $data->city;

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
            $sql->save();

            return $this->getData();

        } else if ($data->month == 0) {
            $start_date = date("Y-m-d");

            $sql->start_at = $start_date;
            $sql->end_at = date("0000-00-00");
            $sql->never_expired = 1;
            $sql->save();

            return $this->getData();
        } else {
            $start_date = date("Y-m-d");
            $month = date('m') + $data->month;
            $end_date = date("Y-" . $month . "-d");

            $sql->start_at = $start_date;
            $sql->end_at = $end_date;
            $sql->never_expired = 0;
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
        //Retrieving Starting data and Ending date and check the difference between.
        date_default_timezone_set('Europe/Stockholm');
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
                    $msg = "<h2>Dear " . $row->firstname . "</h2>
                   <h4>Your account will be expired after seven days.Your account's expiration date is " . $row->end_at . ". Please extend it on KP Online</h4>
                   <h4>You can extend your account link below</h4>
                   <p>Link: " . url('customer/account/extend') . "</p>
                   <p>Regards</p>
                   <p>KP Online</p>";
                    $subject = "Account Extension";
                    $this->sendMail($to, $subject, $msg);
                }
                //This is working on notification of expiration before 7 days for time span of particular month.
            } else if ($live_month > 0) {
                if ($current->toDateString() == $current->month($starting[1])->day($starting[2])->addMonths($live_month)->subDays(7)->toDateString()) {
                    //Email body
                    $to = $row->eamil;
                    $msg = "<h2>Dear " . $row->firstname . "</h2>
                   <h4>Your account will be expired after seven days.Your account's expiration date is " . $row->end_at . ". Please extend it on KP Online</h4>
                   <h4>You can extend your account link below</h4>
                   <p>Link: " . url('customer/account/extend') . "</p>
                   <p>Regards</p>
                   <p>KP Online</p>";
                    $subject = "Account Extension";
                    $this->sendMail($to, $subject, $msg);
                }
            }
        }
    }

    /**
     * This is working for doing block the account based on expiration
     */
    public function getExpired()
    {
        date_default_timezone_set('Europe/Stockholm');
        $sql = CustomerModel::all();
        //Retrieving Starting data and Ending date and check the difference between.
        date_default_timezone_set('Asia/Dhaka');
        foreach ($sql as $row) {
            $end = $row->end_at;

            //Matching date for expiration.
            if (date("Y-m-d") == $end) {
                $row->active = 0;
                $row->save();
            }
        }
    }

    public function getTest()
    {
        return $this->sendMail('sadibigboss@gmail.com', 'Cron Job Test', 'This is for the test purpose');
    }
}
