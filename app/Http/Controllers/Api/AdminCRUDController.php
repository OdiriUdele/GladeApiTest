<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\AdminCreateRequest;
use App\Http\Resources\Api\UserResource;
use App\User;
use DB;

class AdminCRUDController extends Controller
{

    public function __construct(){

        $this->middleware('check-role:superadmin,admin');
        
    }

    //create admin user
    public function create(AdminCreateRequest $request){

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


    public function delete(User $admin){
        
        DB::beginTransaction();

        try {

            if(!$admin->hasRole('admin')){
                return $this->respondWithError( "User is not an Admin.", 422);
            }
            $admin->roles()->detach();

            $admin->delete();

            $response['status'] = true;
            $response['message'] = 'Admin User Deleted succesfully.';

            DB::commit();

            return $this->respond($response);

        } catch (\Exception $e) {
            \Log::info($e);
            DB::rollback();
            return $this->respondWithError( "Something went wrong.");
        }
    }

}
