<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

//use Illuminate\Support\Facades\Log;
// Log::debug(print_r($this, true));

// Authentication route
Route::group([
    "middleware" => ["api", "json.response"],
    "namespace" => "App\Http\Controllers",
    "prefix" => "auth"
], function ($router) {
    Route::post("register", [AuthController::class, "register"]);
    Route::post("login", [AuthController::class, "login"]);
    Route::post("logout", [AuthController::class, "logout"]);

    // Route::get("login", function () {
    //     return true;
    // })->name("login");

    // Route::get("me", [AuthController::class, "me"]);
    //Route::post("refresh", [AuthController::class, "refresh"]);
});
