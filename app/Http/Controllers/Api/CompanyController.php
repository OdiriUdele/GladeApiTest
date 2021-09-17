<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CompanyService;
use App\Http\Resources\Api\CompanyResource;
use App\Http\Requests\Api\CreateCompanyRequest;
use App\Http\Requests\Api\UpdateCompanyRequest;
use App\Company;
use App\User;
use DB;

class CompanyController extends Controller
{
    protected $companyService;

    public function __construct(CompanyService $companyService){
        $this->companyService = $companyService;
        $this->middleware('check-role:admin,superadmin');
        
    }

    public function create(CreateCompanyRequest $request){


        DB::beginTransaction();
        
        try {

            $user = $request->user();

            $name = str_replace(' ', '', $request->name);

            $companyUser = User::firstOrCreate(
                ['email' => $request->email ? $request->email : $name.'@'.$name.'.com'],
                ['password' => bcrypt('password')]
            );

            $data = $this->companyService->buildCompanyData();

            $data['company_admin_user'] = $companyUser->id;

            $company = $user->createdCompanies()->create($data);   

            if ($request->hasFile('logo')) {
                $company = $this->companyService->updateLogo($request, $company);
            }

            $companyUser->assignRole('company');

            $companyResource =  new CompanyResource($company);

            if ($request->email) {
               $this->companyService->sendCompanyNotificationEmail($request->email, $company, 'password');
            }

            $this->companyService->sendAdminCompanyNotificationEmail('superadmin@admin.com', $company);

            DB::commit();

            return $this->respondCreated($companyResource,"Company Created Successfully");
            
        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondWithError( "Something went wrong.");
        }
    }

    public function read(Company $company){

        try {
            $response['status'] = true;
            $response['message'] = "Company Records Fetched Successfully.";
            $response['data'] = new CompanyResource($company);

            return $this->respond($response);
        } catch (\Exception $e) {
            return $this->respondWithError( "Something went wrong.");
        }
    }

    public function update(UpdateCompanyRequest $request, Company $company){
        
        DB::beginTransaction();

        try {
            if ($request->hasFile('logo')) {
                $company = $this->companyService->updateLogo($request, $company);            
            }

            $companyUpdate = $company->update($this->companyService->buildCompanyData());   

            $response['status'] = true;
            $response['message'] = "Company Updated succesfully.";
            $response['data'] = new CompanyResource($company->refresh());

            DB::commit();

            return $this->respond($response);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondWithError( "Something went wrong.");
        }
    }

    public function delete(Company $company){
        
        DB::beginTransaction();

        try {

            $company->user->roles()->detach();

            $company->user->delete();

            $company->delete(); 

            $response['status'] = true;
            $response['message'] = "Company Deleted succesfully.";

            DB::commit();

            return $this->respond($response);

        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondWithError( "Something went wrong.");
        }
    }

    
}
