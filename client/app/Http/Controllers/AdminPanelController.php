<?php
namespace App\Http\Controllers;

use App\CustomerModel;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Redirector;
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
     * @return customer view
     */
    public function getCustomer()
    {
        return view('admin.include.customer');
    }

    /**
     * @params $id expect id of the Customer table
     * @return Customer table json data
     */
    public function getData($id = null)
    {
        if($id == null) {
            $data = CustomerModel::all();
            return $data;
        } else {
            $data = CustomerModel::find($id);
            return $data;
        }
    }

    /**
     * @data variable expect json data form js/Controller.js
     * @return customer active and block system
     */
    public function getActiveOrBlock()
    {
        $data = json_decode(file_get_contents("php://input"));
        $sql = CustomerModel::find($data->id);
        if($sql->active == 1) {
            $sql->active = 0;
            $sql->save();
        } else {
            $sql->active = 1;
            $sql->save();
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

        foreach($this->getData() as $row) {
            if($data->email == $row->email) {
              $x = true;
              break;
            }
        }

        if($x == false) {
            CustomerModel::create(array(
                'firstname'      => $data->firstname,
                'surname'        => $data->surname,
                'email'          => $data->email,
                'password'       => bcrypt($data->password),
                'company_name'   => $data->company_name,
                'address'        => $data->address,
                'post_number'    => $data->post_number,
                'city'           => $data->city,
                'active'         => 0,
                'reference_id'   => uniqid()
            ));
            return $this->getData();
        } else {
            return 'false';
        }
    }

    public function getView()
    {
        $data = json_decode(file_get_contents("php://input"));
        return $this->getData($data->id);
    }

    public function getEdit()
    {
        $data = json_decode(file_get_contents("php://input"));
        $sql = CustomerModel::find($data->id);

        $sql->firstname      = $data->firstname;
        $sql->surname        = $data->surname;
        $sql->email          = $data->email;
        $sql->company_name   = $data->company_name;
        $sql->address        = $data->address;
        $sql->post_number    = $data->post_number;
        $sql->city           = $data->city;

        $sql->save();
        return $this->getData();
    }


}
