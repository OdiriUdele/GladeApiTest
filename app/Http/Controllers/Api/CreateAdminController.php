<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\AdminCreateRequest;
use App\Http\Resources\Api\UserResource;
use App\User;
use DB;

class CreateAdminController extends Controller
{

    public function __construct(){

        $this->middleware('superadmin');
        
    }

    //create admin user
    public function createAdmin(AdminCreateRequest $request){

        DB::beginTransaction();
        
        try {

            $request["password"] = bcrypt($request->password);

            $user = User::Create($request->all()); //store user information

            $user->assignRole('admin'); //assign admin role
            
            $userResource =  new UserResource($user);

            DB::commit();

            return $this->respondCreated($userResource,"Admin Created Successfully");

        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondWithError( "Something went wrong.");
        }
    }

}
