<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Api\CompanyResource;
use App\Http\Resources\EmployeeResourceCollection;
use App\Company;
use App\Employee;

class AdminFetchOperationsController extends Controller
{

    public function __construct(){

        $this->middleware('check-role:superadmin,admin');
        
    }

    public function fetchCompanies(){
        try {

            $companies = Company::orderBy('created_at', 'DESC')->paginate(10);

            $companyResource =  π::collection($companies);
            
            return $companyResource
                        ->additional([
                            'status' => true,
                            'message' => 'Companies Fetched succesfully.',
                        ])
                        ->response()
                        ->setStatusCode(200);

        } catch (\Exception $e) {
            return $this->respondWithError( "Something went wrong.");
        }
    }

    public function fetchEmployees(){
        try {

            $employees = Employee::orderBy('created_at', 'DESC')->paginate(10);

            $employeeResource =  EmployeeResourceCollection::collection($employees);
            
            return $employeeResource
                        ->additional([
                            'status' => true,
                            'message' => 'All Employees Fetched succesfully.',
                        ])
                        ->response()
                        ->setStatusCode(200);

        } catch (\Exception $e) {
            return $this->respondWithError( "Something went wrong.");
        }
    }

    public function fetchCompanyEmployees(Company $company){
        try {

            $employees = $company->employee()->orderBy('created_at', 'DESC')->paginate(10);

            $employeeResource =  EmployeeResourceCollection::collection($employees);
            
            return $employeeResource
                        ->additional([
                            'status' => true,
                            'message' => 'Company Employees Fetched succesfully.',
                            'company' => $company->name
                        ])
                        ->response()
                        ->setStatusCode(200);

        } catch (\Exception $e) {
            \Log::info($e);
            return $this->respondWithError( "Something went wrong.");
        }
    }

}
