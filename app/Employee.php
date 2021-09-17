<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';

    protected $fillable = [
        'company', 'first_name','last_name', 'email', 'phone', 'employee_user_id'
    ];

    public function companyData(){
        return $this->belongsTo('App\Company', 'company');
    }

    public function user(){
        return $this->HasOne('App\User', 'id', 'employee_user_id');
    }
}
