<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Companies extends Model
{
    use SoftDeletes;

    protected $table = 'companies';

    protected $fillable = [
        'company_name', 'company_link', 'fname', 'lname', 'email','password', 'confirm_password'
    ];
}
