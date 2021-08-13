<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\studentController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//add student data into students table
Route::post('register',[studentController::class,'register']);
//add faculty data into faculty
Route::post('AddFaculty',[studentController::class,'AddFaculty']);
 
//middelware for token after Login
Route::group(['middleware' => 'auth:sanctum'], function(){
    //All secure URL's
    Route::get('showStudent',[studentController::class,'showStudent']);
    //to update student data in student Controller by user
   Route::put('updateStudent/{id}',[studentController::class,'updateStudent']);

    });

//for login of student
Route::post('login',[studentController::class,'login']);

//to register user
Route::post('addUser',[studentController::class,'addUser']);
Route::post('loginUser',[studentController::class,'loginUser']);
//delete Student Data 
Route::delete('deleteStudent/{id}',[studentController::class,'deleteStudent']);

 
