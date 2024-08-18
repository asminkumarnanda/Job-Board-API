<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\JobResource;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $jobs = $request->user()->jobs;
        $data = JobResource::collection($jobs);
        return $this->sendResponse($data, 'Jobs Retrived Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'required|numeric',
        ]);

        try {
            $job = $request->user()->jobs()->create($request->all());
            $data = new JobResource($job);
            return $this->sendResponse($data, 'Job Created Successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to create job.', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $job = Job::findOrFail($id);
            
            $data = new JobResource($job);
            return $this->sendResponse($data, 'Job Retrieved Successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->sendError('Job not found.', ['error' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve job details.', ['error' => $e->getMessage()], 500);
        }
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'company' => 'sometimes|string|max:255',
            'location' => 'sometimes|string|max:255',
            'salary' => 'sometimes|numeric',
        ]);
    
        try {
            $job = Job::findOrFail($id); 
    
            $updateData = $request->only(['title', 'description', 'company', 'location', 'salary']);
            
            if (empty($updateData)) {
                return $this->sendError('No data provided for update.', ['error' => 'Empty request data'], 400);
            }
    
            $job->update($updateData);
    
            $data = new JobResource($job);
    
            return $this->sendResponse($data, 'Job Updated Successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->sendError('Job not found.', ['error' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return $this->sendError('Failed to update job.', ['error' => $e->getMessage()], 500);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $job = Job::findOrFail($id); 
    
            $job->delete();
    
            return response()->json([
                'success' => true,
                'message' => "Job deleted successfully",
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->sendError('Job not found.', ['error' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return $this->sendError('Failed to delete job.', ['error' => $e->getMessage()], 500);
        }
    }
    public function getAllJobs() {
        
        $data = JobResource::collection(Job::all());
        return $this->sendResponse($data, 'Jobs Retrived Successfully');
    }


    public function search(Request $request)
    {
        $query = Job::query();

        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->has('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        $jobs = $query->get();

        $data = JobResource::collection($jobs);

        return $this->sendResponse($data, 'Jobs Retrieved Successfully');
    }
}
