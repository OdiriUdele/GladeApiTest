<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CompanyResource;
use App\Http\Resources\EmployeeResourceCollection;
use Illuminate\Http\Request;

class CompanyAndEmployeeController extends Controller
{

    public function viewEmployeesByCompanyAccount(){
        try {
            $company = request()->user()->company;

            $employees = $company->employee()->paginate(10);

            $employeeResource =  EmployeeResourceCollection::collection($employees);
            
            return $employeeResource
                        ->additional([
                            'status' => true,
                            'message' => 'Company Employees Fetched succesfully.',
                        ])
                        ->response()
                        ->setStatusCode(200);

        } catch (\Exception $e) {
            return $this->respondWithError( "Something went wrong.");
        }
    }

    public function viewCompanyByEmployeeAccount(){
        try {
            $employee = request()->user()->employee;

            $company = $employee->companyData;

            $companyResource =  new CompanyResource($company);
            
            $response['status'] = true;
            $response['message'] = 'Company Records Fetched Successfully.';
            $response['data'] = $companyResource;

            return $this->respond($response);

        } catch (\Exception $e) {
            return $this->respondWithError( "Something went wrong.");
        }
    }
}
