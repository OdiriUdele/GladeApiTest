<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $statusCode = 200;


    /**
     * @return mixed
     * return status code
     */
    public function getStatusCode()
    {

    	return $this->statusCode;

    }

    /**
     *
     * @param mixed $statusCode
     * set status code
     */
    public function setStatusCode($statusCode)
    {

    	$this->statusCode = $statusCode;

    	return $this;
    }

    /**
     *
     * @param mixed $statusCode
     * set status code
     */
    public function respond($data, $headers = [])
    {

    	return response()->json($data, $this->getStatusCode(), $headers);

    }

    /**
     *
     * @param mixed $message
     * response message for create operation
     */
    public function respondCreated($data, $message = 'Created Successfully!')
    {

    	return $this->setStatusCode(201)->respond([
            
            'status' =>true,
    		'message' => $message,
            'data' => $data,

    	]);

    }

    /**
     *
     * @param mixed $message
     * custom response on error
     */
    public function respondWithError($message, $code = "500")
    {

    	return $this->setStatusCode($code)->respond([
    		
            'status'=>false,
            'message' => $message
    		
    	]);
    }
}
