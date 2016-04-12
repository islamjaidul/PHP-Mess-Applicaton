<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CustomerModel extends Model
{
    protected $table = 'customer';
    protected $fillable = array(
        'firstname',
        'lastname',
        'email',
        'password',
        'company_name',
        'address',
        'postal_code',
        'city',
        'phone',
        'active',
        'reference_id',
        'new_customer',
        'start_at',
        'end_at',
    );
}
