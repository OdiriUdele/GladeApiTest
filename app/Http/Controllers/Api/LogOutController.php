<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class LogOutController extends Controller
{
    public function logout() {

        try {
            Auth::guard('api')->logout();
        
            return response()->json([
                'status' => true,
                'message' => 'User logged out.'
            ], 200);

        } catch (\Exception $e) {
            return $this->respondWithError( "Something went wrong.");
        }
    }
}
