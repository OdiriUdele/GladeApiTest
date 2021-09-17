<?php
namespace App\Services;

use Carbon\Carbon;
use App\Interfaces\AuditInterface;
use Illuminate\Support\Str;
use App\Company;

class CompanyAuditService implements AuditInterface{
    
    public $query;
    public $perPage;
    public $orderBy;
    public $orderDirection;
    public $adminEmail;
    public $adminId;
    public $company;
    public $dateFrom;
    public $dateTo;


    public function __construct($parameters){
        $this->setLocalParameters($parameters);
        $this->query = Company::query();
    }

    /**
     * set the parameters
     *
     * @param  array $parameters
     * @return mixed
     */
    private function setLocalParameters($parameters){
        $this->perPage =  10;
        $this->orderBy = 'created_at';
        $this->orderDirection = 'DESC';
        $this->adminEmail = $parameters->filled('admin_email') ? $parameters->admin_email : '';
        $this->adminId = $parameters->filled('admin_id') ? $parameters->admin_id : '';
        $this->company = $parameters->filled('company') ? $parameters->company : '';
        $this->dateFrom = $parameters->filled('date_from') ? $parameters->date_from : '';
        $this->dateTo = $parameters->filled('date_to') ? $parameters->date_to : '';
    }

    public function search(){
        //$this->applySearch();
        $this->applyOrder();

        if ($this->dateFrom != null && $this->dateTo != null && $this->dateFrom != '' && $this->dateTo != '') {
            $dateFrom = date($this->dateFrom);
            $begin = date("Y-m-d",strtotime($dateFrom));
            $dateTo = date($this->dateTo);
            $end = date("Y-m-d",strtotime($dateTo . ' +1 day'));
            $this->query->whereBetween('created_at',[$begin,$end]);
        }
        $records = null;

        $records = $this->query->paginate($this->perPage);

        return $records;
    }

    private function applyOrder(){
        $this->query->orderBy($this->orderBy, $this->orderDirection);
    }

    public function applySearch()
    {
        if( $this->company != '' ){
            $company = urldecode( $this->company );

            $this->query->where(function ($query) use ($company){
                $query->where('name', 'LIKE', '%'.$company.'%');
            });
        }

        if( $this->adminEmail != '' ){
            $adminEmail = urldecode( $this->adminEmail );

            $this->query->where(function ($query) use ($adminEmail){
                $query->WhereHas('createdBy', function ($query) use ($adminEmail){
                    $query->where( 'email', 'LIKE', '%'.$adminEmail.'%');
                });
            });
        }

        if( $this->adminId != '' ){
            $adminId = urldecode( $this->adminId );

            $this->query->where('created_by', $admminId);
        }
    }

}