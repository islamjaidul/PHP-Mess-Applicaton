<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CustomerModel extends Model
{
    protected $table = 'customer';
    protected $fillable = array('firstname', 'surname', 'email', 'password', 'company_name', 'address', 'post_number', 'city', 'active');

    protected $hidden = [
        'password', 'remember_token',
    ];
}
