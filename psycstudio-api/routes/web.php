<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TherapistController;
use App\Http\Controllers\TherapistAgendaController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Classes
use App\Http\Middleware\ApiAuthMiddleware;

Route::get('/', function () {
    return "<h1> Welcome to PsycStudio. </h1>";
    //return view('welcome');
});

// User Routes
Route::post("/api/user/register", [UserController::class, "register"]);
Route::post("/api/user/login", [UserController::class, "login"]);
Route::post("/api/user/token-control", [UserController::class, "tokenControl"]);
Route::put("/api/user/update", [UserController::class, "update"]);
Route::post("/api/user/upload", [UserController::class, "upload"])->middleware(ApiAuthMiddleware::class);
Route::get("/api/user/avatar/{filename}", [UserController::class, "getImage"]);
Route::get("/api/user/detail/{id}", [UserController::class, "detail"]);


//Therapist Routes
Route::post("/api/therapist/register", [TherapistController::class, "register"]);
Route::post("/api/therapist/login", [TherapistController::class, "login"]);
Route::post("/api/therapist/token-control", [TherapistController::class, "tokenControl"]);
Route::put("/api/therapist/update", [TherapistController::class, "update"]);
Route::post("/api/therapist/upload", [TherapistController::class, "upload"])->middleware(ApiAuthMiddleware::class);
Route::get("/api/therapist/avatar/{filename}", [TherapistController::class, "getImage"]);
Route::get("/api/therapist/detail/{id}", [TherapistController::class, "detail"]);

//Agenda Therapist Routes
Route::resource("/api/therapist-agenda", TherapistAgendaController::class);

