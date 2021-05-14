<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassAttendancesController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\SubjectsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('user', [AuthController::class, 'test']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('subjectsByUser', [SubjectsController::class, 'subjectsByUser']);
    Route::resource('subjects', SubjectsController::class);

    Route::post('students', [StudentsController::class, 'store']);
    Route::delete('students/{subjectId}/{studentId}', [StudentsController::class, 'destroy']);

    Route::post('class_attendance', [ClassAttendancesController::class, 'store']);
});
