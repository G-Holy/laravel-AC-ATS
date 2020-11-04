<?php

use App\Http\Controllers\AccessRight\MissionUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\UserController;

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

// $router->middleware('auth:api')->get('/user', function (Request $request) {
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
    $router->post("register", [AuthController::class, "register"]);
    $router->post("login", [AuthController::class, "login"]);
    $router->post("logout", [AuthController::class, "logout"]);
    // $router->post("refresh", [AuthController::class, "refresh"]);
});


// OPTI Utiliser des routes ressources
// OPTI Ranger les routes dans des dossier

Route::group([
    "middleware" => ["api", "json.response"],
    "namespace" => "App\Http\Controllers",
    "prefix" => "user"
], function ($router) {
    $router->get("me", [UserController::class, "me"]);
});

Route::group([
    "middleware" => ["api", "json.response"],
    "namespace" => "App\Http\Controllers",
    // "prefix" => 
], function ($router) {
    $router->post('mission/{mission}/user/{user}/attach', [MissionUserController::class, "attachUser"]);
    $router->post('mission/{mission}/user/{user}/detach', [MissionUserController::class, "detachUser"]);
});

Route::group([
    "middleware" => ["api", "json.response"],
    "namespace" => "App\Http\Controllers",
    // "prefix" => "mission"
], function ($router) {
    $router->post("mission", [MissionController::class, "create"]);
    $router->post("mission/{mission}", [MissionController::class, "edit"])->middleware("can:share,mission");
    $router->get("mission/getReadable", [MissionController::class, "getReadable"]);
});
