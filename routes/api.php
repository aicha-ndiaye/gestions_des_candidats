<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\UserRoleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('ajouterCandidat', [UserController::class, 'ajouterCandidat']);
Route::post('/ajouterRole', [UserRoleController::class, 'ajouterRole']);
route::post("ajouterAdmin",[UserController::class,"ajouterAdmin"]);
route::post("login",[UserController::class,"login"]);
route::get("index",[UserController::class,"index"]);

route::post("create",[FormationController::class,'create']);
route::get("index_Formation",[FormationController::class,"index_Formation"]);
route::post("update",[FormationController::class,'update']);
route::get("archiver_formation",[FormationController::class,'archiver_formation']);
route::get("accepter",[FormationController::class,'accepter']);
route::get("refuser",[FormationController::class,'refuser']);
