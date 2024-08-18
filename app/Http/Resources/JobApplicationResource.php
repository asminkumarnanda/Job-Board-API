<?php

namespace App\Http\Resources;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {

        $applicant = new UserResource($this, [
            'applied_date' => date('d-m-Y',strtotime($this->created_at)),
            'applied_time' =>date('H:i:s',strtotime($this->created_at)),
        ]);

        return $applicant;
        
    }
}
