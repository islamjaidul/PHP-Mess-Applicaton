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
     * @return Customer table json data
     */
    public function getData()
    {
        $data = CustomerModel::all();
        return $data;
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
                'company_name'    => $data->company_name,
                'address'        => $data->address,
                'post_number'     => $data->post_number,
                'city'           => $data->city,
                'active'         => 1
            ));
            return $this->getData();
        } else {
            return 'false';
        }
    }
}
