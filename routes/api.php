<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\JobApplicationController;
use App\Http\Controllers\API\JobController;

   
Route::controller(AuthController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});


Route::middleware('auth:sanctum')->group( function () {
    Route::apiResource('jobs',JobController::class);
    Route::get('get-all-jobs',[JobController::class,'getAllJobs']);
    Route::post('jobs/{job}/apply', [JobApplicationController::class, 'store']);
    Route::get('jobs/{job}/applications', [JobApplicationController::class, 'index']);
    Route::get('jobs-search', [JobController::class, 'search']);
});
