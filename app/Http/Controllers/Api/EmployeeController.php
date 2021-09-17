<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Api\EmployeeResource;
use App\Http\Requests\Api\CreateEmployeeRequest;
use App\Http\Requests\Api\UpdateEmployeeRequest;
use App\Employee;
use App\Company;
use App\User;
use DB;

class EmployeeController extends Controller
{
    public function __construct(){
        $this->middleware('check-role:admin,superadmin,company');
        
    }

    //set employee creation details
    public function buildEmployeeData(){

        $data = request()->only(["first_name", "last_name", "email", "phone", "company"]);
        //$data['created_by'] = auth()->user()->id;
        return $data;
    }

    public function create(CreateEmployeeRequest $request){

        DB::beginTransaction();
        
        try {

            $user = $request->user();

            $company = Company::find($request->company);

            $employeeName = str_replace(' ', '', $request->first_name).str_replace(' ', '', $request->last_name);
            $companyName = str_replace(' ', '', $company->name);

            $employeeUser = User::firstOrCreate(
                ['email' => $request->email ? $request->email : $employeeName.'@'.$companyName.'.com'],
                ['password' => bcrypt('password')]
            );

            $data = $this->buildEmployeeData();

            $data['employee_user_id'] = $employeeUser->id;

            $employee = Employee::create($data);   

            $employeeUser->assignRole('employee');

            $companyResource =  new EmployeeResource($employee);

            DB::commit();

            return $this->respondCreated($companyResource,"Employee Created Successfully");
            
        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondWithError( "Something went wrong.");
        }
    }

    public function read(Employee $employee){

        try {
            $response['status'] = true;
            $response['message'] = "Employee Records Fetched Successfully.";
            $response['data'] = new EmployeeResource($employee);

            return $this->respond($response);
        } catch (\Exception $e) {
            return $this->respondWithError( "Something went wrong.");
        }
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee){
        
        DB::beginTransaction();

        try {

            $employeeUpdate = $employee->update($this->buildEmployeeData());   

            $employee->user->update([
                'email' => $request->email?:$employee->user->email
            ]);

            $response['status'] = true;
            $response['message'] = "Employee Updated succesfully.";
            $response['data'] = new EmployeeResource($employee->refresh());

            DB::commit();

            return $this->respond($response);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondWithError( "Something went wrong.");
        }
    }

    public function delete(Employee $employee){
        
        DB::beginTransaction();

        try {

            $employee->user->roles()->detach();

            $employee->user->delete();

            $employee->delete();  

            $response['status'] = true;
            $response['message'] = "Employee Deleted succesfully.";

            DB::commit();

            return $this->respond($response);

        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondWithError( "Something went wrong.");
        }
    }
}
