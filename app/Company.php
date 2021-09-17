<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';

    protected $fillable = [
        'company_admin_user', 'name', 'email', 'logo', 'website', 'created_by'
    ];

    public function createdBy(){
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    public function user(){
        return $this->HasOne('App\User', 'id', 'company_admin_user');
    }

    public function employee(){
        return $this->HasMany('App\Employee', 'company');
    }
}
