<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CustomerModel extends Model
{
    protected $table = 'customer';
    protected $fillable = array(
        'firstname',
        'surname',
        'email',
        'password',
        'company_name',
        'address',
        'post_number',
        'city',
        'active',
        'reference_id',
        'new_customer',
        'start_at',
        'end_at',
    );
}
