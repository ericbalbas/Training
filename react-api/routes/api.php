<?php

use App\Http\Controllers\Api\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('students',[StudentController::class, 'index']); // fetch all
Route::post('students',[StudentController::class, 'store']);    // create new
Route::get('students/{id}',[StudentController::class, 'show']);     //showw only 1
Route::get('students/{id}/edit',[StudentController::class, 'edit']);    // edit part
Route::put('students/{id}/edit',[StudentController::class, 'update']);      //update student record
Route::delete('students/{id}/delete',[StudentController::class, 'destroy']);    //delete data
