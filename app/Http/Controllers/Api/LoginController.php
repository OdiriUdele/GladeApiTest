<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\Api\UserResource;
use JWTAuth;
use App\User;

class LoginController extends Controller
{
    //login user
    public function login(LoginRequest $request){

        $credentials = request(['email', 'password']);
        try {
            if (!$token = JWTAuth::attempt($credentials)) {//check user credentials

                return $this->respondWithError( "Invalid login details supplied.",401);
            }

            $user = User::where('email',$request->email)->first(); //fetch user
            
            $response['status'] = true;
            $response['message'] = 'Login Successful';
            $response['token'] = $token;
            $response['token_type'] = 'bearer';
            $response['token_expires_in'] = auth()->factory()->getTTL() * 60;

            $response['user'] =  new UserResource($user);

            return $this->respond($response);

        } catch(\Exception $e) {
            return $this->respondWithError( "Something went wrong.");

        } catch (\JWTException $e) {
            return $this->respondWithError( "Could not create token.");
        }
    }
}
