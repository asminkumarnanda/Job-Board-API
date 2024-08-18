<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Http\Resources\JobApplicationResource;
use App\Http\Resources\JobResource;
use App\Models\Job;

class JobApplicationController extends BaseController
{
    public function store(Request $request, $id)
    {
        $job = Job::find($id);
     
        if (!$job) {
            return $this->sendError('Job not found',[], 404);
        }

      
        if ($request->user()->jobApplications()->where('job_id', $job->id)->exists()) {
            return $this->sendError('You have already applied for this job',[], 200);
        }

   
        $request->user()->jobApplications()->attach($job);

        return $this->sendResponse([], 'Application submitted successfully');
     
     
    }

    public function index($id)
    {
        $job = Job::find($id);
        if (!$job) {
            return $this->sendError('Job not found',[], 404);
        }
      
        $jobApplications =  JobApplicationResource::collection($job->applications);
 

        return response()->json([
            'success' => true,
            'data'    => $jobApplications,
            'job_details'=> new JobResource($job),
            'message' => 'Job applications retrived successfully',
        ],200);
        

    }
}
