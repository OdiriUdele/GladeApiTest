<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CompanyAuditService;
use App\Http\Requests\Api\AuditRequest;
use App\Http\Resources\Api\AuditResource;
use Illuminate\Http\Request;

class CompanyCreationAuditController extends Controller
{
    public function __construct(){

        $this->middleware('superadmin');
    }

    public function audit(AuditRequest $request){

        try {
            $companyCreationAudit = new CompanyAuditService($request);

            $companies = $companyCreationAudit->search();
            
            $companyResource =  AuditResource::collection($companies);
            
            return $companyResource
                        ->additional([
                            'status' => true,
                            'message' => 'Records Fetched succesfully.',
                        ])
                        ->response()
                        ->setStatusCode(200);


        } catch (\Exception $e) {
            \Log::info($e);
            return response(["message" => "Something went wrong. ".$e->getMessage(), "status" => false], 500);
        }
    }

}
