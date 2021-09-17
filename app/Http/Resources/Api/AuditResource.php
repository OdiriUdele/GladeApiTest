<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class AuditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        static::$wrap = "data";
        return [
            'company' => $this->name,
            'created_by' => $this->createdBy->email,
            'admin_id' => $this->createdBy->id,
            'created_on' => \Carbon\Carbon::parse($this->created_at)->format('Y-m-d')
        ];
    }
}
