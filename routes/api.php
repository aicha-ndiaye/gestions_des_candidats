<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\candidature;
use App\Http\Controllers\CandidatureController;
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
route::get("listeCandidats",[UserController::class,"listeCandidats"])->middleware("auth:api");

route::post("create",[FormationController::class,'create'])->middleware("auth:api");
route::get("index_Formation",[FormationController::class,"index_Formation"]);
route::post("update/{id}",[FormationController::class,'update'])->middleware("auth:api");
route::get("destroy/{id}",[FormationController::class,'destroy'])->middleware("auth:api");


route::post("enregistrerCandidature",[CandidatureController::class,'enregistrerCandidature'])->middleware("auth:api");
route::get("accepterCandidature/{id}",[CandidatureController::class,'accepterCandidature'])->middleware("auth:api");
route::get("refuserCandidature/{id}",[CandidatureController::class,'refuserCandidature'])->middleware("auth:api");
route::get("indexCandidature",[CandidatureController::class,'indexCandidature'])->middleware("auth:api");
route::get("candidatsAcceptes",[CandidatureController::class,'candidatsAcceptes'])->middleware("auth:api");
route::get("candidatsRefuses",[CandidatureController::class,'candidatsRefuses'])->middleware("auth:api");
