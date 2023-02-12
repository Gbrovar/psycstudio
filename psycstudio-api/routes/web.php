<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TherapistController;


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
Route::get("/test", [UserController::class, "pruebas"]);
Route::post("/api/user/register", [UserController::class, "register"]);
Route::post("/api/user/login", [UserController::class, "login"]);
Route::post("/api/user/token-control", [UserController::class, "tokenControl"]);
Route::put("/api/user/update", [UserController::class, "update"]);
Route::post("/api/user/upload", [UserController::class, "upload"])->middleware(ApiAuthMiddleware::class);
Route::get("/api/user/avatar/{filename}", [UserController::class, "getImage"]);


//Therapist Routes
Route::post("/api/therapist/register", [TherapistController::class, "register"]);
Route::post("/api/therapist/login", [UserController::class, "login"]);
Route::post("/api/therapist/token-control", [UserController::class, "tokenControl"]);
Route::put("/api/therapist/update", [UserController::class, "update"]);
Route::post("/api/therapist/upload", [UserController::class, "upload"])->middleware(ApiAuthMiddleware::class);
Route::get("/api/therapist/avatar/{filename}", [UserController::class, "getImage"]);

