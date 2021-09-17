<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\EmployeeResource;
use App\Http\Resources\EmployeeResourceCollection;
use Illuminate\Http\Request;

class ViewCompanyEmployeesController extends Controller
{

    public function __construct() {
        $this->middleware('check-role:admin,superadmin,company');    
    }

    public function viewEmployeesByCompanyAccount(){
        try {
            $company = request()->user()->company;

            $employees = $company->employee()->paginate(10);

            $employeeResource =  EmployeeResourceCollection::collection($employees);
            
            return $employeeResource->additional([
                'status' => true,
                'message' => "Company Employees Fetched succesfully.",
            ]);

        } catch (\Exception $e) {
            return $this->respondWithError( "Something went wrong.");
        }
    }
}
