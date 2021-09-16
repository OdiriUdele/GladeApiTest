<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Interfaces\UserRoleInterface;
use App\Role;

class User extends Authenticatable implements JWTSubject, UserRoleInterface
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Assign the given role to the user.
     *
     * @param  string $role
     * @return mixed
     */
    public function assignRole($role)
    {

        $roleName = Role::whereName($role)->first();
        if ($roleName) {
            return $this->roles()->save($roleName);
        }
        
    }

    /**
     * Determine if the user has any given role.
     *
     * @param  mixed $role
     * @return boolean
     */
    public function hasAnyRole($roles){
        if(is_array($roles)){
            foreach($roles as $role){
                if($this->hasRole($role)){
                    return true;
                }
            }
        }else{
            if($this->hasRole($roles)){
                return true;
            }
        }
        return false;
    }
    
    /**
     * Determine if the user has the given role.
     *
     * @param  mixed $role
     * @return boolean
     */ 
    public function hasRole($role)
    {
       if ($this->roles()->where('name',$role)) {
           return true;
       }
       return false;
    } 

    public function roles(){
        return $this->belongsToMany('App\Role');
    }
}
